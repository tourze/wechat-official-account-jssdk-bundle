<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Large;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Routing\RouteCollection;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatOfficialAccountJssdkBundle\Service\AttributeControllerLoader;

/**
 * @internal
 */
#[CoversClass(AttributeControllerLoader::class)]
#[Large]
#[RunTestsInSeparateProcesses]
final class AttributeControllerLoaderTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // 不需要特殊的设置，AttributeControllerLoader 是无状态的
    }

    public function testLoaderInitialization(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);
        $this->assertInstanceOf(AttributeControllerLoader::class, $loader);
    }

    public function testSupportsWithAnyResourceReturnsFalse(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);
        // supports 方法始终返回 false，因为它仅通过 autoload 方法加载
        $this->assertFalse($loader->supports('any_resource'));
    }

    public function testLoadWithAnyResourceReturnsRouteCollection(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);
        // 执行测试 - 测试真实对象的行为
        $result = $loader->load('any_resource');

        // 验证结果 - load 方法应该返回 RouteCollection
        $this->assertInstanceOf(RouteCollection::class, $result);

        // 验证路由集合不为空
        $routes = $result->all();
        $this->assertNotEmpty($routes);
    }

    public function testAutoloadReturnsRouteCollection(): void
    {
        $loader = self::getService(AttributeControllerLoader::class);
        // 执行测试
        $collection = $loader->autoload();

        // 验证结果
        $this->assertInstanceOf(RouteCollection::class, $collection);

        // 验证路由集合中包含 JsController 的路由
        $routes = $collection->all();
        $this->assertNotEmpty($routes);

        // 检查是否包含 wechat_official_account_jssdk 路由
        $this->assertArrayHasKey('wechat_official_account_jssdk', $routes);
    }
}
