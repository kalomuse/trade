<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_eb80($web) {
    $ext_cookie = '';
    $login_cookie_name = ["oldeb80english"];
    $url = "http://www.eb80.com/login/login.aspx";
    $arr = get_attr($url);
    $post_data = array(
        '__VIEWSTATE' => $arr['view'],
        '__EVENTVALIDATION'=> $arr['event'],
        'ctl00$ContentPlaceHolder1$txtUserName'=> $web['account'],
        'ctl00$ContentPlaceHolder1$txtPwd'=>$web['password'],
        'ctl00$ContentPlaceHolder1$submit' => 'Sign In'
    );

    $response = post($url, $post_data, $ext_cookie, 1);
    if(!$response['err']) {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return $login_cookie_name;
    } else {
        return false;
    }
}

