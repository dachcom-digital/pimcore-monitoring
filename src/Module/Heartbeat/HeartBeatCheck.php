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

namespace MonitoringBundle\Module\Heartbeat;

use Carbon\Carbon;
use MonitoringBundle\Check\CheckInterface;
use Pimcore\Model\Tool\SettingsStore;

final class HeartBeatCheck implements CheckInterface
{
    public function getCheckReportIdentifier(): string
    {
        return 'heartbeat';
    }

    public function getCheckReport(): array
    {
        $lastCheck = null;
        $minutesSinceLast = null;

        $hearBeat = SettingsStore::get(HeartBeatTask::SETTING_ID, 'monitoring');

        if ($hearBeat instanceof SettingsStore) {
            $data = json_decode($hearBeat->getData(), true, 512, JSON_THROW_ON_ERROR);

            $lastCheckData = $data['heartbeatTime'] ? Carbon::fromSerialized($data['heartbeatTime']) : null;
            $lastCheck = $lastCheckData?->toIso8601String();

            $minutesSinceLast = $data['minutesSinceLast'] ?? null;
        }

        return [
            'last_check'         => $lastCheck,
            'minutes_since_last' => $minutesSinceLast
        ];
    }
}
