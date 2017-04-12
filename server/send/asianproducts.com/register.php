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

function register() {
    global  $SERVER;
    $db = new DB();
    $user = $db->query('user', "id=1");
    //注册页面step-1
    $url = "https://member.asianproducts.com/register.php";
    $code_url = "https://member.asianproducts.com/show_securecode.php";

    $response = get($url, '', 1 , 3);
    set_cookies_for_html($response['res'], ['PHPSESSID']);
    $cookie = get_cookie_str_for_arr(['PHPSESSID']);
    $post_data = array(
        'username'=>$user[0]['reg_account'],
        'email'=>$user[0]['reg_email'],
        'password'=>$user[0]['reg_password'],
        'cfmpassword'=>$user[0]['reg_password'],
        'scode'=>'',
        'step'=>'saveAccount',
    );

    do {
        $response = get($code_url, $cookie);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['scode'] = get_code("$SERVER/util/code/", "asianproducts");
        $response = post($url, $post_data, $cookie, 1, 3);
        if(preg_match('/php\?error=(.*)/', $response['res'], $match)) {
            if(preg_match('/code/', $match[1])) {

            } else {
                break;
            }

        } else {
            break;
        }
    } while(1);

    $url = "https://member.asianproducts.com/register.php?step=fillCompanyInfo";
    $response = get($url, $cookie, 0 , 3);
    preg_match('/<input type="hidden" name="user_id" value=\"([a-zA-Z0-9]*)\">/', $response['res'], $match);
    if(!$match)
        json_write(array('ok'=>0, 'msg'=>"注册失败"));
    $post_data = array(
        'email'=> $user[0]['reg_email'],
        'companyname'=> $user[0]['company_name'],
        'country'=> '1420-86',
        'address'=> $user[0]['company_address'],
        'city'=> $user[0]['city'],
        'state'=> '',
        'zipCode'=> $user[0]['zip'],
        'tel_cou'=> '86',
        'tel_area'=> $user[0]['pre_contact_phone'],
        'tel_num'=> $user[0]['contact_phone'],
        'fax_cou'=> '86',
        'fax_area'=> $user[0]['contact_fax'],
        'fax_num'=> $user[0]['pre_contact_fax'],
        'business_type'=> '0',
        'establish'=> '',
        'employee'=> '',
        'capital'=> '50',
        'turnover'=> '50',
        'companyProfile'=> '',
        'url'=> 'http://',
        'step'=> 'saveCompany',
        'user_id'=> $match[1],
    );
    $response = post($url, $post_data, $cookie, 1, 3);
    if($response['res'] == 'Register - Get failure on Step 2')
        json_write(array('ok'=>0, 'msg'=>$response['res']));
    else if(preg_match('/step=checkMail/', $response['res'])){
        json_write(array('ok'=>1, 'msg'=>'请查收邮件激活'));
    } else {
        json_write(array('ok'=>0, 'msg'=>"注册失败"));
    }
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
