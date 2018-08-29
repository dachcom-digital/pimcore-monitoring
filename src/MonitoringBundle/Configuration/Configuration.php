<?php

namespace MonitoringBundle\Configuration;

/**
 * Class Configuration
 *
 * @package MonitoringBundle\Configuration
 */
class Configuration
{
    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function setConfig($config = [])
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->config['api_key'];
    }
}