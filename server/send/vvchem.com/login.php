<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_vvchem($web) {
    $ext_cookie = '';
    $login_cookie_name = ["JSESSIONID", "rember", "email"];
    $url = "http://www.vvchem.com/user.do?action=login";
    $post_data = array(
        'email'=>$web['account'],
        'password'=>$web['password'],
        'x'=>101,
        'y'=>9,
    );

    $response = post($url, $post_data, '', 1);
    if(preg_match('/302 Found/', $response['res'])) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else {
        return [0, '账号或密码错误'];
    }

}



