<?php

namespace Magenest\DeliveryTime\Cron;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\Mail\Template\TransportBuilder;
use Psr\Log\LoggerInterface;

class SendDeliveryEmail
{
    /**
     * @var CollectionFactory
     */
    private $orderCollectionFactory;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    private $_logger;

    public function __construct
    (
        CollectionFactory $orderCollectionFactory,
        TransportBuilder $transportBuilder,
        LoggerInterface $logger
    )
    {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->transportBuilder = $transportBuilder;
        $this->_logger = $logger;
    }

    public function execute()
    {
        try{
            $current_time = new \DateTime();
            $currentTimeDate  = $current_time->format('d');
            $currentTimeMonth  = $current_time->format('m');
            $currentTimeYear  = $current_time->format('Y');
            $searchTime = $currentTimeMonth.'/'.($currentTimeDate + '1').'/'.$currentTimeYear;
            $select = $this->orderCollectionFactory->create()
                ->getSelect()
                ->join('sales_order_address', 'main_table.entity_id = sales_order_address.parent_id')
                ->where('(sales_order_address.delivery_date = "'.$searchTime.'" OR sales_order_address.delivery_date = "'.$current_time->format('m/d/Y').'") AND sales_order_address.need_send_delivery_email = 0');
            $orderNeedSendMails = $this->orderCollectionFactory->create()->getConnection()->fetchAll($select);

            foreach($orderNeedSendMails as $orderNeedSendMail)
            {
                $deliveryTimeInterval = explode('-',$orderNeedSendMail['delivery_time_interval']);
                $firstHour = ((int)$deliveryTimeInterval[0]);
                $timeSend = ($firstHour === 0)?23:($firstHour - 1);
                if((int)$current_time->format('h') === $timeSend){
                    $fullname = $orderNeedSendMail['customer_firstname'].' '.$orderNeedSendMail['customer_lastname'];
                    $templateVars = [
                        'name' => $fullname,
                        'message' => 'Order #'.$orderNeedSendMail['increment_id'].' shipping to '.$orderNeedSendMail['street'].'/'.$orderNeedSendMail['region'].'/'.$orderNeedSendMail['city'].' by '.$orderNeedSendMail['shipping_description'],
                    ];
                    $transport = $this->transportBuilder->setTemplateIdentifier('delivery_time_order_shipment')
                        ->setTemplateOptions( [ 'area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => 1 ] )
                        ->setTemplateVars( $templateVars )
                        ->setFrom( [ "name" => "Magento ABC CHECK PAYMENT", "email" => "paul@gmail.com" ] )
                        ->addTo($orderNeedSendMail['customer_email'], $fullname)
                        ->getTransport();
                    $transport->sendMessage();
                    $this->orderCollectionFactory->create()
                        ->addFieldToFilter('entity_id', $orderNeedSendMail['parent_id'])
                        ->getFirstItem()
                        ->getShippingAddress()
                        ->setNeedSendDeliveryEmail(true)
                        ->save();
                }
            }
        } catch (\Exception $exception) {
            $this->_logger->debug($exception->getMessage());
        }

        return $this;
    }
}
