<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use WechatOfficialAccountJssdkBundle\DependencyInjection\WechatOfficialAccountJssdkExtension;

/**
 * @internal
 */
#[CoversClass(WechatOfficialAccountJssdkExtension::class)]
final class WechatOfficialAccountJssdkExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    public function testLoadWithEmptyConfigsLoadsServicesSuccessfully(): void
    {
        $extension = new WechatOfficialAccountJssdkExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $extension->load([], $container);

        $this->assertTrue($container->hasDefinition('wechat_official_account_jssdk.controller_loader'));
    }

    public function testGetAliasReturnsCorrectAlias(): void
    {
        $extension = new WechatOfficialAccountJssdkExtension();
        $this->assertEquals('wechat_official_account_jssdk', $extension->getAlias());
    }
}
