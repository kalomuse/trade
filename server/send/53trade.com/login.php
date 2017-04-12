<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_53trade($web) {
    global $SERVER;
    $ext_cookie = '';
    $url = "http://53trade.com/memberCenter/checkUser.asp";
    $post_data = array(
        'user_name'=> $web['account'],
        'user_pass'=> $web['password'],
        'x'=> '24',
        'y'=> '14',
    );

    $response = post($url, $post_data, $ext_cookie, 1, 3);
    preg_match('/Set-Cookie:(.*);/iU', $response['res'], $str);
    $tmp_val = explode('=', $str[1], 2);
    $login_cookie_name = [trim($tmp_val[0])];
    if(preg_match('/User name error/',$response['res'])) {
        return [0, "账号错误"];
    } else if (preg_match('/Password error/',$response['res'])) {
        return [0, "密码错误"];
    } else if(preg_match('/Object moved/',$response['res'])){
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else {
        return [0, '连接超时'];
    }


}



