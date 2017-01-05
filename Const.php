<?php

    // 假设企业号在公众平台上设置的参数如下

    define('SCHEME', 'http://');

    define('URL_YOUDU_API', 'test.com'); // 请填写有度服务器地址

    define('API_GET_TOKEN', SCHEME . URL_YOUDU_API . '/v3/api/jgapp/ent.app.accesstoken.gen'); // 获取token api

    define('API_SEND_MSG', SCHEME . URL_YOUDU_API . '/v3/api/jgapp/ent.app.msg.send'); // 发送信息API

    define('API_UPLOAD_FILE', SCHEME . URL_YOUDU_API . '/v3/api/jgapp/ent.app.media.upload'); // 文件上传API

    define('API_DOWNLOAD_FILE', SCHEME . URL_YOUDU_API . '/v3/api/jgapp/ent.app.media.get'); // 文件下载API

    define('BUIN', 72907129);  //请填写企业总机号

    define('AESKEY', '2xI9uzCmcZRNaOu53MfeBq8mAWflU/jDITxQe414qYA='); // 请填写企业应用回调用的AESKey

    define('APPID', 'yd77DF9974C7984E7B971E5DFC99A9D1B0'); // 请填写企业应用AppId

    define('ACCESSTOKEN', ''); // 请填写企业应用回调Token

    define('SAVEPATH', './download/'); // 请填写文件保存路径
    
?>
