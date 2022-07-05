<?php

namespace Meteomatics\Core\Model;

use Magento\Framework\Model\AbstractModel;
use Meteomatics\Core\Api\Data\WeatherInterface;
use Meteomatics\Core\Model\ResourceModel\WeatherResource as Resource;

class WeatherModel extends AbstractModel implements WeatherInterface
{
    /**
     * @inerhitDoc
     */
    public function _construct()
    {
        $this->_init(Resource::class);
    }

    /**
     * @return string|null
     */
    public function getEntityId(): ?string
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @param int|string|null $entityId
     * @return WeatherInterface
     */
    public function setEntityId($entityId): WeatherInterface
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @return string|null
     */
    public function getTemp(): ?string
    {
        return $this->getData(self::TEMP);
    }

    /**
     * @param string $temp
     * @return WeatherInterface
     */
    public function setTemp(string $temp): WeatherInterface
    {
        return $this->setData(self::TEMP, $temp);
    }

    /**
     * @return string|null
     */
    public function getWindSpeed(): ?string
    {
        return $this->getData(self::WIND_SPEED);
    }

    /**
     * @param string $windSpeed
     * @return WeatherInterface
     */
    public function setWindSpeed(string $windSpeed): WeatherInterface
    {
        return $this->setData(self::WIND_SPEED, $windSpeed);
    }

    /**
     * @return string|null
     */
    public function getWindDir(): ?string
    {
        return $this->getData(self::WIND_DIRECTION);
    }

    /**
     * @param string $windDir
     * @return WeatherInterface
     */
    public function setWindDir(string $windDir): WeatherInterface
    {
        return $this->setData(self::WIND_DIRECTION, $windDir);
    }

    /**
     * @return string|null
     */
    public function getPressure(): ?string
    {
        return $this->getData(self::PRESSURE);
    }

    /**
     * @param string $pressure
     * @return WeatherInterface
     */
    public function setPressure(string $pressure): WeatherInterface
    {
        return $this->setData(self::PRESSURE, $pressure);
    }

    /**
     * @return string|null
     */
    public function getPrecipitation(): ?string
    {
        return $this->getData(self::PRECIPITATION);
    }

    /**
     * @param string $precipitation
     * @return WeatherInterface
     */
    public function setPrecipitation(string $precipitation): WeatherInterface
    {
        return $this->setData(self::PRECIPITATION, $precipitation);
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * @param string $updatedAt
     * @return WeatherInterface
     */
    public function setUpdatedAt(string $updatedAt): WeatherInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
