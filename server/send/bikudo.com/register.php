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
    $url = "http://www.bikudo.com/register";

    $post_data = array(
        'eposta'=> $user[0]['reg_email'],
        'il'=> 'Jiaxing',
        'bolge'=> 'Zhejiang',
        'ad'=> $user[0]['contact_name_first'],
        'soyad'=> $user[0]['contact_name'],
        'sirket'=> $user[0]['company_en_name'],
        'adres'=> $user[0]['company_address'],
        'pk'=> $user[0]['zip'],
        'konum'=> 44,
        'tel_kod_ulke'=> '86',
        'tel_kod_alan'=> $user[0]['pre_contact_phone'],
        'tel_nu'=> $user[0]['contact_phone'],
        'sifre'=> $user[0]['reg_password'],
        'sifre_denetim'=> $user[0]['reg_password'],
        'hesap_olustur'=>'Create My Account',
    );

    $response = post($url, $post_data, '', 0, 3);
    preg_match('/<font color="\#f01010">(.*)<\/font>/', $response['res'], $match);
    if($match)
        json_write(array('ok'=>0, 'msg'=>$match[1]), dirname(__FILE__));
    else {
        json_write(array('ok'=>0, 'msg'=>'注册成功'), dirname(__FILE__));
    }
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
