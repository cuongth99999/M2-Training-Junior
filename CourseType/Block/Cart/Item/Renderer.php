<?php

namespace Magenest\CourseType\Block\Cart\Item;

use Magento\Catalog\Model\Product\Configuration\Item\ItemResolverInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\View\Element\Message\InterpretationStrategyInterface;
use Magenest\CourseType\Helper\Data as CourseTypeHelperData;

class Renderer extends \Magento\Checkout\Block\Cart\Item\Renderer
{
    public function __construct
    (
        CourseTypeHelperData $courseTypeHelper,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Helper\Product\Configuration $productConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Catalog\Block\Product\ImageBuilder $imageBuilder,
        \Magento\Framework\Url\Helper\Data $urlHelper,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Framework\Module\Manager $moduleManager,
        InterpretationStrategyInterface $messageInterpretationStrategy,
        array $data = [],
        ItemResolverInterface $itemResolver = null
    )
    {
        $this->courseTypeHelper = $courseTypeHelper;
        parent::__construct($context, $productConfig, $checkoutSession, $imageBuilder, $urlHelper, $messageManager, $priceCurrency, $moduleManager, $messageInterpretationStrategy, $data, $itemResolver);
    }

    public function getCourseDocument($name)
    {
        return $this->courseTypeHelper->getCourseDocument($name);
    }
}
