# 支付宝接口 php slim 框架

## Description
支付宝独立API封装，采用php slim框架搭建，使用官方php sdk,[https://github.com/mytharcher/alipay-php-sdk] 简化配置，
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
    