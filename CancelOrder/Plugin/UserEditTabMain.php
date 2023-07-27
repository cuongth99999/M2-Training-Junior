<?php
namespace Magenest\CancelOrder\Plugin;

use Magento\User\Block\User\Edit\Tab\Main;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Store\Model\ResourceModel\Website\CollectionFactory as WebsiteCollectionFactory;
use const _PHPStan_8f8c1af79\__;

class UserEditTabMain
{
    private $formFactory;
    private $registry;

    protected $websiteCollectionFactory;

    public function __construct(
        FormFactory $formFactory,
        Registry $registry,
        WebsiteCollectionFactory $websiteCollectionFactory
    ) {
        $this->formFactory = $formFactory;
        $this->registry = $registry;
        $this->websiteCollectionFactory = $websiteCollectionFactory;
    }

    public function aroundGetFormHtml(Main $subject, \Closure $proceed)
    {
        $websiteCollectionFactory = $this->websiteCollectionFactory->create();
        $form = $subject->getForm();
        if (is_object($form)) {
            $options = [];
            foreach ($websiteCollectionFactory as $key => $website) {
                $options[$key] = __($website->getName());
            }

            // Tạo hẳn section riêng mới
//            $baseFieldset = $form->addFieldset('admin_website_role',
//                ['legend' => __('Website Role')]);

            $baseFieldset = $form->getElement('base_fieldset');
            /** @var $model \Magento\User\Model\User */
            $model = $this->registry->registry('permissions_user');
            $data = $model->getData();
            $baseFieldset->addField(
                'website_role',
                'select',
                [
                    'name' => 'website_role',
                    'label' => __('Webstie Role'),
                    'title' => __('Webstie Role'),
                    'options' => $options, // it has array of all the admin users with role 'Manager'
                    'class' => 'select',
                    'value' => isset($data['website_role']) ? $data['website_role'] : 1
                ]
            );

            $subject->setForm($form);
        }

        return $proceed();
    }
}
