<?php

namespace Meteomatics\Core\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Meteomatics\Core\Api\Data\WeatherInterface;
use Meteomatics\Core\Api\Data\WeatherInterfaceFactory;
use Meteomatics\Core\Model\ResourceModel\WeatherResource as ResourceWeather;
use Meteomatics\Core\Api\Data\WeatherSearchResultInterface;
use Meteomatics\Core\Api\WeatherRepositoryInterface;
use Meteomatics\Core\Model\ResourceModel\Weather\CollectionFactory;

class WeatherRepository implements WeatherRepositoryInterface
{
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var ResourceWeather
     */
    private ResourceWeather $resource;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var WeatherInterfaceFactory
     */
    private WeatherInterfaceFactory $weatherInterfaceFactory;

    /**
     * @var SearchResultsInterface
     */
    private SearchResultsInterface $searchResultsFactory;

    /**
     * @param ResourceWeather $resource
     * @param WeatherInterfaceFactory $weatherInterfaceFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsInterface $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceWeather              $resource,
        WeatherInterfaceFactory  $weatherInterfaceFactory,
        CollectionFactory            $collectionFactory,
        SearchResultsInterface       $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    )
    {
        $this->resource = $resource;
        $this->weatherInterfaceFactory = $weatherInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param WeatherInterface $weather
     * @return WeatherInterface
     * @throws CouldNotSaveException
     */
    public function save(WeatherInterface $weather): WeatherInterface
    {
        try {
            $this->resource->save($weather);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the entity: %1',
                $exception->getMessage()
            ));
        }
        return $weather;
    }

    /**
     * @param string $entityId
     * @return WeatherInterface
     * @throws NoSuchEntityException
     */
    public function get(string $entityId): WeatherInterface
    {
        $weatherModel = $this->weatherInterfaceFactory->create();
        $this->resource->load($weatherModel, $entityId);
        if (!$weatherModel->getEntityId()) {
            throw new NoSuchEntityException(__('entity with id "%1" does not exist.', $entityId));
        }
        return $weatherModel;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return WeatherSearchResultInterface
     * @throws NoSuchEntityException
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): WeatherSearchResultInterface
    {
        try {
            $collection = $this->collectionFactory->create();
            $this->collectionProcessor->process($searchCriteria, $collection);
            $searchResults = $this->searchResultsFactory->create();
            $searchResults->setSearchCriteria($searchCriteria);

            $items = [];
            foreach ($collection as $model) {
                $items[] = $model;
            }

            $searchResults->setItems($items);
            $searchResults->setTotalCount($collection->getSize());
        } catch (\Exception $exception) {
            throw new NoSuchEntityException(__('Could Not load factory'));
        }

        return $searchResults;
    }

    /**
     * @param WeatherInterface $weather
     * @throws CouldNotDeleteException
     */
    public function delete(WeatherInterface $weather): void
    {
        try {
            $weatherModel = $this->weatherInterfaceFactory->create();
            $this->resource->load($weatherModel, $weather->getEntityId());
            $this->resource->delete($weatherModel);
        } catch (Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the entity: %1',
                $exception->getMessage()
            ));
        }
    }

    /**
     * @param string $entityId
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById(string $entityId): void
    {
        $this->delete($this->get($entityId));
    }

    /**
     * @return DataObject
     */
    public function getLastItem(): DataObject
    {
        $collection = $this->collectionFactory->create();
        return $collection->getLastItem();
    }

}
