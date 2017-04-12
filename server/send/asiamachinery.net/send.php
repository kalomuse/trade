<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */

require_once ('login.php');
require_once ('upload.php');


function send_asiamachinery($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'https://www.asiamachinery.net/admin/product_new_step2_result.asp';

    //登录操作
    $login_cookie_names = login_asiamachinery($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }


    $post_data = array(
        'Category' => '01-011-001',
        'catName' => $product['category'],
        'eProduct' => $product['name'],
        'eModel' => $product['brief'],
        'eContent' => $product['description'],
        //'eStandard'=>'<p>444444</p>',
        'Submit'=> 'Next'
    );



    //推送操作
    $response = post($url, $post_data, $login_cookie_str, 0, 3);
    preg_match('/New product succesffully added! please upload image/', $response['res'], $match);
    if (!$response['res']) {
        return '连接超时';
    }
    if(!$match)
        return '发送失败';
    else {
        preg_match('/ProID=(.*)"\)/', $response['res'], $match);
        $id =  $match[1];
        //上传操作
        $img = upload_asiamachinery($PATH . $product['img'], $id,$login_cookie_str);
        if(!$img[0])
            return $img[1];
    }
    return 'success';
}
