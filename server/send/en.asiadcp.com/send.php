<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');


function send_en_asiadcp($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://en.asiadcp.com/member/product.php?action=1';

    //登录操作
    $login_cookie_names = login_en_asiadcp($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    //上传操作
    $img_path = upload_en_asiadcp($PATH . $product['img'], $login_cookie_str);
    if(!$img_path)
        return '图片上传失败';

    $post_data = array(
        'mycate' => '20472',
        'catName' => $product['category'],
        'proname' => $product['name'],
        'keywords' => $product['brief'],
        'description' => $product['description'],
        'parentcate'=>4,
        'subcate'=>109,
        'origin'=>'China',
        'propic'=>$img_path,
        'currency'=>'USD',
        //'price'=>'3000',
        'terms'=>'FOB',
        'method'=>'edit',
        'submit'=>'post',
    );



    //推送操作
    $response = post($url, $post_data, $login_cookie_str);
    preg_match('/<p>Products have been added! about to jump page<\/p>/', $response['res'], $match);
    if (!$response['res']) {
        return '连接超时';
    }
    if($match)
        return 'success';
    else
        return '发送失败';
}
