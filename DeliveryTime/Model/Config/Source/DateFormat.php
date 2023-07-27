<?php

namespace Magenest\DeliveryTime\Model\Config\Source;

class DateFormat implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'yyyy-mm-dd', 'label' => __('yyyy-mm-dd ('.date('Y-m-d'). ')')],
            ['value' => 'mm/dd/yyyy', 'label' => __('mm/dd/yyyy ('.date('m/d/Y'). ')')],
            ['value' => 'dd/mm/yyyy', 'label' => __('dd/mm/yyyy ('.date('d/m/Y'). ')')],
            ['value' => 'd/m/yy', 'label' => __('d/m/yy ('.date('d/m/y'). ')')],
            ['value' => 'd/m/yyyy', 'label' => __('d/m/yyyy ('.date('d/m/Y'). ')')],
            ['value' => 'dd.mm.yyyy', 'label' => __('dd.mm.yyyy ('.date('d.m.Y'). ')')],
            ['value' => 'dd.mm.yy', 'label' => __('dd.mm.yy ('.date('d.m.y'). ')')],
            ['value' => 'd.m.yy', 'label' => __('d.m.yy ('.date('d.m.y'). ')')],
            ['value' => 'd.m.yyyy', 'label' => __('d.m.yyyy ('.date('d.m.Y'). ')')],
            ['value' => 'dd-mm-yy', 'label' => __('dd-mm-yy ('.date('d-m-y'). ')')],
            ['value' => 'yyyy.mm.dd', 'label' => __('yyyy.mm.dd ('.date('Y.m.d'). ')')],
            ['value' => 'dd-mm-yyyy', 'label' => __('dd-mm-yyyy ('.date('d-m-Y'). ')')],
            ['value' => 'yyyy/mm/dd', 'label' => __('yyyy/mm/dd ('.date('Y/m/d'). ')')],
            ['value' => 'yy/mm/dd', 'label' => __('yy/mm/dd ('.date('y/m/d'). ')')],
            ['value' => 'dd/mm/yy', 'label' => __('dd/mm/yy ('.date('d/m/y'). ')')],
            ['value' => 'mm/dd/yy', 'label' => __('mm/dd/yy ('.date('m/d/y'). ')')],
            ['value' => 'dd/mm yy', 'label' => __('dd/mm yy ('.date('d/m y'). ')')],
            ['value' => 'yyyy mm dd', 'label' => __('yyyy mm dd ('.date('Y m d'). ')')],
        ];
    }
}
