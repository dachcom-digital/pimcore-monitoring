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
use Pimcore\Maintenance\TaskInterface;
use Pimcore\Model\Tool\SettingsStore;

final class HeartBeatTask implements TaskInterface
{
    public const SETTING_ID = 'monitoring.module.heartbeat';

    public function execute(): void
    {
        $now = Carbon::now();
        $hearBeat = SettingsStore::get(self::SETTING_ID, 'monitoring');

        $lastCheckDelta = null;
        if ($hearBeat instanceof SettingsStore) {
            $lastCheckData = json_decode($hearBeat->getData(), true, 512, JSON_THROW_ON_ERROR);
            $lastCheck = Carbon::fromSerialized($lastCheckData['heartbeatTime']);
            $lastCheckDelta = $lastCheck->diffInMinutes($now);
        }

        $data = [
            'heartbeatTime'    => $now->serialize(),
            'minutesSinceLast' => $lastCheckDelta
        ];

        SettingsStore::set(
            self::SETTING_ID,
            json_encode($data, JSON_THROW_ON_ERROR), SettingsStore::TYPE_STRING,
            'monitoring'
        );
    }
}
