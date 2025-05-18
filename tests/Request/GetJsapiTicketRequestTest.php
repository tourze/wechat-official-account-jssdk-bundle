<?php

namespace WechatOfficialAccountJssdkBundle\Tests\Request;

use PHPUnit\Framework\TestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountJssdkBundle\Request\GetJsapiTicketRequest;

class GetJsapiTicketRequestTest extends TestCase
{
    private GetJsapiTicketRequest $request;
    private Account $account;

    protected function setUp(): void
    {
        $this->request = new GetJsapiTicketRequest();
        $this->account = $this->createMock(Account::class);
        $this->account->method('getAppId')->willReturn('test_app_id');
        $this->request->setAccount($this->account);
    }

    public function testGetRequestPath_returnsCorrectPath(): void
    {
        $expected = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi';
        $this->assertEquals($expected, $this->request->getRequestPath());
    }

    public function testGetRequestOptions_returnsEmptyArray(): void
    {
        $this->assertEquals([], $this->request->getRequestOptions());
    }

    public function testGetRequestMethod_returnsGet(): void
    {
        $this->assertEquals('GET', $this->request->getRequestMethod());
    }

    public function testGetCacheKey_returnsFormattedKey(): void
    {
        $expected = 'WechatOfficialAccount_TICKET_test_app_id';
        $this->assertEquals($expected, $this->request->getCacheKey());
    }

    public function testGetCacheDuration_returns3600Seconds(): void
    {
        $expected = 60 * 60; // 3600秒 = 1小时
        $this->assertEquals($expected, $this->request->getCacheDuration());
    }
} 