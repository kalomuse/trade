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
    $url = "http://buildersghar.com/user/register";
    $response = get($url, '', 1);
    $cookie = get_cookie_str_for_html($response['res']);
    str_set_cookie($cookie);
    preg_match('/<input type=\'hidden\' name=\'CSRFName\' value=\'(.*)\' \/>/', $response['res'], $match);
    $CSRFName = $match[1];
    preg_match('/<input type=\'hidden\' name=\'CSRFToken\' value=\'(.*)\' \/>/', $response['res'], $match);
    $CSRFToken = $match[1];

    $url = "http://buildersghar.com/index.php";
    $post_data = array(
        'CSRFName'=> $CSRFName,
        'CSRFToken'=> $CSRFToken,
        'page'=>'register',
        'action'=>'register_post',
        's_name'=>$user[0]['contact_name_first'].$user[0]['contact_name'],
        's_email'=>$user[0]['reg_email'],
        's_password'=>$user[0]['reg_password'],
        's_password2'=>$user[0]['reg_password'],
    );

    $response = post($url, $post_data, '', 1, 3);
    json_write(array('ok'=>1, 'msg'=>'注册成功'));
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
