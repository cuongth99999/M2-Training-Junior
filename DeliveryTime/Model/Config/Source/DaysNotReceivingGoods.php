<?php

namespace Magenest\DeliveryTime\Model\Config\Source;

class DaysNotReceivingGoods implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '0', 'label' => __('Sunday')],
            ['value' => '1', 'label' => __('Monday')],
            ['value' => '2', 'label' => __('Tuesday')],
            ['value' => '3', 'label' => __('Wednesday')],
            ['value' => '4', 'label' => __('Thursday')],
            ['value' => '5', 'label' => __('Friday')],
            ['value' => '6', 'label' => __('Saturday')]
        ];
    }
}
