<?php

namespace MonitoringBundle\Check;

use Pimcore\Version;

class CoreCheck implements CheckInterface
{
    public function getCheckReportIdentifier(): string
    {
        return 'core';
    }

    public function getCheckReport(): array
    {
        return [
            'version'  => Version::getVersion(),
            'revision' => Version::getRevision()
        ];
    }
}
