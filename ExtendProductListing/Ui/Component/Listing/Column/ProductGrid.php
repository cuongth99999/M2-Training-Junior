<?php

namespace Magenest\ExtendProductListing\Ui\Component\Listing\Column;

use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductGrid extends Column
{
    protected $ProductRepositoryInterface;

    public function __construct(
        ContextInterface           $context,
        UiComponentFactory         $uiComponentFactory,
        ProductRepositoryInterface $ProductRepositoryInterface,
        array                      $components = [], array $data = []
    )
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->ProductRepositoryInterface = $ProductRepositoryInterface;
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            $fieldName = $this->getData("name");
            foreach ($dataSource["data"]["items"] as $key => $item) {
                $product = $this->ProductRepositoryInterface->getById($item['entity_id'], false);
                $url = $product->getUrlModel()->getUrlInStore($product, ['_escape' => true]);
                if ($product->getVisibility() == Visibility::VISIBILITY_NOT_VISIBLE) {
                    $html = 'Not Visible Individually';
                } else {
                    $html = "<a style='z-index: 100' target='_blank' href=" . $url . ">";
                    $html .= "View";
                    $html .= "</a>";
                }

                $dataSource["data"]["items"][$key][$fieldName] = $html;
            }
        }

        return $dataSource;
    }
}
