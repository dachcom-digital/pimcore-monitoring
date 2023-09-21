<?php

namespace MonitoringBundle\Configuration;

class Configuration
{
    private array $config;

    public function setConfig(array $config = []): void
    {
        $this->config = $config;
    }

    public function getApiCode(): mixed
    {
        return $this->config['api_code'];
    }
}