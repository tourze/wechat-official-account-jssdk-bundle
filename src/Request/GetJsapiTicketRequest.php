<?php

namespace WechatOfficialAccountJssdkBundle\Request;

use HttpClientBundle\Request\CacheRequest;
use WechatOfficialAccountBundle\Request\WithAccountRequest;

/**
 * @see https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/JS-SDK.html#62
 */
class GetJsapiTicketRequest extends WithAccountRequest implements CacheRequest
{
    public function getRequestPath(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi';
    }

    public function getRequestOptions(): ?array
    {
        return [];
    }

    public function getRequestMethod(): ?string
    {
        return 'GET';
    }

    public function getCacheKey(): string
    {
        return "WechatOfficialAccount_TICKET_{$this->getAccount()->getAppId()}";
    }

    public function getCacheDuration(): int
    {
        return 60 * 60;
    }
}
