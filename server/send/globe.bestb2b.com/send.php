<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */

require_once ('login.php');
require_once ('upload.php');


function send_globe_bestb2b($web, $product) {
    /*global $PATH;
    $extra_cookie = "";
    $url = 'http://member.asianproducts.com/member/?op=product&action=add_new_v2&item_id=';

    //登录操作
    $login_cookie_names = login_globe_bestb2b($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    //上传操作
    $img_path = upload_globe_bestb2b($PATH . $product['img'], $login_cookie_str);
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


    $url .= $img_path[3];*/
    global $PATH, $SERVER;
    $extra_cookie = "";

    $url = 'http://www.aunetads.com/post/post-free-ads.php';
    $response = get($url, '', 0, 3);
    preg_match('/free-ads-rand_num_image.php\?vcid=(\d*)/', $response['res'], $match);

    $url = "http://www.aunetads.com/post/post-free-ads-op.php";
    $post_data = array(
        "adTitle" => $product['name'],
        "adDescription" => $product['description'],
        "adimage" => new CURLFile($PATH . $product['img']),
        "category" => 9205,
        "targetCity" => '',
        "targetState" => '',
        "ownerName" => 'Micky',
        "contactPhone" => '',
        "contactEmail" => '',
        "adPasscode" => 'Qu999999jm',
        "vcid" => $match[1],
        "validationCode" => '',
    );
    $code_url = "http://www.aunetads.com/post/free-ads-rand_num_image.php?vcid=" . $match[1];

    do {
        $response = get($code_url);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['validationCode'] = get_code("$SERVER/util/code/", "aunetads");
        $response = upload($url, $post_data, '', 1, 3);
        preg_match('/<ul class="ssListErrMsg"><li>(.*)<\/ul>/s', $response['res'], $match);
        if($match) {
            if(preg_match('/validation code/', $match[1])) {

            } else {
                return $match[1];
            }
        } else {
            return 'success';
        }
    } while(1);
}
