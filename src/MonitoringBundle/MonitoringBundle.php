<?php

namespace MonitoringBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MonitoringBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public const PACKAGE_NAME = 'dachcom-digital/monitoring';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }

    protected function getComposerPackageName(): string
    {
        return self::PACKAGE_NAME;
    }
}