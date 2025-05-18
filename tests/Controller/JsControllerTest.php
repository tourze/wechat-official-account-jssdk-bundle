<?php

namespace WechatOfficialAccountJssdkBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountBundle\Repository\AccountRepository;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountJssdkBundle\Controller\JsController;

class JsControllerTest extends TestCase
{
    private JsController $controller;
    private AccountRepository $accountRepository;
    private OfficialAccountClient $client;
    private Account $account;

    protected function setUp(): void
    {
        $this->controller = new JsController();
        
        // 模拟容器
        $container = new Container();
        $reflectionProperty = new \ReflectionProperty(AbstractController::class, 'container');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->controller, $container);
        
        // 模拟 AccountRepository
        $this->account = $this->createMock(Account::class);
        $this->account->method('getAppId')->willReturn('test_app_id');
        
        $this->accountRepository = $this->createMock(AccountRepository::class);
        $this->accountRepository->method('find')
            ->with('test_app_id')
            ->willReturn($this->account);
        
        // 模拟 OfficialAccountClient
        $this->client = $this->createMock(OfficialAccountClient::class);
        $this->client->method('request')
            ->willReturn(['ticket' => 'test_ticket']);
    }
    
    public function testJssdk_withDefaultParameters_returnsValidConfig(): void
    {
        // 创建请求对象，直接使用实例而不是 mock
        $request = new Request();
        
        // 手动设置参数包
        $request->query = new ParameterBag([
            'url' => '',
            'debug' => false,
            'beta' => false,
        ]);

        // 调用控制器方法
        $response = $this->callController($request);
        
        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        
        // 获取响应内容
        $responseData = json_decode($response->getContent(), true);
        
        // 验证结果
        $this->assertArrayHasKey('appId', $responseData);
        $this->assertEquals('test_app_id', $responseData['appId']);
        $this->assertArrayHasKey('jsApiList', $responseData);
        $this->assertIsArray($responseData['jsApiList']);
        $this->assertEquals(['updateAppMessageShareData', 'updateTimelineShareData'], $responseData['jsApiList']);
    }

    public function testJssdk_withCustomApiList_returnsCustomConfig(): void
    {
        // 创建请求对象，带自定义 API 列表
        $request = new Request();
        
        // 手动设置参数包
        $request->query = new ParameterBag([
            'api' => 'chooseImage,previewImage',
            'url' => '',
            'debug' => false,
            'beta' => false,
        ]);

        // 调用控制器方法
        $response = $this->callController($request);
        
        // 获取响应内容
        $responseData = json_decode($response->getContent(), true);
        
        // 验证自定义 API 列表
        $this->assertEquals(['chooseImage', 'previewImage'], $responseData['jsApiList']);
    }

    public function testJssdk_withDebugMode_returnsDebugConfig(): void
    {
        // 创建请求对象，开启调试模式
        $request = new Request();
        
        // 手动设置参数包
        $request->query = new ParameterBag([
            'url' => '',
            'debug' => true,
            'beta' => false,
        ]);

        // 调用控制器方法
        $response = $this->callController($request);
        
        // 获取响应内容
        $responseData = json_decode($response->getContent(), true);
        
        // 验证调试模式
        $this->assertTrue($responseData['debug']);
    }

    /**
     * 辅助方法：调用控制器并返回响应
     */
    private function callController(Request $request): JsonResponse
    {
        // 使用我们准备好的依赖调用控制器方法
        return $this->controller->jssdk(
            'test_app_id',
            $this->accountRepository,
            $request,
            $this->client
        );
    }
} 