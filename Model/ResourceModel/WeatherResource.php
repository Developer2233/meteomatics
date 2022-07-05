<?php

namespace Meteomatics\Core\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class WeatherResource extends AbstractDb
{
    public const TABLE = 'weather';

    /**
     * @inerhitDoc
     */
    protected function _construct()
    {
        $this->_init(self::TABLE, 'entity_id');
    }
}
