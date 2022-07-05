<?php

namespace Meteomatics\Core\Model\ResourceModel\Weather;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @inerhitDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Meteomatics\Core\Model\WeatherModel::class,
            \Meteomatics\Core\Model\ResourceModel\WeatherResource::class
        );
    }
}
