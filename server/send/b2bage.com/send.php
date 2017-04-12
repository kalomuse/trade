<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');


function send_b2bage($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://www.b2bage.com/member_product.do?act=insert';

    //登录操作
    $login_cookie_names = login_b2bage($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    $key = explode(' ', $product['name']);
    $post_data = array(
        'product_img'=> new CURLFile($PATH . $product['img'], 'image/jpeg', 'aa.jpg'),
        'subject' => $product['name'],
        'modelno' => '',
        'keyword0'=> $key[0],
        'keyword1'=> $key[1],
        'keyword2'=> $key[2],
        'keyword3'=> $key[3],
        'keyword4'=> '',
        'key_cnt'=> 5,
        'sel_cats[]'=> '1397',
        'productgroup'=> '',
        'details_msg'=> $product['description'],

    );


    //推送操作
    $msg = upload_b2bage($url, $post_data, $login_cookie_str, 0, 3);
    return $msg;

}
