<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午9:24
 */

function post($url, $post_data = array(), $cookie = '', $get_header=0, $times=1) {
    $postfields = '';
    foreach ($post_data as $key => $value){
        $postfields .= urlencode($key) . '=' . urlencode($value) . '&';
    }
    $post_data = rtrim($postfields, '&');
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_HTTPHEADER,);
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HEADER, $get_header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    do {
        $res = curl_exec($ch);
        $times --;
    } while(!isset($res) && $times);
    curl_close($ch);

    return array(
        'res' => $res,
        'err' => curl_error(ch)
    );
}

function get($url, $cookie = '', $get_header = 0, $times=1) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch, CURLOPT_HEADER, $get_header);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    do {
        $res = curl_exec($ch);
        $times --;
    } while(!isset($res) && $times);
    curl_close($ch);
    return array(
        'res' => $res,
        'err' => curl_error(ch)
    );
}


function upload($url, $post_data, $cookie = '', $get_header=0, $times=1) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch,CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, $get_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    do {
        $res = curl_exec($ch);
        $times --;
    } while(!isset($res) && $times);
    curl_close($ch);
    return array(
        'res' => $res,
        'err' => curl_error(ch)
    );
}