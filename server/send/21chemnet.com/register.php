<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ("../../../path.php");
require_once ("$SERVER/util/code/test.php");
require_once ("$SERVER/util/cookie.php");
require_once ("$SERVER/util/Request.php");
require_once ("$SERVER/conf/db.php");

function register()
{
    global $SERVER;
    $db = new DB();
    $user = $db->query('user', "id=1");

    $url = "http://www.21chemnet.com/reg.html";
    $code_url = "http://www.21chemnet.com/Inc/VerifyCode.asp";

    $response = get($url, '', 1, 3);
    $cookie = get_cookie_str_for_html($response['res']);

    $url = "http://www.21chemnet.com/regSave.asp?Flag=";
    $post_data = array(
        'Email'=> $user[0]['reg_email'],
        'CodeShown'=> '',
        'Country'=> 240,
        'Password'=> $user[0]['password'],
        'RePassword'=> $user[0]['password'],
        'Name'=> $user[0]['contact_name'].' '.$user[0]['contact_name_first'],
        'sex'=>'Mr.',
        'CompanyName'=>$user[0]['company_name'],
        'Url'=> $user[0]['reg_account'],
        'PhoneNumber'=> "86-".$user[0]['pre_contact_phone']."-".$user[0]['contact_phone'],
        'Address'=> $user[0]['company_address'],
        'City'=> $user[0]['city'],
        'Province'=> $user[0]['province'],
        'Zip'=> $user[0]['zip'],
        'Fax'=> "86-".$user[0]['pre_contact_fax']."-".$user[0]['contact_fax'],
        'Mobile'=> '',
        'QQ'=> '',
        'MSN'=> '',
        'WebSite'=> '',
        'BusinessType' => '0',
    );

    do {
        $response = get($code_url, $cookie);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['CodeShown'] = get_code("$SERVER/util/code/", "21chemnet");
        //$post_data['validcode'] = '11111';
        $response = post($url, $post_data, $cookie, 1, 3);
        if (preg_match('/alert\("(.*)\!\"\)/', $response['res'], $match)) {
            if($match && $match[1] == "Verification code input error") {

            } else {
                json_write(array('ok'=>0, 'msg'=>$match[1]), dirname(__FILE__));
                return true;
            }
        } else if(preg_match('/alert\(\'(.*)\'\)/', $response['res'], $match)){
            json_write(array('ok'=>1, 'msg'=>$match[1]), dirname(__FILE__));
            return true;
        } else {
            json_write(array('ok'=>0, 'msg'=>"注册失败"), dirname(__FILE__));
            return true;
        }
    } while (1);


}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
