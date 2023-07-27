<?php
namespace Magenest\CourseType\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\UrlInterface;
class Category extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param SearchCriteriaBuilder $criteria
     * @param \Magento\Catalog\Model\ProductFactory $product
     * @param \Magento\Catalog\Model\CategoryFactory $category
     * @param  UrlInterface $urlBuilder
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        SearchCriteriaBuilder $criteria,
        \Magento\Catalog\Model\ProductFactory $product,
        \Magento\Catalog\Model\CategoryFactory $category,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [])
    {
        $this->_urlBuilder = $urlBuilder;
        $this->_searchCriteria = $criteria;
        $this->product = $product;
        $this->category = $category;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $productId = $item['entity_id'];
                $product = $this->product->create()->load($productId);
                $cats = $product->getCategoryIds();
                $categories = [];
                if (count($cats)) {
                    foreach ($cats as $cat) {
                        $category = $this->category->create()->load($cat);
                        $categories[] = $category->getName();
                    }
                }
                $item[$fieldName] = implode(',', $categories);
            }
        }
        return $dataSource;
    }
}
