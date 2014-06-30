<?php
/**
 * This file is part of the "LitGroupDnsBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\DnsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('lit_group_dns');

        $rootNode
            ->children()

                ->scalarNode('nameserver')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->example('8.8.8.8')
                ->end()

                ->booleanNode('cache')
                    ->defaultFalse()
                ->end()
            ->end();

        return $treeBuilder;
    }

} 