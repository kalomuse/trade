<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');


function send_eb80($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://www.eb80.com/Member/SellOffer.aspx';

    //登录操作
    $login_cookie_names = login_eb80($web);
    if ($login_cookie_names) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names, $extra_cookie);
    } else {
        return '登录失败';
    }

    //上传操作
    upload_eb80($PATH . $product['img'], $login_cookie_str);
    //获取图片list操作
    $post_data = array(
        'picpage'=>1,
        'picname'=>''
    );
    $response = post('http://www.eb80.com/Control/GetData.ashx', $post_data, $login_cookie_str);
    $img_list = json_decode($response['res']);
    $img_arr = explode('/', ($img_list->list)[0]->src);
    $img_str = explode('_', $img_arr[count($img_arr) - 1]);
    $keyword = explode(' ', $product['name']);


    $attr = get_attr($url, $login_cookie_str);
    $post_data = array(
        '__VIEWSTATE' => $attr['view'],
        '__EVENTVALIDATION'=> $attr['event'],
        'txtSubject' => $product['name'],         //名字
        'txtKOne'=> $keyword[0],
        'txtKTwo'=> $keyword[1],
        'txtKThree'=> $keyword[2],
        'txtDetails'=> $product['description'],
        'ddlCategory' => 80,
        'ddlCategorySmall' => 83,
        'ddlProGroup' => 4472,
        //'txtPrice'=> 222222,
        'mypicone'=>$img_str[0],
        'hidimgone'=>$img_str[0],
        'HiddenField1'=>'Business Services',
        'HiddenField2'=>'Brokerage, Intermediary Service',
        'ddlEndTime'=>30,
        'btnSubmit'=>'Post it Now'

    );

    //推送操作
    $response = post($url, $post_data, $login_cookie_str);
    if ($response['err']) {
        return $response['err'];
    }

    return 'success';
}
