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

    $url = "https://www.asiamachinery.net/supplier_regresult.asp";
    $code_url = "https://www.asiamachinery.net/inc/validcode.asp";

    $response = get($code_url, '', 1, 3);
    $cookie = get_cookie_str_for_html($response['res']);
    $post_data = array(
        'SID' => $user[0]['reg_account'],
        'eSupName' => $user[0]['company_name'],
        'SupCountry' => 'CN',
        'eSupAddress' => $user[0]['company_address'],
        'SupTel1_1' => '86',
        'SupTel1_2' => $user[0]['pre_contact_phone'],
        'SupTel1_3' => $user[0]['contact_phone'],
        'SupEmail' => $user[0]['reg_email'],
        'SupUrl' => '',
        'SupContact1' => 'nice',
        'SupContact2' => '',
        'SupType' => 5,
        'Category' => '24',
        'eSupProduct' => 'many products',
        'validcode' => '',
        'Submit' => 'Submit',
        'cat' => '',
    );

    do {
        $response = get($code_url, $cookie);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['validcode'] = get_code("$SERVER/util/code/", "asiamachinery");
        $response = post($url, $post_data, $cookie, 1, 3);
        if (preg_match('/alert\(\'(.*)\!\'\);history\.back/', $response['res'], $match)) {
            if($match && $match[1] == "Verification Code Error") {

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
