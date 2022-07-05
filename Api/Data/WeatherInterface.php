<?php

namespace Meteomatics\Core\Api\Data;

interface WeatherInterface
{
    public const ENTITY_ID = 'entity_id';
    public const TEMP = 'temp_c';
    public const WIND_SPEED = 'wind_speed';
    public const WIND_DIRECTION = 'wind_dir';
    public const PRESSURE = 'pressure_msl';
    public const PRECIPITATION = 'precipitation';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return string|null
     */
    public function getEntityId(): ?string;

    /**
     * @param string|null $entityId
     * @return $this
     */
    public function setEntityId(?string $entityId): self;

    /**
     * @return string|null
     */
    public function getTemp(): ?string;

    /**
     * @param string $temp
     * @return $this
     */
    public function setTemp(string $temp): self;

    /**
     * @return string|null
     */
    public function getWindSpeed(): ?string;

    /**
     * @param string $windSpeed
     * @return $this
     */
    public function setWindSpeed(string $windSpeed): self;

    /**
     * @return string|null
     */
    public function getWindDir(): ?string;

    /**
     * @param string $windDir
     * @return $this
     */
    public function setWindDir(string $windDir): self;

    /**
     * @return string|null
     */
    public function getPressure(): ?string;

    /**
     * @param string $pressure
     * @return $this
     */
    public function setPressure(string $pressure): self;

    /**
     * @return string|null
     */
    public function getPrecipitation(): ?string;

    /**
     * @param string $precipitation
     * @return $this
     */
    public function setPrecipitation(string $precipitation): self;

    /**
     * @return string|null
     */
    public function getUpdatedAt(): ?string;

    /**
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string $updatedAt): self;

}
