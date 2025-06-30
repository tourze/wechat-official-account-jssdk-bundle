<?php

namespace WechatOfficialAccountJssdkBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatOfficialAccountJssdkBundle\DependencyInjection\WechatOfficialAccountJssdkExtension;
use WechatOfficialAccountJssdkBundle\WechatOfficialAccountJssdkBundle;

class WechatOfficialAccountJssdkBundleTest extends TestCase
{
    private WechatOfficialAccountJssdkBundle $bundle;

    protected function setUp(): void
    {
        $this->bundle = new WechatOfficialAccountJssdkBundle();
    }

    public function testGetContainerExtension_returnsCorrectExtension(): void
    {
        $extension = $this->bundle->getContainerExtension();

        $this->assertInstanceOf(WechatOfficialAccountJssdkExtension::class, $extension);
    }

    public function testBuild_configuresContainer(): void
    {
        $container = new ContainerBuilder();
        
        $this->bundle->build($container);
        
        $this->assertInstanceOf(ContainerBuilder::class, $container);
    }
}