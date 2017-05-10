<p align="center">
<a href="http://gmcloud.io/">
GMCloud
</a>
</p>
<p align="center">📦 Yunbi PHP SDK</p>

## Feature

 - 集成所有 `YUNBI API` 接口
 - 统一异常处理
 - 方法使用更优雅，不必再去研究那些奇怪的的方法名或者类名是做啥用的;
 - 符合 [PSR](https://github.com/php-fig/fig-standards) 标准, 你可以各种方便的与你的框架集成;

## Requirement

1. PHP >= 5.5.0
2. **[composer](https://getcomposer.org/)**

> SDK 对所使用的框架并无特别要求

## Installation

```shell
composer require lurrpis/yunbi
```

## Usage

基本使用:
```
use GMCloud\SDK\Yunbi;

Yunbi::setAccessKey('AccessKey');
Yunbi::setSecretKey('SecretKey');

$balance = Yunbi::membersMe();
```

## Documentation

- 暂无

## Integration

- 暂无

## Contribution

- 暂无

## License

MIT
