<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');


function send_tradedeals($web, $product) {
    global $PATH;
    $extra_cookie = "";

    //登录操作
    $login_cookie_names = login_tradedeals($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    $url = 'http://tradedeals.biz/profile/submit_product';
    $post_data = array(
        'title'=> $product['name'],
        'category'=> 5,
        'subcategory'=> 91,
        'price'=> '0',
        'currency'=> 'USD',
        'userfile'=> '',
        'description'=> $product['description'],
        'userfile'=> new CURLFile($PATH . $product['img']),
    );

    //推送操作
    $response = upload($url, $post_data, $login_cookie_str, 1);
    preg_match('/products/', $response['res'], $match);
    if ($match)
        return 'success';
    else
        return '发送失败';
}
