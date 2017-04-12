<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */
function login_bikudo($web) {
    $ext_cookie = '';
    $login_cookie_name = ["PHPSESSID", "b2b_blead_user", "b2b_blead_user"];
    $url = "http://www.bikudo.com/login.do";
    $post_data = array(
        'username'=> $web['account'],
        'pwd'=> $web['password'],
        'sb_type'=> 0,
        'id'=> 0,
        'return_path'=> '',
        'submit'=> 'Sign In',
        'remember_user'=> 1
    );


    $response = get($url, $ext_cookie, 1, 3);
    set_cookies_for_html($response['res'], $login_cookie_name);
    $response = post($url, $post_data, $ext_cookie, 1, 3);
    if(preg_match('/302 Found/',$response['res'])) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    } else {
        return [0, "用户名或密码错误"];
    }
}



