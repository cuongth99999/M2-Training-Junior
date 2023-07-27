<?php

namespace Magenest\CourseType\Observer;

use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfter implements ObserverInterface
{

    protected $jsonSerializer;

    public function __construct
    (
        \Magento\Framework\Serialize\SerializerInterface $jsonSerializer
    )
    {
        $this->jsonSerializer = $jsonSerializer;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $_product = $observer->getProduct();
        $courseTimeline = $_product->setCourseTimeline($this->jsonSerializer->serialize($_product->getCourseTimeline()));
        // you will get product object
    }
}
