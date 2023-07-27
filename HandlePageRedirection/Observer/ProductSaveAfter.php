<?php
namespace Magenest\HandlePageRedirection\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\UrlRewrite\Model\UrlRewriteFactory;

class ProductSaveAfter implements ObserverInterface
{
    protected $urlRewriteFactory;

    public function __construct(
        UrlRewriteFactory $urlRewriteFactory
    ) {
        $this->urlRewriteFactory = $urlRewriteFactory;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getProduct();

        // Kiểm tra nếu special price nhỏ hơn base price
        if ($product->getSpecialPrice() < $product->getPrice() && !empty($product->getSpecialPrice())) {
            $product->setUrlKey('sale/'.$product->getSku());
            // Tạo URL rewrite rule
            $urlRewrite = $this->urlRewriteFactory->create();
            $urlRewrite->setEntityType('product')
                ->setEntityId($product->getId())
                ->setStoreId(1)
                ->setRequestPath('sale/' . $product->getSku().'.html')
                ->setTargetPath('catalog/product/view/id/' . $product->getId())
                ->setRedirectType(0)
                ->setDescription('Sale Product')
                ->save();
        }
    }
}
