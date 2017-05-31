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
require_once ('getAttr.php');

function register() {
    $db = new DB();
    $user = $db->query('user', "id=1");
    //注册页面
    $url = "http://www.eb80.com/login/region.aspx";

    $arr = get_attr($url);

    $post_data = array(
        'ctl00$ContentPlaceHolder1$txtUserName'=>$user[0]['reg_account'],
        'ctl00$ContentPlaceHolder1$txtCompany'=>$user[0]['company_en_name'],
        'ctl00$ContentPlaceHolder1$txtAddress'=>$user[0]['company_address'],
        'ctl00$ContentPlaceHolder1$txtMainProduct'=>'maaaaaaaaaaaaaaaaain products',
        'ctl00$ContentPlaceHolder1$txtIntroduction'=>'gooooooooooooooooooooooooooooooooooooooooooooood company',
        '__VIEWSTATE' => $arr['view'],
        '__EVENTVALIDATION'=> $arr['event'],
        'ctl00$ContentPlaceHolder1$txtLastName'=>$user[0]['contact_name'],
        'ctl00$ContentPlaceHolder1$txtFirstName'=>$user[0]['contact_name_first'],
        'ctl00$ContentPlaceHolder1$txtPwd'=>$user[0]['reg_password'],
        'ctl00$ContentPlaceHolder1$txtPassword'=>$user[0]['reg_password'],
        'ctl00$ContentPlaceHolder1$ddlCountry'=>'31',
        'ddlCategory'=>241,
        'ddlCategorySmall'=>244,
        'ctl00$ContentPlaceHolder1$Sex'=>'Mr',
        'ctl00$ContentPlaceHolder1$txtCountry'=>'86',
        'ctl00$ContentPlaceHolder1$txtArea'=>$user[0]['pre_contact_phone'],
        'ctl00$ContentPlaceHolder1$txtPhoneNumber'=>$user[0]['contact_phone'],
        'ctl00$ContentPlaceHolder1$txtEmail'=>$user[0]['email'],
        'ctl00$ContentPlaceHolder1$txtMSN'=>$user[0]['email'],
        'ctl00$ContentPlaceHolder1$btnSubmit'=>'Create My Account',

    );

    $response = post($url, $post_data, '', 0, 3);
    preg_match('/<script>alert\(\'(.*)\'\);/', $response['res'], $match);
    if($match)
        json_write(array('ok'=>0, 'msg'=>$match[1]), dirname(__FILE__));
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
    case 'code':
        get_code();
        break;
}
