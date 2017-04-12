<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/14
 * Time: 下午4:04
 */

function login_asiamachinery($web) {
    global $SERVER;
    $ext_cookie = '';
    $login_cookie_name = ["SupID", "SupInvoiceno", "SupName", "SupPwd", "vip"];
    $url = "https://www.asiamachinery.net/login.asp";
    $code_url = "https://www.asiamachinery.net/inc/validcode.asp";
    $post_data = array(
        'ID'=> $web['account'],
        'PWD'=> $web['password'],
        'validcode'=> ''
    );

    $response = get($code_url, '', 1, 3);
    $cookie = get_cookie_str_for_html($response['res']);

    do {
        $response = get($code_url, $cookie);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['validcode'] = get_code("$SERVER/util/code/", "asiamachinery");
        $response = post($url, $post_data, $cookie.$ext_cookie, 1, 3);
        if(preg_match('/alert\("Login ID error!"\)/',$response['res'])) {
            return [0, "账号错误"];
        } else if (preg_match('/alert\("Password error!"\)/',$response['res'])) {
            return [0, "密码错误"];
        } else if(preg_match('/location.replace(.*)/',$response['res'])){
            set_cookies_for_html($response['res'], $login_cookie_name);
            return [1, $login_cookie_name];
        } else if(preg_match('/alert\(\'Verification Code error!/',$response['res'])) {
            $code_fail = 1;
        } else {
            return [0, '连接超时'];
        }
    } while($code_fail);


}



