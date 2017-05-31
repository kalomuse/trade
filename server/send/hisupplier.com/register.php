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

function get_code() {
    $url = "http://account.cn.hisupplier.com/validateCode/getImage?hi_vc_key=1490000012246.866";
    $res = get($url, '', 1, 3);
    $cookie = ["JSESSIONID"];
    set_cookies_for_html($res['res'], $cookie);
    $cookie = get_cookie_str_for_arr($cookie);

    $res = get($url, $cookie, 0, 3);
    file_put_contents("yy.png", $res);
    $res = imagecreatefrompng('yy.png');

    Header('Content-type:image/png; charset=UTF-8');
    imagepng($res);
    return true;
}
function register() {
    global $PATH;
    $db = new DB();
    $user = $db->query('user', "id=1");

    //上传营业执照
    $url = "http://account.cn.hisupplier.com/upload/tmp_image_upload.do";
    $post_data = array(
        'file' => new CURLFile($PATH.$user[0]['company_number_img']),
        'name' => 'aa.jpg',
    );
    $response = upload($url, $post_data, '', 0, 3);
    $res = json_decode($response['res']);
    $img_path = $res->imgPath;

    //注册页面
    $url = "http://account.cn.hisupplier.com/user/join_submit.htm";
    $post_data = array(
        'email'=> $user[0]['reg_email'],
        'memberId'=> $user[0]['reg_account'],
        'passwd'=> $user[0]['reg_password'],
        'confirmPasswd'=> $user[0]['reg_password'],
        'comName'=> $user[0]['company_name'],
        'contact'=> $user[0]['contact_name'].$user[0]['contact_name_first'],
        'tel1'=> $user[0]['pre_contact_phone'],
        'tel2'=> $user[0]['contact_phone'],
        'sex'=>'1',
        'validateCodeKey'=>'1490000012246.866',
        'validateCode'=> $_GET['code'],

        'countryCode'=>'103105102103',
        'province'=> '103105',
        'city'=>'103105102',
        'town'=>'103105102103',

        'regImgType'=> 1,
        'companyRegImgPath'=> $img_path,
        'regNo'=> '',
        'ceo'=> '',
        'personRegImgPath1'=> '',
        'personRegImgPath2'=> '',
        'regToken'=> '',
        'submit'=> '提交注册',
    );
    $cookie = ["JSESSIONID"];
    $cookie = get_cookie_str_for_arr($cookie);
    $response = post($url, $post_data, $cookie, 0, 3);
    preg_match('/<ul class="errorMessage">(.*)<li><span>(.*)<\/span><\/li>/s', $response['res'], $match);
    if($match)
        json_write(array('ok'=>0, 'msg'=>$match[2]), dirname(__FILE__));
    else {
        json_write(array('ok'=>1, 'msg'=>'注册完成，请等待审核'), dirname(__FILE__));
    }
}


switch ($_GET['action']) {
    case 'index':
        register();
        break;
    case 'code':
        get_code();
        break;
}

