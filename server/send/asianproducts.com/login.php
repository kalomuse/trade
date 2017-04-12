<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_asianproducts($web) {
    $ext_cookie = '';
    $login_cookie_name = ["PHPSESSID"];
    $url = "https://member.asianproducts.com/sign_new.php";
    $post_data = array(
        'client_login_name'=> $web['account'],
        'client_login_password'=> $web['password'],
        'sign'=> 'Sign In',
        'returnUrl'=> 'http://www.asianproducts.com/member.php',
    );

    $response = post($url, $post_data, $ext_cookie, 1, 3);
    if(preg_match('/302 Found/',$response['res'])) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else {
        return [0, "用户名或密码错误"];
    }
}



