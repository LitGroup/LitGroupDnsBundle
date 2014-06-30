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


use LitGroup\Bundle\DnsBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function testDefaultValues()
    {
        $configuration = new Configuration();
        $processor     = new Processor();

        $config = $processor->processConfiguration($configuration, [
            ['nameserver' => '127.0.0.1']
        ]);

        $this->assertArrayHasKey('nameserver', $config);
        $this->assertSame('127.0.0.1', $config['nameserver']);

        $this->assertArrayHasKey('cache', $config);
        $this->assertFalse($config['cache']);
    }

    /** @test */
    public function testCacheOption()
    {
        $configuration = new Configuration();
        $processor     = new Processor();

        $config = $processor->processConfiguration($configuration, [
            ['nameserver' => '127.0.0.1', 'cache' => true],
        ]);

        $this->assertTrue($config['cache']);
    }

    /** @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException */
    public function testNameserverIsMissed()
    {
        $configuration = new Configuration();
        $processor     = new Processor();

        $processor->processConfiguration($configuration, []);
    }
}
 