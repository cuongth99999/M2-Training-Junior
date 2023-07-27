<?php

namespace Magenest\CourseType\Block\Customer\Wishlist\Item\Column;

use Magento\Catalog\Model\Product\Image\UrlBuilder;
use Magento\Framework\View\ConfigInterface;
use Magenest\CourseType\Helper\Data as CourseTypeHelperData;

class CourseLabel extends \Magento\Wishlist\Block\Customer\Wishlist\Item\Column
{
    public function __construct
    (
        CourseTypeHelperData $courseTypeHelper,
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\App\Http\Context $httpContext,
        array $data = [],
        ConfigInterface $config = null,
        UrlBuilder $urlBuilder = null
    )
    {
        $this->courseTypeHelper = $courseTypeHelper;
        parent::__construct($context, $httpContext, $data, $config, $urlBuilder);
    }

    public function getCourseDocument($name)
    {
        return $this->courseTypeHelper->getCourseDocument($name);
    }
}
