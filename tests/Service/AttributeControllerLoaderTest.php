<?php

namespace WechatOfficialAccountJssdkBundle\Tests\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouteCollection;
use WechatOfficialAccountJssdkBundle\Service\AttributeControllerLoader;

class AttributeControllerLoaderTest extends TestCase
{
    private AttributeControllerLoader $loader;

    protected function setUp(): void
    {
        $this->loader = new AttributeControllerLoader();
    }

    public function testSupports_withAnyResource_returnsFalse(): void
    {
        // supports 方法始终返回 false，因为它仅通过 autoload 方法加载
        $this->assertFalse($this->loader->supports('any_resource'));
    }

    public function testLoad_withAnyResource_returnsRouteCollection(): void
    {
        // 执行测试 - 测试真实对象的行为
        $result = $this->loader->load('any_resource');
        
        // 验证结果 - load 方法应该返回 RouteCollection
        $this->assertInstanceOf(RouteCollection::class, $result);
        
        // 验证路由集合不为空
        $routes = $result->all();
        $this->assertNotEmpty($routes);
    }

    public function testAutoload_returnsRouteCollection(): void
    {
        // 执行测试
        $collection = $this->loader->autoload();
        
        // 验证结果
        $this->assertInstanceOf(RouteCollection::class, $collection);
        
        // 验证路由集合中包含 JsController 的路由
        $routes = $collection->all();
        $this->assertNotEmpty($routes);
        
        // 检查是否包含 wechat_official_account_jssdk 路由
        $this->assertArrayHasKey('wechat_official_account_jssdk', $routes);
    }
} 