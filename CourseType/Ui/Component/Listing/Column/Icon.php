<?php

namespace Magenest\CourseType\Ui\Component\Listing\Column;

class Icon extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Prepare data source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getName();
        foreach ($dataSource['data']['items'] as & $item) {
            $item[$fieldName . '_src'] = $item[$fieldName];;
            $item[$fieldName . '_orig_src'] = $item[$fieldName];;
            $item[$fieldName . '_link'] = $item[$fieldName];;
        }
        return $dataSource;
    }
}
