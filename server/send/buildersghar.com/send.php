<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');


function send_buildersghar($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $db = new DB();
    $user = $db->query('user', "id=1");

    //登录操作
    $login_cookie_names = login_buildersghar($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    $url = 'http://buildersghar.com/post-free-ads';
    $response = get($url, '', 1);
    preg_match('/<input type=\'hidden\' name=\'CSRFName\' value=\'(.*)\' \/>/', $response['res'], $match);
    $CSRFName = $match[1];
    preg_match('/<input type=\'hidden\' name=\'CSRFToken\' value=\'(.*)\' \/>/', $response['res'], $match);
    $CSRFToken = $match[1];

    $url = 'http://buildersghar.com/index.php';
    $post_data = array(
        'CSRFName'=> $CSRFName,
        'CSRFToken'=> $CSRFToken,
        'action'=> 'item_add_post',
        'page'=> 'item',
        'parentCatId'=> '96',
        'catId'=> '99',
        'title[en_US]'=> $product['name'],
        'description[en_US'=> 'test aaa',
        'price'=> $product['price']? $product['price']: 0,
        'currency'=> 'USD',
        /*'qqfile'=> new CURLFile($PATH . $product['img']),*/
        /*'city' => 'Shanghai',
        'address' => $user[0]['company_address'],*/
        'contactName' => $user[0]['contact_name'].$user[0]['contact_name_first'],
        'contactEmail' => $user[0]['email'],
        'qqfile'=> '',
        'countryId'=> '',
        'region'=> '',
        'regionId'=> '',
        'city'=> '',
        'cityId'=> '',
        'cityArea'=> '',
        'cityAreaId'=> '',
        'address'=> '',
        'meta[1]'=> '',
        'meta[2]'=> '',
        's_youtube'=> '',
    );

    //推送操作
    $response = upload($url, $post_data, $login_cookie_str, 1);
    preg_match('/index/', $response['res'], $match);
    if ($match)
        return '发送失败';
    else
        return 'success';
}
