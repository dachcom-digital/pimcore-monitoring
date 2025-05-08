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

namespace MonitoringBundle\Module;

use Carbon\Carbon;
use Pimcore\Model\Tool\Email\Log;

class MailLogModule
{
    public function dispatch(array $parameters): array
    {
        $logListing = new Log\Listing();
        $logListing->setOrderKey('id');
        $logListing->setOrder('DESC');
        $logListing->setLimit($parameters['limit'] ?? 100);

        if ($parameters['onlyErrors'] === true) {
            $logListing->addConditionParam('error <> ""');
        }

        if ($parameters['startingFrom']) {
            $timeStamp = Carbon::parse($parameters['startingFrom'])->getTimestamp();
            $logListing->addConditionParam('sentDate >= ?', $timeStamp);
        }

        return array_map(static function (Log $log) {
            return [
                'id'         => $log->getId(),
                'documentId' => $log->getDocumentId(),
                'subject'    => $log->getSubject(),
                'error'      => $log->getError(),
                'sentDate'   => Carbon::createFromTimestamp($log->getSentDate())->toIso8601String(),
            ];
        }, $logListing->getEmailLogs());
    }
}
