<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Tests\Controller;

use HttpClientBundle\Exception\HttpClientException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Tourze\PHPUnitSymfonyWebTest\AbstractWebTestCase;
use WechatOfficialAccountBundle\Entity\Account;
use WechatOfficialAccountBundle\Repository\AccountRepository;
use WechatOfficialAccountJssdkBundle\Controller\JsController;
use WechatOfficialAccountJssdkBundle\Exception\InvalidAccountException;

/**
 * @internal
 */
#[CoversClass(JsController::class)]
#[RunTestsInSeparateProcesses]
final class JsControllerTest extends AbstractWebTestCase
{
    private function createTestAccount(): Account
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test-app-id');
        $account->setAppSecret('test-app-secret-123456');

        $repository = self::getService(AccountRepository::class);
        $repository->save($account);

        return $account;
    }

    public function testJssdkRequestWithExistingAccount(): void
    {
        $client = self::createClientWithDatabase();
        $this->createTestAccount();

        // 账户存在，但会因为无效的微信凭证抛出HttpClientException
        $client->catchExceptions(false);
        $this->expectException(HttpClientException::class);
        $this->expectExceptionMessage('access_token missing');

        $client->request('GET', '/wechat/official-account/jssdk/test-app-id');
    }

    public function testAccountNotFound(): void
    {
        $client = self::createClientWithDatabase();

        // 账户不存在，应该抛出InvalidAccountException
        $client->catchExceptions(false);
        $this->expectException(InvalidAccountException::class);
        $this->expectExceptionMessage('Account with app_id "non-existent-app-id" not found');

        $client->request('GET', '/wechat/official-account/jssdk/non-existent-app-id');
    }

    public function testPostMethodSupported(): void
    {
        $client = self::createClientWithDatabase();
        $this->createTestAccount();

        // POST方法被允许，账户存在，但会因为无效的微信凭证抛出HttpClientException
        $client->catchExceptions(false);
        $this->expectException(HttpClientException::class);
        $this->expectExceptionMessage('access_token missing');

        $client->request('POST', '/wechat/official-account/jssdk/test-app-id');
    }

    #[DataProvider('provideNotAllowedMethods')]
    public function testMethodNotAllowed(string $method): void
    {
        $client = self::createClientWithDatabase();
        $this->expectException(MethodNotAllowedHttpException::class);
        $client->request($method, '/wechat/official-account/jssdk/test-app-id');
    }
}
