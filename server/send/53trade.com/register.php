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
    $url = "http://53trade.com/membercenter/adduser.asp";

    $post_data = array(
        'user_name'=> $user[0]['reg_account'],
        'companycity'=> 'Jiaxing',
        'companyprovince'=> 'Zhejiang',
        'user_pass'=> $user[0]['reg_password'],
        'user_pass2'=> $user[0]['reg_password'],
        'c_mail'=> $user[0]['reg_email'],
        'mytypes' => 2,
        'sex' => 1,
        'fname'=> $user[0]['contact_name'].' '.$user[0]['contact_name_first'],
        'mypower'=> 3,
        'p_c_code'=> 86,
        'p_a_code'=> $user[0]['pre_contact_phone'],
        'p_n_code'=> $user[0]['contact_phone'],
        'f_c_code'=> 86,
        'f_a_code'=> $user[0]['pre_contact_fax'],
        'f_n_code'=> $user[0]['contact_fax'],
        'countryid'=> 324,
        'mypost'=> $user[0]['zip'],
        'companyadd'=> $user[0]['company_address'],
        'companyname'=> $user[0]['company_en_name'],
        'btypes'=> 2,
        'oneid'=> 3,
        'c_website'=> 'http://',
        'regfrom'=> 0,
    );

    $response = post($url, $post_data, '', 1, 3);
    preg_match('/alert\(\'(.*)\'\);/', $response['res'], $match);
    if($match)
        json_write(array('ok'=>0, 'msg'=>$match[1]));
    else {
        json_write(array('ok'=>0, 'msg'=>'注册成功'));
    }
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
