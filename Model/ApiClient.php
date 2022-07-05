<?php

namespace Meteomatics\Core\Model;

use DateTime;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\Client\Curl as CurlClient;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;

class ApiClient extends AbstractHelper
{
    public const USER = 'meteomatics/settings/user';
    public const PASSWORD = 'meteomatics/settings/password';
    public const LONG = 'meteomatics/settings/long';
    public const LAT = 'meteomatics/settings/lat';

    /**
     * @var CurlClient
     */
    private CurlClient $curl;

    /**
     * @var Json
     */
    private Json $serializer;

    /**
     * @param Context $context
     * @param CurlClient $curl
     * @param ScopeConfigInterface $scopeConfig
     * @param Json $serializer
     */
    public function __construct(
        Context              $context,
        CurlClient           $curl,
        ScopeConfigInterface $scopeConfig,
        Json                 $serializer
    ) {
        parent::__construct($context);
        $this->curl = $curl;
        $this->scopeConfig = $scopeConfig;
        $this->serializer = $serializer;
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function apiCall(): array
    {
        $today = new DateTime("now");
        $date = $today->format('Y-m-d\TH:i:s\Z');
        $lat = $this->scopeConfig->getValue(self::LAT);
        $long = $this->scopeConfig->getValue(self::LONG);

        $parameters[]= 't_2m:C';
        $parameters[]= 'wind_speed_10m:ms';
        $parameters[]= 'wind_dir_10m:d';
        $parameters[]= 'msl_pressure:hPa';
        $parameters[]= 'precip_1h:mm';

        $linkParts[] = 'https://api.meteomatics.com';
        $linkParts[] = $date;
        $linkParts[] = implode(",", $parameters);
        $linkParts[] = $lat . ',' . $long;
        $linkParts[] = 'json';

        $url = implode("/", $linkParts);

        $this->curl->setCredentials($this->scopeConfig->getValue(self::USER), $this->scopeConfig->getValue(self::PASSWORD));
        $this->curl->get($url);
        if ($this->curl->getStatus() != 200) {
            if ($this->curl->getStatus() == 401) {
                throw new LocalizedException(__('Bad Credentials'));
            } else {
                throw new LocalizedException(__('Bad Request'));
            }
        }
        $response = $this->curl->getBody();

        return $this->serializer->unserialize($response);
    }
}
