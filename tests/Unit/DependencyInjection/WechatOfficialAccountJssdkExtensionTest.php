<?php

namespace WechatOfficialAccountJssdkBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatOfficialAccountJssdkBundle\DependencyInjection\WechatOfficialAccountJssdkExtension;

class WechatOfficialAccountJssdkExtensionTest extends TestCase
{
    private WechatOfficialAccountJssdkExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new WechatOfficialAccountJssdkExtension();
        $this->container = new ContainerBuilder();
    }

    public function testLoad_withEmptyConfigs_loadsServicesSuccessfully(): void
    {
        $this->extension->load([], $this->container);

        $this->assertTrue($this->container->hasDefinition('wechat_official_account_jssdk.controller_loader'));
    }

    public function testGetAlias_returnsCorrectAlias(): void
    {
        $this->assertEquals('wechat_official_account_jssdk', $this->extension->getAlias());
    }
}