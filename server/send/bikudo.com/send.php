<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */

require_once ('login.php');
require_once ('upload.php');


function send_bikudo($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://www.bikudo.com/post_product.do';

    //登录操作
    $login_cookie_names = login_bikudo($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }


    $post_data = array(
        'sb_quantity'=> 0,
        'sb_location'=> 0,
        'sb_min_order'=> 0,
        'sb_price_cur_id'=> 0,
        'sb_price'=>0,
        'sb_samples_available'=>0,
        'sb_product_status'=>0,
        'sb_delivery_time'=>0,
        'sb_cash'=>'',
        'sb_cheque'=>'',
        'sb_credit'=>'',
        'sb_bank'=>'',
        'sb_loc'=>'',
        'sb_escrow'=>'',
        'sb_other_mode'=>'0',
        'sb_shipping_cost'=>0,
        'sb_title'=>$product['name'],
        'sb_keywords'=> $product['brief'],
        'category'=> $product['category'],
        'cid'=>'141;857',
        'sb_description'=> $product['description'],
        //remLen2:35
        'submit'=>'Submit'
    );

    //推送操作
    $response = post($url, $post_data, $login_cookie_str);
    preg_match('/<font color="\#ff3300"><b>\* (.*)<\/b>/', $response['res'], $match);
    if($match) {
        return $match[1];
    }

    //上传操作
    return upload_bikudo($PATH . $product['img'], $login_cookie_str);

}
