<?php

namespace Meteomatics\Core\Api;

use Meteomatics\Core\Api\Data\WeatherInterface;

interface FetchWeatherInfoInterface
{
    /**
     * @return WeatherInterface
     */
    public function fetchWeather(): WeatherInterface;
}
