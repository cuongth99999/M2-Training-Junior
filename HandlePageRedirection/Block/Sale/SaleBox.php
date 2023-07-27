<?php

namespace Magenest\HandlePageRedirection\Block\Sale;

use Magento\Framework\View\Element\Template;

class SaleBox extends Template
{
    public function __construct
    (
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory  $productCollectionFactory,
        \Magento\Catalog\Block\Product\ListProduct $listProduct,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        array $data = []
    )
    {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->productRepository = $productRepository;
        $this->listProduct = $listProduct;
        parent::__construct($context, $data);
    }

    public function getProductSaleOffJsonData()
    {
        $data = [];
        $productCollection = $this->productCollectionFactory->create();
        foreach ($productCollection as $item)
        {
            $product = $this->productRepository->getById($item['entity_id']);
            $specialPrice = $product->getPriceInfo()->getPrice('special_price');
            if (!empty($specialPrice->getSpecialPrice())) {
                if ($product->getPrice() > $specialPrice->getSpecialPrice()) {
                    $productImage = 'media/catalog/product'.$product->getThumbnail();
                    $data[] = [
                        'url' => $item->getProductUrl(),
                        'image' => $productImage,
                        'name' => $item->getSku()
                    ];
                }
            }
        }
        return json_encode($data);
    }
}
