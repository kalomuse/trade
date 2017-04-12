<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_member_bossgoo($web) {
    $ext_cookie = '';
    $login_cookie_name = ["PHPSESSID"];
    $url = "http://member.bossgoo.com/signin.html";
    $post_data = array(
        'LoginForm[idoremail]'=> $web['account'],
        'LoginForm[password]'=> $web['password'],
        'yt0'=> 'Sign In',
    );

    $response = post($url, $post_data, $ext_cookie, 1);
    if(preg_match('/302 Moved Temporarily/', $response['res'])) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else {
        return [0, '账号或密码错误'];
    }

}



