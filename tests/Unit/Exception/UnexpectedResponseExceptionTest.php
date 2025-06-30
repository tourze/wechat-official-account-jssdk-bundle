<?php

namespace WechatOfficialAccountJssdkBundle\Tests\Unit\Exception;

use PHPUnit\Framework\TestCase;
use WechatOfficialAccountJssdkBundle\Exception\UnexpectedResponseException;

class UnexpectedResponseExceptionTest extends TestCase
{
    public function testException_isInstanceOfRuntimeException(): void
    {
        $exception = new UnexpectedResponseException('Test message');

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('Test message', $exception->getMessage());
    }

    public function testException_canBeCreatedWithoutMessage(): void
    {
        $exception = new UnexpectedResponseException();

        $this->assertInstanceOf(\RuntimeException::class, $exception);
        $this->assertEquals('', $exception->getMessage());
    }
}