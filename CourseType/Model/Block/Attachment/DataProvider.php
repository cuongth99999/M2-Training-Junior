<?php

namespace Magenest\CourseType\Model\Block\Attachment;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magenest\CourseType\Model\ResourceModel\Attachment\CollectionFactory as AttachmentCollectionFactory;

class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var AttachmentCollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * DataProvider constructor.
     * @param AttachmentCollectionFactory $googleFeedCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        AttachmentCollectionFactory $googleFeedCollectionFactory,
        DataPersistorInterface      $dataPersistor,
                                    $name,
                                    $primaryFieldName,
                                    $requestFieldName,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $googleFeedCollectionFactory->create();
        $this->collectionFactory = $googleFeedCollectionFactory;
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
            $this->loadedData[$item->getEntityId()] = $item->getData();
            $this->loadedData[$item->getEntityId()]['file_path'] = json_decode($item->getFilePath());
            $this->loadedData[$item->getEntityId()]['customer_group'] = implode(',',json_decode($item->getCustomerGroup()));
        }
        return $this->loadedData;
    }
}
