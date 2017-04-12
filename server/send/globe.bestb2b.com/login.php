<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_globe_bestb2b($web) {
    $ext_cookie = '';
    $login_cookie_name = ["PHPSESSID"];
    $url = "http://globe.bestb2b.com/signin.aspx";
    $post_data = array(
        'username'=> $web['account'],
        'password'=> $web['password'],
        'userType:'=> 'corp',
        'Submit'=> 'Sign In',
        'PersistantLogin'=> '1',
    );

    $response = post($url, $post_data, $ext_cookie, 1, 3);
    if(preg_match('/302 Found/',$response['res'])) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else {
        return [0, "用户名或密码错误"];
    }
}



