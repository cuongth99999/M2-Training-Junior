<?php

namespace Magenest\DeliveryTime\Block\Adminhtml\DeliveryTime\Edit\Button;

use Magenest\DeliveryTime\Block\Adminhtml\DeliveryTime\Edit\Button\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class SaveAndContinueButton
 * @package Magenest\GoogleShopping\Block\Adminhtml\Feed\Edit\Button
 */
class SaveAndContinueButton extends GenericButton implements ButtonProviderInterface
{

    /**
     * @return array
     */
    public function getButtonData()
    {
        return $data = [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => [
                    'button' => ['event' => 'saveAndContinueEdit'],
                ],
            ],
            'sort_order' => 80,
        ];
    }
}
