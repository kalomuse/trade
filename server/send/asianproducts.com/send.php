<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');

function send_asianproducts($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://member.asianproducts.com/member/?op=product&action=add_new_v2&item_id=';

    //登录操作
    $login_cookie_names = login_asianproducts($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    //上传操作
    $img_path = upload_asianproducts($PATH . $product['img'], $login_cookie_str);
    if(!$img_path[0])
        return $img_path[1];

    $key = explode(' ', $product['name']);
    $post_data = array(
        'itemName'=> $product['name'],
        'itemNo'=> '123456',
        'feature'=> $product['description'],
        'pwk1'=> $key[0],
        'pwk2'=>$key[1],
        'pwk3'=> $key[2],
        'pwk4'=> $key[3],
        'pwk5'=> '',
        'category'=> 'A9448242540188',
        'do'=> 'savedata',
    );


    $url .= $img_path[3];
    //推送操作
    $response = post($url, $post_data, $login_cookie_str);

    $save_img_url = "http://images.asianproducts.com/upload_product_image.php?act=savePdtImage&item_id=$img_path[3]&s=1";
    $response = get($save_img_url, $login_cookie_str, 0, 3);
    $post_data = array(
        'do'=>saveOffline,
        'replaceImg'=>1,
        'simple'=>1,
    );
    $response = post($url, $post_data, $login_cookie_str);
    if (!$response['res']) {
        return '连接超时';
    }
    if($response['res'] == '1')
        return 'success';
    else
        return '发送失败';
}
