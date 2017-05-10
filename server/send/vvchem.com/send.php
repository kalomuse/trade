<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');

function send_vvchem($web, $product) {
    global $PATH;
    $extra_cookie = "";

    //登录操作
    $login_cookie_names = login_vvchem($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    $url = 'http://www.vvchem.com/product.do?action=postProduct';
    $post_data = array(
        'cas'=> '',
        'productTitle'=>  $product['name'],
        'category'=> 'Building Coating',
        'purity'=> '',
        'minQuantity'=> '',
        'priceUnit'=> '',
        'minPrice'=> '',
        'maxPrice'=> '',
        'unit'=> '',
        'img'=> '',
        'expiryDate'=> 0,
        'detailed'=>$product['description'],
        'sample'=>0,
        'url'=>'/user/product/postProduct.jsp?sucess=1',
        'pid'=>0,
        'btSubmit'=>'Submit',
    );

    //推送操作
    $response = post($url, $post_data, $login_cookie_str, 1);
    preg_match('/sucess=1/', $response['res'], $match);
    if ($match)
        return 'success';
    else
        return '发送失败';
}
