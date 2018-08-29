<?php

namespace MonitoringBundle;

use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MonitoringBundle
 *
 * @package MonitoringBundle
 */
class MonitoringBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    /**
     * @inheritDoc
     */
    protected function getComposerPackageName(): string
    {
        return 'dachcom-digital/monitoring';
    }

}