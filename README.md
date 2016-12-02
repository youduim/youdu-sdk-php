# 有度企业应用 php 示例

提供一系列demo供用户接入有度企业应用，方便开发者参考使用。

## 功能介绍

- 企业应用http接口调用封装（sdk）
- 企业应用接口调用测试用例
- 企业应用回调接口测试用例

## 依赖模块

- cURL
- javatuples 1.2
- Mcrypt

## 运行前配置

运行前请修改Const.php 下各个常量配置。

## 运行

### 发送消息

运行 sdk 目录下的 sendmsg.php 文件

### 回调设置

运行 sdk 目录下的 receivemsg.php 文件，运行结果会在同级目录下 debug.log 中显示

## 注意事项

YdApi.php 文件封装了YdApi类， 是用户接入有度企业应用的接口类。sendmsg.php提供了示例以供开发者参考。ErrorCode.php, Pkcs7Encoder.php, Sha1.php文件是实现这个类的辅助类，开发者无须关心其具体实现。
