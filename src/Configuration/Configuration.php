<?php

/*
 * This source file is available under two different licenses:
 *   - GNU General Public License version 3 (GPLv3)
 *   - DACHCOM Commercial License (DCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) DACHCOM.DIGITAL AG (https://www.dachcom-digital.com)
 * @license    GPLv3 and DCL
 */

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

    public function moduleIsEnabled(string $module): bool
    {
        return $this->config['modules'][$module] === true;
    }
}
