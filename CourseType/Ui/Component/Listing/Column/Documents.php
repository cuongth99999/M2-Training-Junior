<?php

namespace Magenest\CourseType\Ui\Component\Listing\Column;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Documents extends Column
{
    protected $productRepository;

    public function __construct(
        ContextInterface           $context,
        UiComponentFactory         $uiComponentFactory,
        ProductRepositoryInterface $productRepository,
        array                      $components = [], array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->productRepository = $productRepository;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            $fieldName = $this->getData("name");
            foreach ($dataSource["data"]["items"] as $key => $item) {
                $this->productRepository->cleanCache();
                $product = $this->productRepository->getById($item['entity_id']);
                $doc = $product->getResource()->getAttribute('document')->getFrontend()->getValue($product);
                $html = $doc;

                $dataSource["data"]["items"][$key][$fieldName] = $html;
            }
        }

        return $dataSource;
    }
}
