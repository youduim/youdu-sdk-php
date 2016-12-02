<?php

/**
 * http助手类，使用 curl post 数据
 *
 * @copyright Copyright (c) xinda.im
 */

class HttpUtils
{
    public function Post($url, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
            'Content-Type: application/json',
            'content-Length: ' . strlen(json_encode($data)))                                                                       
        );        
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $server_output = curl_exec ($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($server_output, 0, $header_size);
        $body = substr($server_output, $header_size);
        curl_close ($ch);
        return ['header' => $header, 'body' => $body];
    }

    public function Upload($url, $data)
    {
        $ch = curl_init();
        // $data = array('name' => 'Foo', 'file' => '@' . realpath('ydapi/newfile.txt'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);    // 5.6 给改成 true了, 弄回去 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);
        curl_close ($ch);
        return json_decode($server_output);
    }
}

?>