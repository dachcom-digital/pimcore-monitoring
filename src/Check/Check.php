<?php

namespace MonitoringBundle\Check;

class Check
{
    public function __construct(protected iterable $checks)
    {
    }

    public function dispatchCheck(): array
    {
        $checks = [];
        /** @var CheckInterface $check */
        foreach ($this->checks as $check) {
            $checks[$check->getCheckReportIdentifier()] = $check->getCheckReport();
        }

        return $checks;
    }
}
