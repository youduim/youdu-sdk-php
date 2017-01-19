<?php

    // 假设企业号在公众平台上设置的参数如下

    define('SCHEME', 'http://');

    define('URL_YOUDU_API', '10.0.0.188:7080'); // 请填写有度服务器地址

    define('API_GET_TOKEN', SCHEME . URL_YOUDU_API . '/cgi/gettoken'); // 获取token api

    define('API_SEND_MSG', SCHEME . URL_YOUDU_API . '/cgi/msg/send'); // 发送信息API

    define('API_UPLOAD_FILE', SCHEME . URL_YOUDU_API . '/cgi/media/upload'); // 文件上传API

    define('API_DOWNLOAD_FILE', SCHEME . URL_YOUDU_API . '/cgi/media/get'); // 文件下载API

    define('API_SEARCH_FILE', SCHEME . URL_YOUDU_API . '/cgi/media/search'); // 文件搜索API

    define('BUIN', 56565656);  //请填写企业总机号

    define('AESKEY', 'A0aWSqDL5SV4fafQl3OavoVPUn6sx7xNnD+1hOoTeWk='); // 请填写企业应用回调用的AESKey

    define('APPID', 'yd06AB76EC519B4130A802224B4C60F689'); // 请填写企业应用AppId

    define('ACCESSTOKEN', ''); // 请填写企业应用回调Token

    define('SAVEPATH', './download/'); // 请填写文件保存路径
    
?>