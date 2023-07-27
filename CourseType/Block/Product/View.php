<?php

namespace Magenest\CourseType\Block\Product;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magenest\CourseType\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollection;

class View extends \Magento\Catalog\Block\Product\View
{
    public function __construct
    (
        \Magenest\CourseType\Helper\Data $dataHelper,
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        array $data = []
    )
    {
        $this->dataHelper = $dataHelper;
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
    }

    /**
     * Get sorted child block names.
     *
     * @param string $groupName
     * @param string $callback
     * @throws \Magento\Framework\Exception\LocalizedException
     *
     * @return array
     * @since 103.0.1
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getGroupSortedChildNames(string $groupName, string $callback): array
    {
        $groupChildNames = $this->getGroupChildNames($groupName);
        $layout = $this->getLayout();

        $childNamesSortOrder = [];

        foreach ($groupChildNames as $childName) {
            $alias = $layout->getElementAlias($childName);
            $sortOrder = (int)$this->getChildData($alias, 'sort_order') ?? 0;

            $childNamesSortOrder[$childName] = $sortOrder;
        }

        asort($childNamesSortOrder, SORT_NUMERIC);

        return array_keys($childNamesSortOrder);
    }

    public function getCourseDocument($name)
    {
        return $this->dataHelper->getCourseDocument($name);
    }
}
