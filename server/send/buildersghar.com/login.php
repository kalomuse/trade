<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_buildersghar($web) {
    $url = "http://buildersghar.com/user/login";
    $response = get($url, '', 1);
    $cookie = get_cookie_str_for_html($response['res']);
    str_set_cookie($cookie);
    preg_match('/<input type=\'hidden\' name=\'CSRFName\' value=\'(.*)\' \/>/', $response['res'], $match);
    $CSRFName = $match[1];
    preg_match('/<input type=\'hidden\' name=\'CSRFToken\' value=\'(.*)\' \/>/', $response['res'], $match);
    $CSRFToken = $match[1];

    $ext_cookie = '';
    $login_cookie_name = ["osclass"];
    $url = "http://buildersghar.com/index.php";
    $post_data = array(
        'email'=> $web['account'],
        'password'=> $web['password'],
        'action'=>'login_post',
        'page'=>'login',
        'CSRFName'=> $CSRFName,
        'CSRFToken'=> $CSRFToken,
    );

    $response = post($url, $post_data, $cookie, 1);
    if(preg_match('/dashboard/', $response['res']))
        return [1, $login_cookie_name];
    else {
        return [0, '账号或密码错误'];
    }

}



