<?php

include_once "YdApi.php";
include_once "Const.php";

$ydapi = new YdApi(AESKEY, APPID, BUIN);
/*
    获取token
*/
$result = $ydapi->EncryptMsg(time());
list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
if ($errcode == 0) {
    $result = $ydapi->GetToken(API_GET_TOKEN, $encrypt);
    if ($result == 0) {
        echo "获取 token 成功<br>";
    } else {
        echo "获取 token 失败 errcode : $errcode <br/>";
        exit();
    }
}

$mediaId = '';

/*
    上传文件
*/
$fname = 'sample.txt';
$fpath = $fname;
$file = file_get_contents($fpath);

$msg = json_encode(['type' => 'file', 'name' => $fname]);
list($errcode1, $encrypt_msg) = $ydapi->EncryptMsg($msg);
list($errcode2, $encrypt_file) = $ydapi->EncryptMsg($file);

if ($errcode1 == 0 && $errcode2 == 0) {
    list($errcode1, $mId) = $ydapi->UploadFile(API_UPLOAD_FILE, $encrypt_msg, $encrypt_file, $fpath);
    if ($errcode1 == 0) {
        echo "上传文件成功 fileId : $mId <br/>";
        $mediaId = $mId;
    } else {
        echo "上传文件失败 errcode : $errcode1 <br/>";
        exit();
    }
}

/*
    上传图片
*/
$fname = 'sample.png';
$fpath = $fname;
$file = file_get_contents($fpath);

$msg = json_encode(['type' => 'image', 'name' => $fname]);
list($errcode1, $encrypt_msg) = $ydapi->EncryptMsg($msg);
list($errcode2, $encrypt_file) = $ydapi->EncryptMsg($file);

if ($errcode1 == 0 && $errcode2 == 0) {
    list($errcode1, $mId) = $ydapi->UploadFile(API_UPLOAD_FILE, $encrypt_msg, $encrypt_file, $fpath);
    if ($errcode1 == 0) {
        echo "上传图片成功 fileId : $mId <br/>";
        $mediaId = $mId;
    } else {
        echo "上传图片失败 errcode : $errcode1 <br/>";
        exit();
    }
}

/*
    发送文字信息
*/
$msg = '{"toUser": "san.zhang|li.si","msgType":"text","text":{"content": "it"}}';
list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
if ($errcode == 0) {
    list($errcode, $msg) = $ydapi->Send(API_SEND_MSG, $encrypt);
    if ($errcode == 0) {
        echo '发送文字信息成功<br/>';
    } else {
        echo "发送文字信息失败 errcode: $errcode, errmsg: $msg<br/>";
        exit();
    }
}

/*
    发送图片信息
*/
$msg = '{"toUser": "san.zhang","msgType":"image","image":{"media_id": "'.$mediaId.'"}}';
list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
if ($errcode == 0) {
    list($errcode, $msg) = $ydapi->Send(API_SEND_MSG, $encrypt);
    if ($errcode == 0) {
        echo '发送图片信息成功<br/>';
    } else {
        echo "发送图片信息失败 errcode: $errcode, errmsg: $msg<br/>";
        exit();
    }
}

/*
    发送文件信息
*/
$msg = '{"toUser": "san.zhang","msgType":"file","file":{"media_id": "'.$mediaId.'"}}';
list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
if ($errcode == 0) {
    list($errcode, $msg) = $ydapi->Send(API_SEND_MSG, $encrypt);
    if ($errcode == 0) {
        echo '发送文件信息成功<br/>';
    } else {
        echo "发送文件信息失败 errcode: $errcode, errmsg: $msg<br/>";
        exit();
    }
}

/*
    发送图文信息
*/
$msg = '{"toUser": "san.zhang","msgType":"mpnews","mpnews":[{"title": "这里是标题","media_id": "'.$mediaId.'","digest": "这里是简介","content": "这里是内容","showFront": 1,"url": "http://www.baidu.com"}]}';
list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
if ($errcode == 0) {
    list($errcode, $msg) = $ydapi->Send(API_SEND_MSG, $encrypt);
    if ($errcode == 0) {
        echo '发送图文信息成功<br/>';
    } else {
        echo "发送图文信息失败 errcode: $errcode, errmsg: $msg<br/>";
        exit();
    }
}

/*
    发送外链信息
*/
$msg = '{"toUser": "san.zhang","msgType":"exlink","exlink":[{"title": "这里是标题","media_id": "'.$mediaId.'","digest": "这里是简介","url": "http://www.baidu.com"}]}';
list($errcode, $encrypt) = $ydapi->EncryptMsg($msg);
if ($errcode == 0) {
    list($errcode, $msg) = $ydapi->Send(API_SEND_MSG, $encrypt);
    if ($errcode == 0) {
        echo '发送外链信息成功<br/>';
    } else {
        echo "发送外链信息失败 errcode: $errcode, errmsg: $msg<br/>";
        exit();
    }
}
