<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use WechatOfficialAccountJssdkBundle\Exception\UnexpectedResponseException;

/**
 * @internal
 */
#[CoversClass(UnexpectedResponseException::class)]
final class UnexpectedResponseExceptionTest extends AbstractExceptionTestCase
{
    public function testExceptionIsInstanceOfRuntimeException(): void
    {
        $exception = new UnexpectedResponseException('Test message');

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Test message', $exception->getMessage());
    }

    public function testExceptionCanBeCreatedWithoutMessage(): void
    {
        $exception = new UnexpectedResponseException();

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('', $exception->getMessage());
    }
}
