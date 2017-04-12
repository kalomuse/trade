<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */

require_once ('login.php');

function send_53trade($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://53trade.com/memberCenter/myProductsAdd2.asp';

    //登录操作
    $login_cookie_names = login_53trade($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    $post_data = array(
        'groupid' => '90429',
        'catName' => $product['category'],
        'product_name' => $product['name'],
        'product_model' => $product['brief'],
        'product_place' => 'china',
        'companyid' => '626841',
        'oneid'=>'26',
        'twoid'=> '46',
        'vip_user'=> '0',
        'countryid'=>'324',
        'paixu'=>'12',
        'product_desc' => $product['description'],
        'Submit'=> 'Post New Product',
        'file2'=> new CURLFile($PATH . $product['img']),
        'Submit'=> 'Next',
    );

    //推送操作
    $response = post($url, $post_data, $login_cookie_str, 0, 3);
    preg_match('/<script language=javascript>alert\(\'(.*)\'\);/', $response['res'], $match);
    if (!$response['res']) {
        return '连接超时';
    }
    if($match)
        return $match[1];
    return 'success';
}
