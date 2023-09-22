<?php

namespace MonitoringBundle\Check;

interface CheckInterface
{
    public function getCheckReportIdentifier(): string;

    public function getCheckReport(): array;
}
