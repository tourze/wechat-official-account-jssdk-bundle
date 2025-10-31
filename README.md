# WechatOfficialAccountJssdkBundle

[![PHP Version](https://img.shields.io/badge/php-%5E8.1-blue.svg)](https://packagist.org/packages/tourze/wechat-official-account-jssdk-bundle)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/tourze/wechat-official-account-jssdk-bundle)
[![Code Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg)](https://github.com/tourze/wechat-official-account-jssdk-bundle)

[English](README.md) | [中文](README.zh-CN.md)

A Symfony Bundle for WeChat Official Account JS-SDK integration. This bundle provides a convenient way to generate JS-SDK configuration for WeChat Mini Programs and Official Accounts.

## Features

- Generate WeChat JS-SDK configuration automatically
- Support for custom JS API list
- Built-in caching for jsapi_ticket
- RESTful API endpoint for frontend integration
- Compatible with Symfony 6.4+

## Installation

```bash
composer require tourze/wechat-official-account-jssdk-bundle
```

## Quick Start

### 1. Register the Bundle

Add the bundle to your `config/bundles.php`:

```php
return [
    // ...
    WechatOfficialAccountJssdkBundle\WechatOfficialAccountJssdkBundle::class => ['all' => true],
];
```

### 2. Configure WeChat Account

Make sure you have configured your WeChat Official Account in the `wechat-official-account-bundle`.

### 3. Get JS-SDK Configuration

Make a GET request to the endpoint:

```bash
curl "https://your-domain.com/wechat/official-account/jssdk/{appId}?url=https://example.com"
```

Response example:

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

### 4. Use in Frontend

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

## API Parameters

- `appId` (required): WeChat Official Account App ID
- `url` (optional): The URL to sign, defaults to empty string
- `api` (optional): Comma-separated list of JS APIs to enable
- `debug` (optional): Enable debug mode, defaults to false
- `beta` (optional): Enable beta features, defaults to false

## License

MIT