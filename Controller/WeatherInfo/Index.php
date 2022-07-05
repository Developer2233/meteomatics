<?php

namespace Meteomatics\Core\Controller\WeatherInfo;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Meteomatics\Core\Model\WeatherRepository;

class Index extends \Magento\Framework\App\Action\Action implements HttpGetActionInterface
{
    public const IS_ENABLED = 'meteomatics/settings/enabled';

    /**
     * @var JsonFactory
     */
    private $resultJsonFactory;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var WeatherRepository
     */
    private WeatherRepository $weatherRepository;

    /**
     * @param JsonFactory $resultJsonFactory
     * @param Context $context
     * @param WeatherRepository $weatherRepository
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        JsonFactory          $resultJsonFactory,
        Context              $context,
        WeatherRepository    $weatherRepository,
        ScopeConfigInterface $scopeConfig
    )
    {
        parent::__construct($context);
        $this->resultJsonFactory = $resultJsonFactory;
        $this->scopeConfig = $scopeConfig;
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @inerhitDoc
     */
    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        if ($this->scopeConfig->getValue(self::IS_ENABLED)) {
            $resultJson->setData($this->weatherRepository->getLastItem());
        }
        return $resultJson;
    }
}
