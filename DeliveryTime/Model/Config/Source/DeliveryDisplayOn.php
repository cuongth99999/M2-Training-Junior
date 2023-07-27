<?php

namespace Magenest\DeliveryTime\Model\Config\Source;

class DeliveryDisplayOn implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'admin_sales_order_view', 'label' => __('Order View Page (Backend)')],
            ['value' => '1', 'label' => __('New/Edit/Reorder Order Page (Backend)')],
            ['value' => 'admin_sales_order_invoice_view', 'label' => __('Invoice View Page (Backend)')],
            ['value' => 'admin_sales_order_shipment_view', 'label' => __('Shipment View Page (Backend)')],
            ['value' => 'sales_order_view', 'label' => __('Order Info Page (Frontend)')]
        ];
    }
}
