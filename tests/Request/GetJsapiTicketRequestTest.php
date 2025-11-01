<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Tests\Request;

use HttpClientBundle\Test\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountJssdkBundle\Request\GetJsapiTicketRequest;

/**
 * @internal
 */
#[CoversClass(GetJsapiTicketRequest::class)]
final class GetJsapiTicketRequestTest extends RequestTestCase
{
    private GetJsapiTicketRequest $request;

    private Account $account;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new GetJsapiTicketRequest();
        // 使用具体类 Account 而不是接口的原因：
        // 1) Account 是 Doctrine Entity，不存在对应的接口，必须直接使用具体类
        // 2) 在单元测试中模拟 Entity 是合理的做法，用于测试请求对象的行为
        // 3) 没有更好的替代方案，因为 Entity 本身就是数据模型的最终实现
        $this->account = $this->createMock(Account::class);
        $this->account->method('getAppId')->willReturn('test_app_id');
        $this->request->setAccount($this->account);
    }

    public function testGetRequestPathReturnsCorrectPath(): void
    {
        $expected = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi';
        $this->assertEquals($expected, $this->request->getRequestPath());
    }

    public function testGetRequestOptionsReturnsEmptyArray(): void
    {
        $this->assertEquals([], $this->request->getRequestOptions());
    }

    public function testGetRequestMethodReturnsGet(): void
    {
        $this->assertEquals('GET', $this->request->getRequestMethod());
    }

    public function testGetCacheKeyReturnsFormattedKey(): void
    {
        $expected = 'WechatOfficialAccount_TICKET_test_app_id';
        $this->assertEquals($expected, $this->request->getCacheKey());
    }

    public function testGetCacheDurationReturns3600Seconds(): void
    {
        $expected = 60 * 60; // 3600秒 = 1小时
        $this->assertEquals($expected, $this->request->getCacheDuration());
    }
}
