<?php

include_once "YdApi.php";
include_once "Const.php";
$ydapi = new YdApi(AESKEY, APPID, BUIN);
/*
    获取token
*/
$result = $ydapi->EncryptMsg(time());
list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
if ($errcode === 0) {
    list($errcode, $rsp) = $ydapi->GetToken(API_GET_TOKEN, $encrypt);
    if ($errcode === 0) {
        echo "获取 token: $rsp 成功<br>";
    } else {
        echo "获取 token 失败 errcode : $errcode , errmsg : $rsp <br/>";
        exit();
    }
}

$mediaId = '';

/*
    上传文件
*/
$fname = 'debug.log';
if (!file_exists($fname)) {
    echo "文件 $fname 不存在";
    exit();
}
$file = file_get_contents($fpath);

$msg = json_encode(['type' => 'file', 'name' => $fname, 'buin'=> BUIN, 'appId'=> APPID]);
list($errcode1, $encrypt_msg) = $ydapi->EncryptMsg($msg);
list($errcode2, $encrypt_file) = $ydapi->EncryptMsg($file);

if ($errcode1 === 0 && $errcode2 === 0) {
    list($errcode1, $mId) = $ydapi->UploadFile(API_UPLOAD_FILE, $encrypt_msg, $encrypt_file, $fname);
    if ($errcode1 === 0) {
        echo "上传文件成功 fileId : $mId <br/>";
        $mediaId = $mId;
    } else {
        echo "上传文件失败 errcode : $errcode1 <br/>";
        exit();
    }
} else {
    echo "加密失败";
    exit();
}

/*
    上传图片
*/
$fname = 'sample.png';
if (!file_exists($fname)) {
    echo "文件 $fname 不存在";
    exit();
}
$file = file_get_contents($fname);

$msg = json_encode(['type' => 'image', 'name' => $fname, 'buin'=> BUIN, 'appId'=> APPID]);
list($errcode1, $encrypt_msg) = $ydapi->EncryptMsg($msg);
list($errcode2, $encrypt_file) = $ydapi->EncryptMsg($file);

if ($errcode1 === 0 && $errcode2 === 0) {
    list($errcode1, $mId) = $ydapi->UploadFile(API_UPLOAD_FILE, $encrypt_msg, $encrypt_file, $fname);
    if ($errcode1 === 0) {
        echo "上传图片成功 mediaId : $mId <br/>";
        $mediaId = $mId;
    } else {
        echo "上传图片失败 errcode : $errcode1 <br/>";
        exit();
    }
} else {
    echo "加密失败";
    exit();
}

/*
    发送文字信息
*/
$msg = '{"toUser": "dico.zhang","msgType":"text","text":{"content": "it"}}';
$rsp = $ydapi->Send(API_SEND_MSG, $msg);
if ($rsp["errcode"] === 0) {
    echo "发送文字信息成功 ". $rsp["decrypt"]["id"] ."<br/>";
} else {
    echo "发送文字信息失败 errcode: ". $rsp["errcode"] .", errmsg: ". $rsp["errmsg"] ."<br/>";
    exit();
}

/*
    发送图片信息
*/
$msg = '{"toUser": "dico.zhang","msgType":"image","image":{"media_id": "'.$mediaId.'"}}';
$rsp = $ydapi->Send(API_SEND_MSG, $msg);
if ($rsp["errcode"] === 0) {
    echo '发送图片信息成功<br/>';
} else {
    echo "发送图片信息失败 errcode: $errcode, errmsg: $rsp<br/>";
    exit();
}

/*
    发送文件信息
*/
$msg = '{"toUser": "dico.zhang","msgType":"file","file":{"media_id": "'.$mediaId.'"}}';
$rsp = $ydapi->Send(API_SEND_MSG, $msg);
if ($rsp["errcode"] === 0) {
    echo '发送文件信息成功<br/>';
} else {
    echo "发送文件信息失败 errcode: $errcode, errmsg: $rsp<br/>";
    exit();
}

/*
    发送图文信息
*/
$msg = '{"toUser": "dico.zhang","msgType":"mpnews","mpnews":[{"title": "这里是标题","media_id": "'.$mediaId.'","digest": "这里是简介","content": "这里是内容","showFront": 1,"url": "http://www.baidu.com"}]}';
$rsp = $ydapi->Send(API_SEND_MSG, $msg);
if ($rsp["errcode"] === 0) {
    echo '发送图文信息成功<br/>';
} else {
    echo "发送图文信息失败 errcode: $errcode, errmsg: $rsp<br/>";
    exit();
}

/*
    发送外链信息
*/
$msg = '{"toUser": "dico.zhang","msgType":"exlink","exlink":[{"title": "这里是标题","media_id": "'.$mediaId.'","digest": "这里是简介","url": "http://www.baidu.com"}]}';
$rsp = $ydapi->Send(API_SEND_MSG, $msg);
if ($rsp["errcode"] === 0) {
    echo '发送图文信息成功<br/>';
} else {
    echo "发送图文信息失败 errcode: $errcode, errmsg: $rsp<br/>";
    exit();
}
