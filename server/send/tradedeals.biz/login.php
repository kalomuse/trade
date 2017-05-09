<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_tradedeals($web) {
    $url = "http://tradedeals.biz/";
    $response = get($url, '', 1);
    $cookie = get_cookie_str_for_html($response['res']);
    str_set_cookie($cookie);
    $ext_cookie = '';
    $login_cookie_name = ["ci_session"];
    $url = "http://tradedeals.biz/auth/login";
    $post_data = array(
        'identity'=> $web['account'],
        'password'=> $web['password'],
        'submit'=> 'Log in'
    );

    $response = post($url, $post_data, $cookie, 1);
    if(preg_match('/login/', $response['res']))
        return [0, '账号或密码错误'];
    else {
        return [1, $login_cookie_name];
    }

}



