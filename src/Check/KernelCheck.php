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

namespace MonitoringBundle\Check;

use Symfony\Component\HttpKernel\KernelInterface;

class KernelCheck implements CheckInterface
{
    public function __construct(protected KernelInterface $kernel)
    {
    }

    public function getCheckReportIdentifier(): string
    {
        return 'kernel';
    }

    public function getCheckReport(): array
    {
        return [
            'environment' => $this->kernel->getEnvironment(),
            'debug'       => $this->kernel->isDebug(),
        ];
    }
}
