<?php
declare(strict_types=1);

namespace Magenest\HandlePageRedirection\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\Action\Redirect;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterInterface;

class RedirectRouter implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private $actionFactory;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;
    protected $filter;
    protected $filterCroup;
    protected $searchCriteria;
    protected $_messageManager;
    protected $productRepository;
    protected $searchQueryCollection;
    protected $urlInterface;

    /**
     * Router constructor.
     *
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Search\Model\ResourceModel\Query\CollectionFactory $searchQueryCollection,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Api\Filter $filter,
        \Magento\Framework\Api\Search\FilterGroup $filterGroup,
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magento\Framework\UrlInterface $urlInterface
    ) {
        $this->filter = $filter;
        $this->filterCroup = $filterGroup;
        $this->searchCriteria = $searchCriteria;
        $this->productRepository = $productRepository;
        $this->_messageManager = $messageManager;
        $this->searchQueryCollection = $searchQueryCollection;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->actionFactory = $actionFactory;
        $this->response = $response;
        $this->urlInterface = $urlInterface;
    }

    /**
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface
    {
        $pathInfo = trim($request->getPathInfo(), '/');
        $keywords = preg_split("/([\/,_,...]+)/", $pathInfo);

        // Nếu path có từ giống tên 1 category 70% trở lên, redirect sang trang category,
        // hiện notice “The path [URL path] does not exist. Are you looking for [tên category]?"
        $categoryCollection = $this->categoryCollectionFactory->create();
        $categoryCollection->addAttributeToSelect('*');
        $categoryCollection->addIsActiveFilter();

        $categories = $categoryCollection;
        $percens = [];

        foreach ($categories as $key => $category) {
            foreach ($keywords as $keyword) {
                similar_text($keyword, (string)$category->getUrlKey(), $percen);
                if(empty($percens[$key]) || $percen > $percens[$key])
                {
                    $percens[$key] = $percen;
                }
            }
        }

        if (max($percens) >= 70) {
            $categoryIdMax = array_keys($percens, max($percens));
            $categoryTarget = ($categoryCollection->getItems())[$categoryIdMax[0]];
            $this->_messageManager->addNoticeMessage(__("The path ".$pathInfo." does not exist. Are you looking for ".$categoryTarget->getName()."?"));
            $this->response->setRedirect($categoryTarget->getUrl(), 302);
            $request->setDispatched(true);
            return $this->actionFactory->create(Redirect::class);
        }

        // Nếu path có từ trùng với 1 search term đã tồn tại -> redirect sang trang tìm kiếm với term này
        $searchQuery = $this->searchQueryCollection->create()->addFieldToFilter('query_text', $keywords);
        if(!empty($searchQuery->getItems()))
        {
            $queryText = $searchQuery->getLastItem()->getQueryText();
            $this->response->setRedirect($this->urlInterface->getBaseUrl().'catalogsearch/result/?q='.$queryText, 302);
            $request->setDispatched(true);
            return $this->actionFactory->create(Redirect::class);
        }

        // Với mỗi từ >=3 ký tự, search product với từ. Nếu có kết quả, redirect sang trang kết quả
        // Nếu không có từ/không từ nào ra kết quả, trả về trang 404 như ban đầu
        foreach ($keywords as $keyword) {
            if (strlen($keyword) >= 3) {
                $filter = $this->filter;
                $filterGroup = $this->filterCroup;
                $searchCriteria = $this->searchCriteria;
                $productRepository = $this->productRepository;
                $filter->setField('sku');
                $filter->setConditionType('like');
                $filter->setValue('%'.$keyword.'%');
                $filterGroup->setData('filters', [$filter]);
                $searchCriteria->setFilterGroups([$filterGroup]);
                $result = $productRepository->getList($searchCriteria);
                $products = $result->getItems();
                if(!empty($products))
                {
                    $this->response->setRedirect($this->urlInterface->getBaseUrl().'catalogsearch/result/?q='.$keyword, 301);
                    $request->setDispatched(true);
                    return $this->actionFactory->create(Redirect::class);
                }
            }
        }

        return null;
    }
}
