<?php

namespace Magenest\CourseType\Model\ResourceModel\Attachment\Grid;

use Magento\Eav\Model\ResourceModel\Entity\Attribute;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Sales\Model\Order\Item as ItemOrder;
use Magento\Sales\Model\ResourceModel\Order\Item;
use Psr\Log\LoggerInterface as Logger;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
    protected $itemOrder;

    /**
     * @var \Magento\Ui\DataProvider\AddFilterToCollectionInterface[]
     */
    protected $addFilterStrategies;

    public function __construct(
        Attribute $eavAttribute,
        ItemOrder $itemOrder,
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        array $addFilterStrategies = [],
        $mainTable = 'magenest_attachment',
        $resourceModel = Item::class,
        $identifierName = null,
        $connectionName = null
    )
    {
        $this->addFilterStrategies = $addFilterStrategies;
        $this->itemOrder = $itemOrder;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel, $identifierName, $connectionName);
    }

    protected function _initSelect()
    {
        parent::_initSelect();
        return $this->getSelect();
    }
}
