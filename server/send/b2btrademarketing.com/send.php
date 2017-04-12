<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');


function send_b2btrademarketing($web, $product) {
    global $PATH, $SERVER;
    $extra_cookie = "";
    $url = 'http://b2btrademarketing.com/add_new_product.php?action=save';
    $code_url = 'http://b2btrademarketing.com/inc/r_image.php';
    //登录操作
    $login_cookie_names = login_b2btrademarketing($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    //上传操作
    $img = upload_b2btrademarketing($PATH . $product['img'], $login_cookie_str);
    if(!$img[0])
        return $img[1];

    $text = explode("\n", $product['description']);
    $description = "";
    foreach($text as $t) {
        $description .= "<p>$t</p>";
    }
    $post_data = array(
        'product_id'=>'',
        'subject'=> $product['name'],
        'model_no'=> '123456',
        'keywords'=> $product['brief'],
        'del_cats'=> '',
        'product_group'=> '',
        'sel_cats[]'=>1213,
        'details'=> $description,
        'quantity'=> '100000',
        'location'=> 'China',
        'min_order'=> '1',
        'min_order_price'=> '0',
        'sample_available'=> 'no',
        'trade_alert'=> '1',
        'trade_alert_products'=> '',
        'verification_code'=> '',
        'submit'=> 'Post it now',
        /*sample_price:
        sample_shipping:
        sample_deleivery:
        sample_payment:
        payment_price_terms:
        delivery_lead_time:
        quality_safety_certifications:
        del_images:*/
    );
    do {
        $response = get($code_url, $login_cookie_str);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['verification_code'] = get_code("$SERVER/util/code/", "b2btrademarketing");
        $response = post($url, $post_data, $login_cookie_str, 1, 3);
        $response = get('http://b2btrademarketing.com/add_new_product.php?action=error', $login_cookie_str, 0, 3);

        if (preg_match('/error_typical/', $response['res'])) {
            if (preg_match('/1\. (.*)/', $response['res'], $match)) {
                if (preg_match('/verification code/', $match)) {

                } else {
                    return $match[1];
                }
            } else {
                return '发送失败';
            }
        } else if (!isset($response['res'])) {
            return '连接超时';
        } else {
            return 'success';
        }
    } while(1);
    return 'success';
}
