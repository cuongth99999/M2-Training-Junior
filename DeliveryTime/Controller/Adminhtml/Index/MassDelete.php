<?php

namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magenest\DeliveryTime\Model\DeliveryTimeFactory;
use Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime\CollectionFactory;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $deliveryTimeFactory;
    protected $deliveryTimeCollectionFactory;
    protected $filter;

    public function __construct
    (
        DeliveryTimeFactory $deliveryTimeFactory,
        CollectionFactory $deliveryTimeCollectionFactory,
        Filter $filter,
        Context $context
    )
    {
        $this->deliveryTimeFactory = $deliveryTimeFactory;
        $this->deliveryTimeCollectionFactory = $deliveryTimeCollectionFactory;
        $this->_filer = $filter;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->_filer->getCollection($this->deliveryTimeCollectionFactory->create());
        $ids = $collection->getAllIds();
        $model = $this->deliveryTimeFactory->create();
        $model->deleteMultiple($ids);
        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', count($ids))
        );
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT)->setPath('deliverytime/index/index');
    }
}
