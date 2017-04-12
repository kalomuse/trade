<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */

require_once ('login.php');

function send_21chemnet($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://www.21chemnet.com/member/SaveOneByOnePostSellingLeads.asp';

    //登录操作
    $login_cookie_names = login_21chemnet($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    $key = explode(' ', $product['name']);
    $post_data = array(
        'CASNO'=> '50-00-3',
        'ProductName'=> $product['name'],
        'Synonyms1'=> $key[0],
        'Synonyms2'=> $key[1],
        'Synonyms3'=> $key[2],
        'usage'=> '',
        'detail'=> $product['description'],
    );

    //推送操作
    $response = post($url, $post_data, $login_cookie_str, 0, 3);
    if (!$response['res']) {
        return '连接超时';
    }

    if(preg_match('/have posted/', $response['res']))
        return 'You have posted this products!';

    if(preg_match('/Products sent successfully/', $response['res']))
        return 'success';
    else
        return '发送失败';
}
