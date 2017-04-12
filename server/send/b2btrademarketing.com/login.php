<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_b2btrademarketing($web) {
    global $SERVER;
    $ext_cookie = '';
    $login_cookie_name = ["PHPSESSID"];
    $url = "http://b2btrademarketing.com/index.php?action=logout";
    $post_data = array(
        'action'=> 'login',
        'login'=> $web['account'],
        'password'=> $web['password'],
        'submit'=> 'Sign In'
    );

    $response = post($url, $post_data, $ext_cookie, 1, 3);
    if(preg_match('/302 Found/',$response['res'])) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else if(!isset($response['res'])) {
        return [0, '连接超时'];
    } else {
        return [0, '用户名或密码错误'];
    }


}



