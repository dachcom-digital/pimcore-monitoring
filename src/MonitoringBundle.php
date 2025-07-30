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

namespace MonitoringBundle;

use MonitoringBundle\DependencyInjection\CompilerPass\ModulesPass;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;
use Pimcore\Extension\Bundle\Traits\PackageVersionTrait;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MonitoringBundle extends AbstractPimcoreBundle
{
    use PackageVersionTrait;

    public const PACKAGE_NAME = 'dachcom-digital/monitoring';

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    protected function getComposerPackageName(): string
    {
        return self::PACKAGE_NAME;
    }
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ModulesPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 255);
    }
}
