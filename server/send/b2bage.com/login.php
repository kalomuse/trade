<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_b2bage($web) {
    $ext_cookie = '';
    $login_cookie_name = ["NT_ID"];
    $url = "http://www.b2bage.com/signin.do?act=login";
    $post_data = array(
        'username'=> $web['account'],
        'password'=> $web['password'],
    );

    $response = post($url, $post_data, $ext_cookie, 1, 3);
    if(preg_match('/302 Moved Temporarily/',$response['res'])) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else {
        return [0, '账号或密码错误'];
    }


}



