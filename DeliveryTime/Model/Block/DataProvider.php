<?php

namespace Magenest\DeliveryTime\Model\Block;

use Magenest\DeliveryTime\Model\ResourceModel\DeliveryTime\CollectionFactory as DeliveryTimeCollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var DeliveryTimeCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array|null
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     * @param DeliveryTimeCollectionFactory $deliveryTimeCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        DeliveryTimeCollectionFactory $deliveryTimeCollectionFactory,
        DataPersistorInterface $dataPersistor,
                                      $name,
                                      $primaryFieldName,
                                      $requestFieldName,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $deliveryTimeCollectionFactory->create();
        $this->collectionFactory = $deliveryTimeCollectionFactory;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $itemData = $item->getData();

            $deliveryTimeId = $item->getDeliveryTimeId();

            $this->loadedData[$deliveryTimeId] = $itemData;
            $this->loadedData[$item->getDeliveryTimeId()]['store_view'] = json_decode($item->getData('store_id'));
            $this->loadedData[$item->getDeliveryTimeId()]['customer_group'] = json_decode($item->getData('group_id'));
            $this->loadedData[$item->getDeliveryTimeId()]['range_time'] = json_decode($item->getRangeTime());
        }

        return $this->loadedData;
    }
}
