<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_21chemnet($web) {
    global $SERVER;
    $ext_cookie = '';
    $url = "http://www.21chemnet.com/checkLogin.asp";
    $code_url = "http://www.21chemnet.com/Inc/VerifyCode.asp";
    $post_data = array(
        'Email'=> $web['account'],
        'PassWord'=> $web['password'],
        'Code'=> '',
        'x'=>'99',
        'y'=>'3'
    );

    $response = get($code_url, '', 1, 3);
    $cookie = get_cookie_str_for_html($response['res']);
    $tmp_val = explode('=', $cookie, 2);
    $login_cookie_name = [trim($tmp_val[0])];
    set_cookies_for_html($response['res'], $login_cookie_name);

    do {
        $response = get($code_url, $cookie);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['Code'] = get_code("$SERVER/util/code/", "21chemnet");
        $response = post($url, $post_data, $cookie.$ext_cookie, 1, 3);
        if(preg_match('/User name does not exist/',$response['res'])) {
            return [0, "账号错误"];
        } else if (preg_match('/Password Error/',$response['res'])) {
            return [0, "密码错误"];
        } else if(preg_match('/Verification code input error/',$response['res'])) {
            $code_fail = 1;
        } else if(preg_match('/\/member\/index.asp/',$response['res'])){
            //set_cookies_for_html($response['res'], $login_cookie_name);
            return [1, $login_cookie_name];
        } else {
            return [0, '连接超时'];
        }
    } while($code_fail);


}



