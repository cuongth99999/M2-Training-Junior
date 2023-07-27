<?php

namespace Magenest\MassExport\Controller\Adminhtml\Export;

use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\File\Csv as CsvProc;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Sales\Model\ResourceModel\Order\Item\CollectionFactory as OrderItemCollectionFactory;

class Csv extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{
    protected $fileFactory;
    protected $collectionFactory;
    protected $csvProc;
    protected $directoryList;
    protected $orderItemCollectionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        FileFactory $fileFactory,
        DirectoryList $directoryList,
        CsvProc $csvProc,
        OrderItemCollectionFactory $orderItemCollectionFactory
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->fileFactory = $fileFactory;
        $this->directoryList = $directoryList;
        $this->csvProc = $csvProc;
        $this->orderItemCollectionFactory = $orderItemCollectionFactory;
    }

    protected function massAction(AbstractCollection $collection)
    {
        $orderIds = $collection->getAllIds(); // Get the selected orders
        $orders = $this->collectionFactory->create()->addFieldToFilter('entity_id', ['in' => $orderIds]);

        $data = $this->getExportData($orders);

        if (!empty($data)) {
            $csvFileName = 'export.csv';
            $this->exportCsv($csvFileName, $data);
        }
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magenest_MassExport::exportcsv');
    }

    private function exportCsv($fileName, $data)
    {
        $filePatch = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
            . "/" . $fileName;
        $this->csvProc->setDelimiter(';')->setEnclosure('"')
            ->saveData($filePatch,$data);

        $file = $this->fileFactory->create($fileName,
            [
            'type' => "filename",
            'value' => $fileName,
            'rm' => true,
            ], \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
            'application/octet-stream', null);
        return $file;
    }

    private function getExportData($orders)
    {
        $exportData = [];

        // Header row
        $exportData[] = [
            'Order Increment Id',
            'Order Status',
            'SKU',
            'Product Name',
            'Qty (Ordered qty)',
            'Item Status (of order item)',
            'Tax Amount (of order item)',
            'Discount Amount (of order item)',
            'Customer email',
            'Number of times customer has purchased the product (based on SKU)',
            'Store name',
            'Purchase Date',
            'Bill-to Name',
            'Ship-to Name',
            'Payment method',
            'Line total',
            'Coupon code',
            'Promotion Name (Rule name)',
            'Order comment'
        ];

        foreach ($orders as $order) {
            $items = $order->getAllVisibleItems();
            foreach ($items as $item) {
                $exportData[] = [
                    $order->getIncrementId(),
                    $order->getStatus(),
                    $item->getSku(),
                    $item->getName(),
                    $item->getQtyOrdered(),
                    $item->getStatus(),
                    $item->getTaxAmount(),
                    $item->getDiscountAmount(),
                    $order->getCustomerEmail(),
                    $this->getNumberOfPurchases($item->getSku(), $order->getCustomerId()),
                    $order->getStore()->getName(),
                    $order->getCreatedAt(),
                    $order->getBillingAddress()->getName(),
                    $order->getShippingAddress()->getName(),
                    $order->getPayment()->getMethod(),
                    $item->getRowTotal(),
                    $order->getCouponCode(),
                    $order->getAppliedRuleNames(),
                    $order->getCustomerNote()
                ];
            }
        }

        return $exportData;
    }

    private function getNumberOfPurchases($sku, $customerId)
    {
        $orderCollection = $this->collectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId);

        $purchasesCount = 0;

        foreach ($orderCollection as $order) {
            $items = $order->getAllVisibleItems();
            foreach ($items as $item) {
                if ($item->getSku() === $sku) {
                    $purchasesCount++;
                }
            }
        }

        return $purchasesCount;
    }

}
