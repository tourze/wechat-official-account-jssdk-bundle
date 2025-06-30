<?php

namespace WechatOfficialAccountJssdkBundle\Tests\Unit\Exception;

use PHPUnit\Framework\TestCase;
use WechatOfficialAccountJssdkBundle\Exception\InvalidAccountException;

class InvalidAccountExceptionTest extends TestCase
{
    public function testException_isInstanceOfRuntimeException(): void
    {
        $exception = new InvalidAccountException('Test message');

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Test message', $exception->getMessage());
    }

    public function testException_canBeCreatedWithoutMessage(): void
    {
        $exception = new InvalidAccountException();

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('', $exception->getMessage());
    }
}