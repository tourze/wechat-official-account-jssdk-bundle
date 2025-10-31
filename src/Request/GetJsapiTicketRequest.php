<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Request;

use HttpClientBundle\Request\CacheRequest;
use WechatOfficialAccountBundle\Entity\Account;
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

    /**
     * @return array<string, mixed>
     */
    public function getRequestOptions(): array
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
        if ($account instanceof Account) {
            return "WechatOfficialAccount_TICKET_{$account->getAppId()}";
        }
        throw new InvalidAccountException('Account must be an instance of Account to get app ID');
    }

    public function getCacheDuration(): int
    {
        return 60 * 60;
    }
}
