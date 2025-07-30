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

class Check
{
    public function __construct(protected iterable $checks)
    {
    }

    public function dispatchCheck(array $filter = []): array
    {
        $checks = [];
        /** @var CheckInterface $check */
        foreach ($this->checks as $check) {

            if (count($filter) > 0 && !in_array($check->getCheckReportIdentifier(), $filter, true)) {
                continue;
            }

            $checks[$check->getCheckReportIdentifier()] = $check->getCheckReport();
        }

        return $checks;
    }
}
