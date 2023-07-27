<?php

namespace Magenest\DeliveryTime\Block\Adminhtml\DeliveryTime\Edit\Button;

use Magenest\DeliveryTime\Block\Adminhtml\DeliveryTime\Edit\Button\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    public function getButtonData()
    {
        $data = [];
        if ($this->getDeleveryTimeId()) {
            $data = [
                'label' => __('Delete Feed'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' . __(
                        'Are you sure you want to do this?'
                    ) . '\', \'' . $this->getDeleteUrl() . '\', {"data": {}})',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * URL to send delete requests to.
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('deliverytime/index/delete', ['delivery_time_id' => $this->getDeleveryTimeId()]);
    }
}
