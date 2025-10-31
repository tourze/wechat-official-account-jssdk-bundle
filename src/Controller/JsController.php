<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use WechatOfficialAccountBundle\Repository\AccountRepository;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountJssdkBundle\Exception\InvalidAccountException;
use WechatOfficialAccountJssdkBundle\Exception\UnexpectedResponseException;
use WechatOfficialAccountJssdkBundle\Request\GetJsapiTicketRequest;

#[Autoconfigure(public: true)]
final class JsController extends AbstractController
{
    /**
     * 获取JSSDK配置
     *
     * @see https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/JS-SDK.html
     */
    #[Route(path: '/wechat/official-account/jssdk/{appId}', name: 'wechat_official_account_jssdk', methods: ['GET', 'POST'])]
    public function __invoke(string $appId, AccountRepository $accountRepository, Request $request, OfficialAccountClient $client): Response
    {
        $account = $accountRepository->find($appId);
        if (null === $account) {
            throw new InvalidAccountException(sprintf('Account with app_id "%s" not found', $appId));
        }

        $ticketRequest = new GetJsapiTicketRequest();
        $ticketRequest->setAccount($account);
        $re = $client->request($ticketRequest);

        // 验证微信API响应格式
        if (!is_array($re) || !isset($re['ticket']) || !is_string($re['ticket'])) {
            throw new UnexpectedResponseException('Invalid response format from WeChat API');
        }

        $jsApiList = ['updateAppMessageShareData', 'updateTimelineShareData'];
        $api = $request->get('api');
        if (null !== $api && is_string($api)) {
            $jsApiList = explode(',', $api);
        }

        $timestamp = (string) time();
        $nonce = md5($timestamp);
        $url = $request->get('url');
        $url = is_string($url) ? $url : '';
        $signature = sha1(sprintf('jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s', $re['ticket'], $nonce, $timestamp, $url));
        $config = [
            'debug' => filter_var($request->get('debug', false), FILTER_VALIDATE_BOOLEAN),
            'beta' => filter_var($request->get('beta', false), FILTER_VALIDATE_BOOLEAN),
            'jsApiList' => $jsApiList,
            'openTagList' => [],
            'appId' => $account->getAppId(),
            'nonceStr' => $nonce,
            'timestamp' => $timestamp,
            'url' => $url,
            'signature' => $signature,
        ];

        return new JsonResponse($config);
    }
}
