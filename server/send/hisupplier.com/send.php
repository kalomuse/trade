<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */
require_once ('login.php');
require_once ('upload.php');

function send_hisupplier($web, $product) {
    global $PATH;
    $extra_cookie = "";
    $url = 'http://account.hisupplier.com/product/add_submit_new.htm';

    //上传操作
    $img_path = upload_hisupplier($PATH . $product['img']);
    if(!$img_path)
        return '图片上传失败';

    $post_data = array(
        'catId' => '1407',
        'catName' => $product['category'],
        'proName' => $product['name'],
        'brief' => $product['brief'],
        'description' => $product['description'],
        'productImageArray' => $img_path,
        'origin' => '',
        'oldGroupId' => '0',
        'tag3ListValue' => '',
        'proId' => '0',
        'userId' => '426935',
        'tag3ListName' => '',
        'newForm' => 'true',
        'image.watermark' => '',
        'deliveryDate' => '',
        'price3' => '',
        'groupOrder' => '0',
        'image.watermarkRight' => 'true',
        'productivity' => '',
        'minOrderUnit1' => '',
        'addMin' => '',
        //'__checkbox_paymentType' => ['T/T', 'L/C', 'D/A', 'D/P', 'W', 'Paypal', 'Money Gram', 'other'],
        'productMax' => '0',
        'addPrice' => '',
        'groupName' => '',
        'minOrderUnit' => '',
        'priceUnit1' => '',
        'attachment' => '',
        'oldCatId' => '0',
        'priceTermOther' => '',
        'multLang' => '',
        'transportation' => '',
        'filePath' => '',
        'priceUnit' => '',
        '__multiselect_specialGroupIdArray' => '',
        'paymentType' => '', 'packing' => '',
        'imgId' => '0',
        'productCount' => '0',
        'minOrderNum' => '',
        'optimizePro' => 'true',
        'image.watermarkTextColor' => '#cccccc',
        'groupId' => '0',
        'addTrade' => 'false',
        'state' => '0',
        //'image.watermarkText' => 'zhoushandazhong.en.hisupplier.com',
        'country' => '',
        'image.textFontSize' => '0',
        '__multiselect_priceTerm' => '',
        'model' => '',
    );

    //登录操作
    $login_cookie_names = login_hisupplier($web);
    if ($login_cookie_names[0]) {
        $login_cookie_str = get_cookie_str_for_arr($login_cookie_names[1], $extra_cookie);
    } else {
        return $login_cookie_names[1];
    }

    //推送操作
    $response = post($url, $post_data, $login_cookie_str);
    if(!isset($response['res'])) {
        return '连接超时';
    }
    return 'success';
}
