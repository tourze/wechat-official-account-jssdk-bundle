<?php

namespace WechatOfficialAccountJssdkBundle\Request;

use HttpClientBundle\Request\CacheRequest;
use WechatOfficialAccountBundle\Request\WithAccountRequest;
use WechatOfficialAccountJssdkBundle\Exception\InvalidAccountException;

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
        $account = $this->getAccount();
        if ($account instanceof \WechatOfficialAccountBundle\Entity\Account) {
            return "WechatOfficialAccount_TICKET_{$account->getAppId()}";
        }
        throw new InvalidAccountException('Account must be an instance of Account to get app ID');
    }

    public function getCacheDuration(): int
    {
        return 60 * 60;
    }
}
