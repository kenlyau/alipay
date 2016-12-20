# 支付宝接口 php slim 框架

## Description
需求：实现一个独立的第三方支付系统（可以理解为只对自己开放的支付微服务），这样自己的所有项目
都可以请求这个服务来实现支付功能，将支付系统和其他业务系统解耦，也方便统一管理。

采用php slim框架搭建，使用官方php sdk,[https://github.com/mytharcher/alipay-php-sdk] 简化配置，
alipay_config.json 文件进行配置。
需要提供cacert.pem,alipay_public_key.pem，这两个在官方php sdk中有提供，和自己的rsa_private_key.pem文件。

## Install the Application

    git clone this repository
    composer install

## API
```
	/api/order [post] //提交订单
	/api/order [get] //订单列表
	/api/order/id [get] //获取单个订单详情
	/api/reception //接收支付宝回调
```
    