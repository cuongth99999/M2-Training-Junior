<?php

namespace Magenest\DeliveryTime\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;

class Index extends \Magento\Backend\App\Action
{
    private $resultPageFactory;

    public function __construct
    (
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPage
    )
    {
        $this->resultPageFactory = $resultPage;
        parent::__construct($context);
    }

    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        return $resultPage;
    }
}
