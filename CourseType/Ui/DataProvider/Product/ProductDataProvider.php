<?php
namespace Magenest\CourseType\Ui\DataProvider\Product;

use Magento\Framework\Api\Filter;

class ProductDataProvider extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{
    public function addFilter(Filter $filter)
    {
        if ($filter->getField() == 'category_id') {
            $this->getCollection()->addCategoriesFilter(['eq' => $filter->getValue()]);
        } else if (isset($this->addFilterStrategies[$filter->getField()])) {
            $this->addFilterStrategies[$filter->getField()]
                ->addFilter(
                    $this->getCollection(),
                    $filter->getField(),
                    [$filter->getConditionType() => $filter->getValue()]
                );
        } else {
            parent::addFilter($filter);
        }
    }
}


