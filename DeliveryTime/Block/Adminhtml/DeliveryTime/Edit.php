<?php

namespace Magenest\DeliveryTime\Block\Adminhtml\DeliveryTime;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container as FormContainer;
use Magento\Framework\Registry;

/**
 * Class Index
 *
 * @package Magenest\Slider\Block\Adminhtml\Menu
 */
class Edit extends FormContainer
{
    /**
     * @var Registry
     */
    protected $_coreRegistry;

    /**
     * Constructor.
     *
     * @param Registry $registry
     * @param Context  $context
     * @param array    $data
     */
    public function __construct(
        Registry $registry,
        Context $context,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Magenest_DeliveryTime';
        $this->_controller = 'adminhtml_deliveryTime';
        $this->_mode       = 'edit';
        parent::_construct();

        $this->buttonList->add(
            'preview',
            [
                'label' => __('Preview'),
                'class' => 'preview',
            ],
            1
        );
        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                    ],
                ]
            ],
            1
        );

        $this->buttonList->remove('reset');

    }

    /**
     * Check permission for passed action
     *
     * @param  string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Getter of url for "Save and Continue" button
     * tab_id will be replaced by desired by JS later
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('deliverytime/index/save', ['_current' => true, 'back' => 'edit', 'active_tab' => '']);
    }

}
