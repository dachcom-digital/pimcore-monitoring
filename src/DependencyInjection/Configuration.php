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

namespace MonitoringBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('monitoring');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('api_code')->defaultNull()->end()
                ->arrayNode('modules')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('email_log')->defaultValue(false)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
