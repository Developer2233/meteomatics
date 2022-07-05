<?php

namespace Meteomatics\Core\Model\Api;

use Meteomatics\Core\Api\Data\WeatherInterface;
use Meteomatics\Core\Model\ResourceModel\Weather\CollectionFactory;

class FetchWeatherInfo implements \Meteomatics\Core\Api\FetchWeatherInfoInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return  WeatherInterface
     */
    public function fetchWeather(): WeatherInterface
    {
        $collection = $this->collectionFactory->create();
        return $collection->getLastItem();
    }
}
