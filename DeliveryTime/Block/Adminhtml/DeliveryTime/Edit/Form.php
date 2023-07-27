<?php

namespace Magenest\DeliveryTime\Block\Adminhtml\DeliveryTime\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_assetRepo;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Magenest\DeliveryTime\Model\Block\CustomerGroupsOptionsProvider $customerGroupsOptionsProvider,
        \Magento\Store\Model\System\Store $storeView,
        array $data = []
    ) {
        $this->_assetRepo = $assetRepo;
        $this->customerGroupsOptionsProvider = $customerGroupsOptionsProvider;
        $this->storeView = $storeView;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {

        $path = $this->_assetRepo->getUrl("Magenest_DeliveryTime::importsample/sample.csv");

        $form = $this->_formFactory->create();
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $storemanager = $objectManager->create('Magento\Store\Model\StoreManagerInterface');

        $fieldset = $form->addFieldset(
            'general',
            [
                'legend' => __('Shiptime Information'),
                'class'  => 'shiptime-information'
            ]
        );

        $fieldset->addField(
            'name',
            'text',
            [
                'label' => __('Name'),
                'name' => 'name',
                'required' => true
            ]
        );

        $fieldset->addField(
            'store_view_id',
            'multiselect',
            [
                'name' => 'store_view_id[]',
                'label' => __('Store View'),
                'title' => __('Store View'),
                'required' => true,
                'values' => $this->storeView->toOptionArray(),
                'disabled' => false
            ]
        );

//        $model->setData('blog_categories', $categories);

        $fieldset->addField(
            'customer_group',
            'multiselect',
            [
                'name' => 'customer_group[]',
                'label' => __('Customer Groups'),
                'title' => __('Customer Groups'),
                'required' => true,
                'values' => $this->customerGroupsOptionsProvider->toOptionArray(),
                'disabled' => false
            ]
        );
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Import Pincodes');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}

