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
    $url = "http://b2btrademarketing.com/index.php";
    $response = get($url, '', 1, 3);
    $cookie = get_cookie_str_for_html($response['res']);

    //step-1
    $url = "http://b2btrademarketing.com/index.php?action=signup_step2";
    $post_data = array(
        'country'=> 'CN',
        'email'=> $user[0]['reg_email'],
        'buyer_seller' => 2,
        'submit'=> 'Submit',
    );
    $response = post($url, $post_data, $cookie, 1, 3);

    //step-2
    $url = "http://b2btrademarketing.com/index.php?action=signup_step3";
    $code_url = "http://b2btrademarketing.com/inc/r_image.php";
    $post_data = array(
        'member_id'=> $user[0]['reg_account'], /*return account*/
        'selling_products'=> 'many product',
        'verification_code'=> '',
        'password'=> $user[0]['reg_password'],
        'password_confirm'=> $user[0]['reg_password'],
        'title'=> 'Mr.',
        'first_name'=> $user[0]['contact_name_first'],
        'last_name'=> $user[0]['contact_name'],
        'industry'=> 2,
        'subscribe'=> 'yes',
        'agreement'=> 'yes',
    );

    do {
        $response = get($code_url, $cookie);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['verification_code'] = get_code("$SERVER/util/code/", "b2btrademarketing");
        $response = post($url, $post_data, $cookie, 1, 3);
        if(preg_match('/alert\(\'(.*)\'\);history\.go\(-1\);/', $response['res'], $match)) {
            if (preg_match('/Your verification/', $match[1])) {
            } else {
                json_write(array('ok' => 0, 'msg' => $match[1]), dirname(__FILE__));
                return;
            }
        } else {
            break;
        }
    } while(1);

    //step-3
    $url = "http://b2btrademarketing.com/index.php?action=signup_finish";
    $post_data = array(
        'jobs_title'=> 1,
        'phone'=> 86,
        'phone1'=> $user[0]['pre_contact_phone'],
        'phone2'=> $user[0]['contact_phone'],
        'fax'=> '86',
        'fax1'=> $user[0]['pre_contact_fax'],
        'fax2'=> $user[0]['contact_fax'],
        'mobile'=> '',
        'mobile2'=> '',
        'company_name'=> $user[0]['company_en_name'],
        'street'=> $user[0]['company_address'],
        'city'=> 'jiaxing',
        'state'=> 'zhejiang',
        'zip_code'=> $user[0]['zip'],
        'skype_number'=> '',
        'icq_number'=> '',
        'msn_number'=> '',
        'contact_email'=> '',
        'post_company_profile'=> 'yes',
        'language'=> 'en',
        'hear_about'=> '',
        'submit'=> 'Finish',
    );
    $response = post($url, $post_data, $cookie, 1, 3);
    if(preg_match('/Successfully/', $response['res'], $match)) {
        json_write(array('ok' => 1, 'msg' => '注册成功'), dirname(__FILE__));
    }


}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
}
