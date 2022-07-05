<?php

namespace Meteomatics\Core\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Meteomatics\Core\Api\Data\WeatherSearchResultInterface;
use Meteomatics\Core\Api\Data\WeatherInterface;

interface WeatherRepositoryInterface
{
    /**
     * @param WeatherInterface $weather
     * @return WeatherInterface
     */
    public function save(WeatherInterface $weather): WeatherInterface;

    /**
     * @param string $entityId
     * @return WeatherInterface
     */
    public function get(string $entityId): Data\WeatherInterface;

    /**
     * @param SearchCriteriaInterface $searchSearchCriteria
     * @return WeatherSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchSearchCriteria): WeatherSearchResultInterface;

    /**
     * @param WeatherInterface $weather
     */
    public function delete(WeatherInterface $weather): void;

    /**
     * @param string $entityId
     */
    public function deleteById(string $entityId): void;

}
