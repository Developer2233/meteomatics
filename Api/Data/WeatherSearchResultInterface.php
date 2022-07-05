<?php

namespace Meteomatics\Core\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface WeatherSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return array
     */
    public function getItems(): array;

    /**
     * @param array $items
     * @return WeatherSearchResultInterface
     */
    public function setItems(array $items): WeatherSearchResultInterface;
}
