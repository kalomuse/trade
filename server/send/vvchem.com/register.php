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
    $url = "http://www.vvchem.com/user.do?action=reg";

    $post_data = array(
        'country'=>'China',
        'businessType'=>'sell',
        'firstName'=>$user[0]['contact_name_first'],
        'lastName'=>$user[0]['contact_name'],
        'sex'=>1,
        'companyName'=>$user[0]['company_en_name'],
        'p1'=>'86',
        'p2'=>$user[0]['pre_contact_phone'],
        'p3'=>$user[0]['contact_phone'],
        'email'=>$user[0]['reg_email'],
        'password'=>$user[0]['reg_password'],
        'rePassword'=>$user[0]['reg_password'],
        'x'=>50,
        'y'=>18,
        'regType'=>'',
        'key'=>'',

    );

    $response = post($url, $post_data, '', 0, 3);
    if(preg_match('/<li><strong>(.*)<a/', $response['res'], $match)) {
        json_write(array('ok'=>0, 'msg'=>$match[1]));
    } else if(preg_match('/The URL has moved/', $response['res'])){
        json_write(array('ok'=>1, 'msg'=>'注册成功'));
    } else {
        json_write(array('ok'=>0, 'msg'=>'未知的错误'));
    }
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
