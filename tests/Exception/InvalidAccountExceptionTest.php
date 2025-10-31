<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Tests\Exception;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;
use WechatOfficialAccountJssdkBundle\Exception\InvalidAccountException;

/**
 * @internal
 */
#[CoversClass(InvalidAccountException::class)]
final class InvalidAccountExceptionTest extends AbstractExceptionTestCase
{
    public function testExceptionIsInstanceOfRuntimeException(): void
    {
        $exception = new InvalidAccountException('Test message');

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Test message', $exception->getMessage());
    }

    public function testExceptionCanBeCreatedWithoutMessage(): void
    {
        $exception = new InvalidAccountException();

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('', $exception->getMessage());
    }
}
