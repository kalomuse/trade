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
    $url = "http://en.asiadcp.com/signup.php?action=1";

    $post_data = array(
        'loginname'=> $user[0]['reg_account'],
        'email'=> $user[0]['reg_email'],
        'step'=> 1,
    );

    $response = post($url, $post_data, '', 1, 3);
    if(preg_match('/Verify that the information has been sent to your mailbox/', $response['res']))
        json_write(array('ok'=>0, 'msg'=>' 邮件已发送至您的邮箱，请注意查收'));
    else if(preg_match('/Your e-mail address seemd wrong/', $response['res'])){
        json_write(array('ok'=>0, 'msg'=>'用户名或者邮箱已注册'));
    } else {
        json_write(array('ok'=>0, 'msg'=>'注册失败'));
    }
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
