<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ("../../../path.php");
require_once ("$SERVER/util/cookie.php");
require_once ("$SERVER/util/Request.php");
require_once ("$SERVER/conf/db.php");

function register() {
    $db = new DB();
    $user = $db->query('user', "id=1");
    //注册页面
    $url = "http://tradedeals.biz/auth/reg";

    $post_data = array(
        'first_name'=> $user[0]['contact_name_first'],
        'last_name'=> $user[0]['contact_name'],
        'email'=> $user[0]['reg_email'],
        'password'=> $user[0]['reg_password'],
        'password_confirm'=> $user[0]['reg_password'],
        'company'=> $user[0]['company_en_name'],
        'phone'=> '86'.$user[0]['pre_contact_phone'].$user[0]['contact_phone'],
        'city'=> $user[0]['city'],
        'location'=> $user[0]['company_address'],
        'country'=> 309,
        'category'=> 5,
        'subcategory'=> 91,
        'submit'=> 'CREATE FREE ACCOUNT',
    );

    $response = post($url, $post_data, '', 0, 3);
    if(!$response['res']) {
        json_write(array('ok'=>0, 'msg'=>'注册成功'), dirname(__FILE__));
    } else {
        json_write(array('ok'=>0, 'msg'=>'请确保账号未注册，密码大于等于8位'), dirname(__FILE__));
    }
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
