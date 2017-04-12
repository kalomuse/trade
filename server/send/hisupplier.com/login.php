<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_hisupplier($web) {
    $ext_cookie = '';
    $login_cookie_name = ["hs_cas_email", "hs_cas_ticket_en", "JSESSIONID"];
    $url = "http://my.hisupplier.com/login?return=http%3A%2F%2Faccount.hisupplier.com%2F";
    $post_data = array(
        'email'=> $web['account'],
        'password'=>$web['password'],

        'from_site'=> '',
        'user_name'=> '',
        'validateCode'=>'noCode',
        'return'=>'http://www.hisupplier.com',
        'mode'=>''
    );

    $response = post($url, $post_data, $ext_cookie, 1);
    set_cookies_for_html($response['res'], $login_cookie_name);
    //get jsession
    unset($_COOKIE['JSESSIONID']);
    $response = get( "http://account.hisupplier.com/?ticket=".$_COOKIE['hs_cas_ticket_en'], get_cookie_str_for_arr($login_cookie_name, $ext_cookie), 1);
    if(preg_match('/login\?/', $response['res']))
        return [0, '账号或密码错误'];
    else {
        set_cookies_for_html($response['res'], $login_cookie_name);
        return [1, $login_cookie_name];
    }

}



