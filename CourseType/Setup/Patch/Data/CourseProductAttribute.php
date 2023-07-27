<?php

namespace Magenest\CourseType\Setup\Patch\Data;

use Magenest\CourseType\Model\Product\Type\CourseType;
use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CourseProductAttribute implements DataPatchInterface
{
    private $_moduleDataSetup;

    private $_eavSetupFactory;

    private $file;

    private $dir;

    public function __construct(
        \Magento\Framework\Filesystem\Io\File $file,
        \Magento\Framework\Filesystem\DirectoryList $dir,
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->file = $file;
        $this->dir = $dir;
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    public function apply()
    {
        $attachment = $this->dir->getPath('media').'/attachment';
        $tmp = $attachment.'/tmp';
        $tmpfile = $tmp.'/file';
        $filefath = $attachment.'/file';
        if ( ! file_exists($attachment)) {
            $this->file->mkdir($attachment);
        }
        if ( ! file_exists($tmp)) {
            $this->file->mkdir($tmp);
        }
        if ( ! file_exists($tmpfile)) {
            $this->file->mkdir($tmpfile);
        }
        if ( ! file_exists($filefath)) {
            $this->file->mkdir($filefath);
        }

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $this->_moduleDataSetup]);
        $fieldList = [
            'price',
            'special_price',
            'special_from_date',
            'special_to_date',
            'minimal_price',
            'cost',
            'tier_price',
        ];

        foreach ($fieldList as $field) {
            $applyTo = explode(
                ',',
                $eavSetup->getAttribute(Product::ENTITY, $field, 'apply_to')
            );
            if (!in_array(CourseType::TYPE_CODE, $applyTo)) {
                $applyTo[] = CourseType::TYPE_CODE;
                $eavSetup->updateAttribute(
                    Product::ENTITY,
                    $field,
                    'apply_to',
                    implode(',', $applyTo)
                );
            }
        }

        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'course_timeline', [
            'type' => 'varchar',
            'label' => 'Course Timeline',
            'group' => 'Course Information',
            'input' => 'text',
            'class' => 'course_timeline',
            'source' => \Magento\Catalog\Model\Product\Attribute\Source\Dynamicrows::class,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => true,
            'searchable' => false,
            'filterable' => false,
            'comparable' => false,
            'visible_on_front' => true,
            'unique' => false,
            'apply_to' => 'course_type'
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Product::ENTITY, 'document', [
            'type' => 'varchar',
            'label' => 'Document',
            'group' => 'Course Information',
            'input' => 'text',
            'class' => 'document',
            'source' => \Magento\Catalog\Model\Product\Attribute\Source\Boolean::class,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
            'visible' => true,
            'required' => true,
            'searchable' => true,
            'filterable' => true,
            'comparable' => false,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'used_for_sort_by' => true,
            'unique' => false,
            'apply_to' => 'course_type'
        ]);
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public static function getVersion()
    {
        return '1.0.0';
    }
}
