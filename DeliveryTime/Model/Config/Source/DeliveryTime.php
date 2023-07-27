<?php

namespace Magenest\DeliveryTime\Model\Config\Source;

class DeliveryTime implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        $optionArray = [];
        for($val = 0; $val < 24; $val++)
        {
            $optionArray[] = ['value' => (string)$val, 'label' => (string)$val];
        }
        return $optionArray;
    }
}
