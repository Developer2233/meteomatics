<?php

namespace Meteomatics\Core\Cron;

use Magento\Framework\Exception\LocalizedException;
use Meteomatics\Core\Api\Data\WeatherInterface;
use Meteomatics\Core\Api\Data\WeatherInterfaceFactory;
use Meteomatics\Core\Api\WeatherRepositoryInterface;
use Meteomatics\Core\Model\ApiClient;
use Magento\Framework\App\Config\ScopeConfigInterface;

use Psr\Log\LoggerInterface;

class GetWeather
{
    public const IS_ENABLED = 'meteomatics/settings/enabled';

    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @var ApiClient
     */
    private ApiClient $apiClient;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var WeatherInterfaceFactory
     */
    private WeatherInterfaceFactory $weatherFactory;

    /**
     * @param WeatherRepositoryInterface $weatherRepository
     * @param WeatherInterfaceFactory $weatherFactory
     * @param ApiClient $apiClient
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        WeatherRepositoryInterface $weatherRepository,
        WeatherInterfaceFactory    $weatherFactory,
        ApiClient                  $apiClient,
        ScopeConfigInterface       $scopeConfig,
        LoggerInterface            $logger
    ) {
        $this->weatherRepository = $weatherRepository;
        $this->apiClient = $apiClient;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->weatherFactory = $weatherFactory;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        if ($this->scopeConfig->getValue(self::IS_ENABLED)) {
            try {
                $data = $this->apiClient->apiCall();

                $prepareData = [];
                foreach ($data['data'] as $parameter) {
                    $prepareData[$parameter['parameter']] = $parameter['coordinates'][0]['dates'][0]['value'];
                }

                /** @var WeatherInterface $weather */
                $weather = $this->weatherFactory->create();
                $weather->setTemp((string)$prepareData['t_2m:C']);
                $weather->setWindSpeed((string)$prepareData['wind_speed_10m:ms']);
                $weather->setWindDir((string)$prepareData['wind_dir_10m:d']);
                $weather->setPressure((string)$prepareData['msl_pressure:hPa']);
                $weather->setPrecipitation((string)$prepareData['precip_1h:mm']);
                $weather->setData('updated_at', time());

                $this->weatherRepository->save($weather);
            } catch (LocalizedException $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }
}
