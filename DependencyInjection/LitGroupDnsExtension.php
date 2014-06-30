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


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

/**
 * LitGroupDnsExtension
 *
 * @author Roman Shamritskiy <roman@litgroup.ru>
 */
class LitGroupDnsExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->loadResolverFactory($loader);
        $this->loadResolver($config, $container, $loader);
    }

    private function loadResolverFactory(Loader\XmlFileLoader $loader)
    {
        $loader->load('resolver_factory.xml');
    }

    private function loadResolver(array $config, ContainerBuilder $container, Loader\XmlFileLoader $loader)
    {
        $loader->load('resolver.xml');
        $definition = $container->getDefinition('litgroup_dns.resolver');
        $definition->replaceArgument(0, $config['nameserver']);
        $definition->setFactoryMethod($config['cache'] ? 'createCached' : 'create');
    }

}