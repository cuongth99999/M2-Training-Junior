<?php
declare(strict_types=1);

namespace Magenest\CancelOrder\Controller\Order;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Magenest\CancelOrder\Model\CancelOrderFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class Index extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    protected $customerSession;
    protected $storeManager;
    protected $cancelOrderFactory;
    protected $orderRepository;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     */
    public function __construct
    (
        Context $context,
        PageFactory $resultPageFactory,
        CustomerSession $customerSession,
        StoreManagerInterface $storeManager,
        CancelOrderFactory $cancelOrderFactory,
        OrderRepositoryInterface $orderRepository
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        $this->storeManager = $storeManager;
        $this->cancelOrderFactory = $cancelOrderFactory;
        $this->orderRepository = $orderRepository;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try{
            $order = $this->orderRepository->get($this->getRequest()->getParam('order-id'));
            if($this->customerSession->getCustomer()->getEmail() === $order->getCustomerEmail() && $order->getStatus() != 'canceled')
            {
                $cancelOrderModel = $this->cancelOrderFactory->create();
                $order->canCancel();
                $order->setState(\Magento\Sales\Model\Order::STATE_CANCELED);
                $order->setStatus(\Magento\Sales\Model\Order::STATE_CANCELED);
                $order->save();
                $data = [];
                $data['increment_id'] = $order->getIncrementId();
                $data['store_id'] = $this->storeManager->getStore()->getId();
                $data['customer_email'] = $order->getCustomerEmail();
                $data['cancel_reason'] = $this->getRequest()->getParam('reason');
                $data['comment'] = $this->getRequest()->getParam('comment');
                $data['cancel_by'] = 'Customer';
                $cancelOrderModel->setData($data)->setId(null);
                $cancelOrderModel->save();
                $this->messageManager->addSuccessMessage(__('You canceled order.'));
            }
        }catch (\Exception $e){
            $this->messageManager->addErrorMessage(__('Something went wrong. Please try again later '));
        }
        return $resultRedirect->setPath('sales/order/history');
    }
}
