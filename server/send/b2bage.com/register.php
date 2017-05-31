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
require_once ("$SERVER/util/code/test.php");
require_once ("$SERVER/conf/db.php");

function register() {
    global $SERVER;
    $db = new DB();
    $user = $db->query('user', "id=1");
    //init
    $url = "http://www.b2bage.com/register.do";
    $response = get($url, '', 1, 3);
    $cookie = get_cookie_str_for_html($response['res']);

    //step-1
    $url = "http://www.b2bage.com/register.do?act=step2";
    $post_data = array(
        'country'=> 44,
        'buyer_seller'=> 2,
        'subscribe'=> 'yes',
        'agreement'=> '1',
        'profile_id'=> '',
    );
    $response = post($url, $post_data, $cookie, 1, 3);

    //step-2
    $url = "http://www.b2bage.com/register.do?act=step2&do=act_register";
    $code_url = "http://www.b2bage.com/captcha.html";
    $post_data = array(
        "loginId"=> $user[0]['reg_account'],
        "password"=> $user[0]['reg_password'],
        "passwordConfirm"=> $user[0]['reg_password'],
        "title"=> 'Mr.',
        "firstName"=> $user[0]['contact_name_first'],
        "lastName"=> $user[0]['contact_name'],
        "company"=> $user[0]['company_en_name'],
        "categoryId"=> 1,
        "email"=> $user[0]['reg_email'],
        "phoneCountry"=> '86',
        "phoneArea"=>$user[0]['pre_contact_phone'],
        "phoneNumber"=> $user[0]['contact_phone'],
        "faxCountry"=> 86,
        "faxArea"=> $user[0]['pre_contact_fax'],
        "faxNumber"=> $user[0]['contact_fax'],
        "question"=> 1,
        "answer"=> 'hello dog',
        "captcha"=> '',
        "country"=> 44,
        "buyer_seller"=> 2,
        "subscribe"=> '',
    );

    do {
        $response = get($code_url, $cookie);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['captcha'] = get_code("$SERVER/util/code/", "b2bage");
        $response = post($url, $post_data, $cookie, 1, 3);
        if (preg_match('/<td align="left" style="color:#F00;">(.*)<\/td>/', $response['res'], $match)) {
            if($match == "Verification Code errors") {

            }
            else {
                json_write(array('ok' => 0, 'msg' => $match[1]), dirname(__FILE__));
                return;
            }
        } else if(preg_match('/You have successfully registered/', $response['res'], $match)) {
            json_write(array('ok' => 1, 'msg' => '注册成功'), dirname(__FILE__));
            return;
        } else {
            json_write(array('ok' => 0, 'msg' => '注册失败'), dirname(__FILE__));
            return;
        }
    } while(1);

}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
