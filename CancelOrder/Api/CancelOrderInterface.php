<?php
namespace Magenest\CancelOrder\Api;

interface CancelOrderInterface
{
    /**
     * Hủy đơn hàng bởi orderId nếu đơn hàng đang ở trạng thái "pending".
     *
     * @param int $orderId Id của đơn hàng cần hủy.
     * @param int $customerId Id của khách hàng gửi yêu cầu hủy đơn hàng.
     * @return string Kết quả của việc hủy đơn hàng.
     */
    public function cancelOrder($orderId, $customerId);
}
