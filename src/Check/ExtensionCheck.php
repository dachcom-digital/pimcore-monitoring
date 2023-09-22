<?php

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
