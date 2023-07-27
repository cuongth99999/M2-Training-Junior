<?php

namespace Magenest\CancelOrder\Controller\Adminhtml\Order;

use Magento\Backend\App\Action\Context;

class Index extends \Magento\Backend\App\Action
{
    protected $_resultPageFactory;

    public function __construct
    (
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        Context $context
    )
    {
        $this->_resultPageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Cancel Orders Grid'));
        return $resultPage;
    }
}
