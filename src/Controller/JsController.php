<?php

namespace WechatOfficialAccountJssdkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use WechatOfficialAccountBundle\Repository\AccountRepository;
use WechatOfficialAccountBundle\Service\OfficialAccountClient;
use WechatOfficialAccountJssdkBundle\Request\GetJsapiTicketRequest;

class JsController extends AbstractController
{
    /**
     * 获取JSSDK配置
     *
     * @see https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/JS-SDK.html
     */
    #[Route(path: '/wechat/official-account/jssdk/{appId}', name: 'wechat_official_account_jssdk', methods: ['GET', 'POST'])]
    public function jssdk(string $appId, AccountRepository $accountRepository, Request $request, OfficialAccountClient $client): Response
    {
        $account = $accountRepository->find($appId);
        $ticketRequest = new GetJsapiTicketRequest();
        $ticketRequest->setAccount($account);
        $re = $client->request($ticketRequest);

        $jsApiList = ['updateAppMessageShareData', 'updateTimelineShareData'];
        if ($api = $request->query->get('api')) {
            $jsApiList = explode(',', (string) $api);
        }

        $timestamp = time();
        $nonce = md5($timestamp);
        $url = $request->query->has('url', '');
        $signature = sha1(sprintf('jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s', $re['ticket'], $nonce, $timestamp, $url));
        $config = [
            'debug' => $request->query->get('debug', false),
            'beta' => $request->query->get('beta', false),
            'jsApiList' => $jsApiList,
            'openTagList' => [],
            'appId' => $account->getAppId(),
            'nonceStr' => $nonce,
            'timestamp' => $timestamp,
            'url' => $url,
            'signature' => $signature,
        ];

        return $this->json($config);
    }
}
