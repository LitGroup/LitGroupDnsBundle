<?php
/**
 * This file is part of the "LitGroupDnsBundle" package.
 *
 * (c) Roman Shamritskiy <roman@litgroup.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace LitGroup\Bundle\DnsBundle\Tests\DependencyInjection;


use LitGroup\Bundle\DnsBundle\DependencyInjection\LitGroupDnsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class LitGroupDnsExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function testFactory()
    {
        $container = new ContainerBuilder();
        $extension = new LitGroupDnsExtension();
        $extension->load([$this->getDefaultConfig()], $container);

        $this->assertTrue($container->hasParameter('litgroup_dns.resolver_factory.class'));
        $this->assertSame(
            'React\Dns\Resolver\Factory',
            $container->getParameter('litgroup_dns.resolver_factory.class')
        );

        $this->assertTrue($container->hasDefinition('litgroup_dns.resolver_factory'));

        $definition = $container->getDefinition('litgroup_dns.resolver_factory');
        $this->assertSame('%litgroup_dns.resolver_factory.class%', $definition->getClass());
        $this->assertTrue($definition->isPublic());
    }

    public function getResolverTests()
    {
        return [
            [ ['cache' => false], 'create' ],
            [ ['cache' => true], 'createCached' ],
        ];
    }

    /** @dataProvider getResolverTests */
    public function testResolver($config, $factoryMethod)
    {
        $container = new ContainerBuilder();
        $extension = new LitGroupDnsExtension();
        $config = array_merge($this->getDefaultConfig(), $config);
        $extension->load([$config], $container);

        $this->assertTrue($container->hasDefinition('litgroup_dns.resolver'));
        $definition = $container->getDefinition('litgroup_dns.resolver');
        $this->assertTrue($definition->isPublic());
        $this->assertSame('React\Dns\Resolver\Resolver', $definition->getClass());
        $this->assertSame('litgroup_dns.resolver_factory', $definition->getFactoryService());
        $this->assertSame($factoryMethod, $definition->getFactoryMethod());
        $arguments = $definition->getArguments();
        $this->assertCount(2, $arguments);
        $this->assertSame($config['nameserver'], $arguments[0]);
        $this->assertReference('litgroup_event_loop', $arguments[1]);
    }

    private function assertReference($expectedId, $reference)
    {
        $this->assertInstanceOf('Symfony\Component\DependencyInjection\Reference', $reference);
        $this->assertSame($expectedId, $reference->__toString());
    }

    /**
     * @return array
     */
    private function getDefaultConfig()
    {
        return ['nameserver' => '127.0.0.1'];
    }

}
 