<?php

declare(strict_types=1);

namespace WechatOfficialAccountJssdkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\RoutingAutoLoaderBundle\RoutingAutoLoaderBundle;
use WechatOfficialAccountBundle\WechatOfficialAccountBundle;

class WechatOfficialAccountJssdkBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            WechatOfficialAccountBundle::class => ['all' => true],
            RoutingAutoLoaderBundle::class => ['all' => true],
        ];
    }
}
