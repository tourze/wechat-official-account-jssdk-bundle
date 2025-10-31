# WechatOfficialAccountJssdkBundle

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue.svg)](https://packagist.org/packages/tourze/wechat-official-account-jssdk-bundle)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/tourze/wechat-official-account-jssdk-bundle)
[![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg)](https://github.com/tourze/wechat-official-account-jssdk-bundle)

[English](README.md) | [中文](README.zh-CN.md)

微信公众号 JS-SDK 的 Symfony Bundle。该包提供了便捷的方式来生成微信小程序和公众号的 JS-SDK 配置信息。

## 功能特性

- 自动生成微信 JS-SDK 配置
- 支持自定义 JS API 列表
- 内置 jsapi_ticket 缓存机制
- RESTful API 端点便于前端集成
- 兼容 Symfony 6.4+

## 安装

```bash
composer require tourze/wechat-official-account-jssdk-bundle
```

## 快速开始

### 1. 注册 Bundle

将 Bundle 添加到您的 `config/bundles.php`:

```php
return [
    // ...
    WechatOfficialAccountJssdkBundle\WechatOfficialAccountJssdkBundle::class => ['all' => true],
];
```

### 2. 配置微信账号

确保您已在 `wechat-official-account-bundle` 中配置了微信公众号。

### 3. 获取 JS-SDK 配置

向端点发送 GET 请求：

```bash
curl "https://your-domain.com/wechat/official-account/jssdk/{appId}?url=https://example.com"
```

响应示例：

```json
{
    "debug": false,
    "beta": false,
    "jsApiList": ["updateAppMessageShareData", "updateTimelineShareData"],
    "openTagList": [],
    "appId": "your-app-id",
    "nonceStr": "random-nonce-string",
    "timestamp": 1234567890,
    "url": "https://example.com",
    "signature": "generated-signature"
}
```

### 4. 前端使用

```javascript
wx.config({
    debug: false,
    appId: 'your-app-id',
    timestamp: 1234567890,
    nonceStr: 'random-nonce-string',
    signature: 'generated-signature',
    jsApiList: ['updateAppMessageShareData', 'updateTimelineShareData']
});
```

## API 参数

- `appId` (必需): 微信公众号 App ID
- `url` (可选): 需要签名的 URL，默认为空字符串
- `api` (可选): 逗号分隔的 JS API 列表
- `debug` (可选): 启用调试模式，默认为 false
- `beta` (可选): 启用 beta 功能，默认为 false

## 许可证

MIT
