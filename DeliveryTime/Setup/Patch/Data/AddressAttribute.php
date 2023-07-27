<?php

namespace Magenest\DeliveryTime\Setup\Patch\Data;

use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class AddressAttribute implements DataPatchInterface
{
    /**
     * @var Config
     */
    private $eavConfig;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * AddressAttribute constructor.
     *
     * @param Config              $eavConfig
     * @param EavSetupFactory     $eavSetupFactory
     */
    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->eavConfig = $eavConfig;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->addAttribute('customer_address', 'delivery_date', [
            'type'             => 'varchar',
            'input'            => 'text',
            'label'            => 'Delivery Date',
            'visible'          => true,
            'required'         => false,
            'user_defined'     => true,
            'system'           => false,
            'group'            => 'General',
            'global'           => true,
            'visible_on_front' => false,
        ])->addAttribute('customer_address', 'delivery_time_interval', [
            'type'             => 'varchar',
            'input'            => 'text',
            'label'            => 'Delivety Time Interval',
            'visible'          => true,
            'required'         => false,
            'user_defined'     => true,
            'system'           => false,
            'group'            => 'General',
            'global'           => true,
            'visible_on_front' => false,
        ])->addAttribute('customer_address', 'delivery_comment', [
            'type'             => 'varchar',
            'input'            => 'text',
            'label'            => 'Delivery Commet',
            'visible'          => true,
            'required'         => false,
            'user_defined'     => true,
            'system'           => false,
            'group'            => 'General',
            'global'           => true,
            'visible_on_front' => false,
        ]);

        $customAttribute = $this->eavConfig->getAttribute('customer_address', 'delivery_date');

        $customAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address']
        );
        $customAttribute->save();

        $customAttribute = $this->eavConfig->getAttribute('customer_address', 'delivery_time_interval');

        $customAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address']
        );
        $customAttribute->save();

        $customAttribute = $this->eavConfig->getAttribute('customer_address', 'delivery_comment');

        $customAttribute->setData(
            'used_in_forms',
            ['adminhtml_customer_address',
                'customer_address_edit',
                'customer_register_address']
        );
        $customAttribute->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases(): array
    {
        return [];
    }
}

