<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magenest\CancelOrder\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\Url;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Block\Adminhtml\Order\View\Info as OrderInfo;

class OrderId extends Column
{
    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;


    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Url $urlBuilder
     * @param string $viewUrl
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Url $urlBuilder,
        OrderInfo          $orderInfo,
        OrderInterface     $orderInterface,
        array $components = [],
        array $data = []
    ) {
        $this->_urlBuilder = $urlBuilder;
        $this->orderInfo = $orderInfo;
        $this->orderInterface = $orderInterface;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $nameColumn = $this->getData("name");
            foreach ($dataSource['data']['items'] as &$item) {
                $order = $this->orderInterface->loadByIncrementId($item['increment_id']);
                $textColumn = '';
                if ($nameColumn === 'increment_id') {
                    $textColumn = '#'.$item['increment_id'];
                } elseif ($nameColumn === 'action') {
                    $textColumn = 'View order';
                }
                $item[$nameColumn] = "<a href='".$this->orderInfo
                        ->getUrl('sales/order/view', ['order_id' => $order->getEntityId()])."' target='_blank'>"
                    .$textColumn."</a>";
            }
        }
        return $dataSource;
    }
}
