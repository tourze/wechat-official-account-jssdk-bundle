<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatOfficialAccountJssdkBundle\WechatOfficialAccountJssdkBundle;

/**
 * @internal
 * @phpstan-ignore symplify.forbiddenExtendOfNonAbstractClass
 */
#[CoversClass(WechatOfficialAccountJssdkBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatOfficialAccountJssdkBundleTest extends AbstractBundleTestCase
{
}
