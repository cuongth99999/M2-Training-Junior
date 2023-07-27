<?php

namespace Magenest\CourseType\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Output as OutputHelper;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data;
use Magenest\CourseType\Helper\Data as CourseTypeHelperData;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    public function __construct
    (
        CourseTypeHelperData $courseTypeHelper,
        Context $context,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        CategoryRepositoryInterface $categoryRepository,
        Data $urlHelper,
        array $data = [],
        ?OutputHelper $outputHelper = null
    )
    {
        $this->courseTypeHelper = $courseTypeHelper;
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data, $outputHelper);
    }

    public function getCourseDocument($name)
    {
        return $this->courseTypeHelper->getCourseDocument($name);
    }
}
