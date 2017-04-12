<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_en_asiadcp($web) {
    $ext_cookie = '';
    $login_cookie_name = ["euid", "loginname"];
    $url = "http://en.asiadcp.com/member/memberlogin.php?action=1";
    $post_data = array(
        'loginname'=> $web['account'],
        'loginpwd'=> $web['password'],
    );

    $response = post($url, $post_data, $ext_cookie, 1);
    if(preg_match('/en_login\.php/', $response['res']))
        return [0, '账号或密码错误'];
    else {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    }

}



