<?php
namespace Magenest\CancelOrder\Model\Api;

use Magento\Framework\App\RequestInterface;

class CancelOrder implements \Magenest\CancelOrder\Api\CancelOrderInterface
{
    protected $orderRepository;
    protected $logger;

    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function cancelOrder($orderId, $customerId)
    {
        // Lấy đối tượng đơn hàng dựa vào orderId
        $order = $this->orderRepository->get($orderId);

        // Kiểm tra nếu đơn hàng có trạng thái "pending" thì mới cho phép hủy
        if ($order->getStatus() != 'canceled') {
            // Kiểm tra xem customer_id của yêu cầu hủy có khớp với customer_id trong order không?
            if ($customerId == $order->getCustomerId()) {
                try {
                    // Tiến hành hủy đơn hàng
                    $order->cancel();
                    $order->setState(\Magento\Sales\Model\Order::STATE_CANCELED);
                    $order->setStatus(\Magento\Sales\Model\Order::STATE_CANCELED);
                    $this->orderRepository->save($order);
                    return "Đơn hàng đã được hủy thành công.";
                } catch (\Exception $e) {
                    $this->logger->error($e->getMessage());
                    return "Đã xảy ra lỗi trong quá trình hủy đơn hàng.";
                }
            } else {
                return "Bạn không được phép hủy đơn hàng của người khác hoặc thông tin khách hàng không hợp lệ.";
            }
        } else {
            return "Đơn hàng không thể hủy do không ở trạng thái 'pending'.";
        }
    }
}
