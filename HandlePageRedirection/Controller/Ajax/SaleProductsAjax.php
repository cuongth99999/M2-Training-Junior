<?php
namespace Magenest\HandlePageRedirection\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class SaleProductsAjax extends \Magento\Framework\App\Action\Action
{
    protected $resultJsonFactory;
    protected $productCollectionFactory;

    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        CollectionFactory $productCollectionFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $result = $this->resultJsonFactory->create();

        // Lấy danh sách các sản phẩm đang sale
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToFilter('special_price', ['notnull' => true]);
        $productCollection->addAttributeToFilter('special_price', ['lt' => new \Zend_Db_Expr('price')]);
        $productCollection->addAttributeToSelect(['name', 'image']);

        $saleProducts = [];
        foreach ($productCollection as $product) {
            $saleProducts[] = [
                'name' => $product->getName(),
                'image' => $product->getImageUrl(),
                'url' => $product->getUrlModel()->getUrl($product),
            ];
        }

        return $result->setData($saleProducts);
    }
}
