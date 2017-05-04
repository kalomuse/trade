<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/15
 * Time: 上午10:15
 */

function str_set_cookie($ext_cookie) {
    foreach(explode(';', $ext_cookie) as $value) {
        $arr = explode('=', $value);
        $_COOKIE[$arr[0]] = $arr[1];
        setcookie($arr[0], $arr[1]);
    }
}

function set_cookies_for_html($html, $cookie_name) {
    preg_match_all('/Set-Cookie:(.*);/iU', $html, $str);
    foreach ($str[1] as $value) {
        $tmp_val = explode('=', $value, 2);
        if (in_array(trim($tmp_val[0]), $cookie_name)) {
            setcookie(trim($tmp_val[0]), trim($tmp_val[1]));
            $_COOKIE[trim($tmp_val[0])] = trim($tmp_val[1]);
        }
    }
}
function get_cookie_str_for_html($html) {
    preg_match_all('/Set-Cookie:(.*);/iU', $html, $str);
    $tmp = '';
    foreach ($str[1] as $value) {
        $tmp .= trim($value).';';
    }
    return $tmp;
}

function get_cookie_str_for_arr($login_cookie_names, $extra_cookie='') {
    $login_cookie_str = '';
    foreach ($login_cookie_names as $cookie_name) {
        if($_COOKIE[$cookie_name])
            $login_cookie_str .= "$cookie_name=$_COOKIE[$cookie_name];";
    }
    $login_cookie_str .= $extra_cookie;
    return $login_cookie_str;
}