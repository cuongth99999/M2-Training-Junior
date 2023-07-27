<?php

namespace Magenest\DeliveryTime\Ui\Component\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class ShippingInfomation extends Column
{
    public function __construct
    (
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Sales\Model\OrderRepository $orderRepository,
        array $components = [],
        array $data = []
    )
    {
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource["data"]["items"])) {
            foreach ($dataSource["data"]["items"] as $key => $item) {
                $order = $this->orderRepository->get($dataSource["data"]["items"][$key]['entity_id']);
                $dataSource["data"]["items"][$key]['shipping_information'] =
                    $order->getShippingAddress()->getDeliveryDate().'</br>'.
                    $order->getShippingAddress()->getDeliveryTimeInterval().'</br>'.
                    $order->getShippingAddress()->getDeliveryComment().'</br>'.
                    $dataSource["data"]["items"][$key]['shipping_information'];
            }
        }

        return $dataSource;
    }
}
