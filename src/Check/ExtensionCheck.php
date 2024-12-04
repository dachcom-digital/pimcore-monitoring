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

use Pimcore\Extension\Bundle\PimcoreBundleManager;

class ExtensionCheck implements CheckInterface
{
    public function __construct(protected PimcoreBundleManager $pimcoreBundleManager)
    {
    }

    public function getCheckReportIdentifier(): string
    {
        return 'extensions';
    }

    public function getCheckReport(): array
    {
        $extensions = [];

        foreach ($this->pimcoreBundleManager->getActiveBundles() as $bundle) {
            $extensions[] = [
                'title'       => $bundle->getNiceName(),
                'version'     => $bundle->getVersion(),
                'identifier'  => $this->pimcoreBundleManager->getBundleIdentifier($bundle),
                'isInstalled' => $this->pimcoreBundleManager->isInstalled($bundle),
            ];
        }

        return $extensions;
    }
}
