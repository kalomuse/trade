<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/17
 * Time: 上午9:48
 */
require_once ("../../path.php");
require_once ("$SERVER/conf/db.php");
require_once ("$SERVER/util/file.php");
function upload() {
    $url = save_file('number_img');
    return $url;
}
function query() {
    $db = new DB();
    $res = $db -> query('user', "id=1");
    return $res;
}

function save($id, $set) {
    if(!$_POST['company_number_img'] || preg_match('/base64/', $_POST['company_number_img']))
        $_POST['company_number_img'] = $_COOKIE['number_img'];
    $res = validate();
    if($res['ok']) {
        $db = new DB();
        $ok = $db->update('user', $_POST, "id=$id");
        if(!$ok) {
            $res = array(
                'ok' => 0,
                'err' => '数据库添加失败'
            );
        } else {
            setcookie('number_img','',time() - 3600);
        }
    }
    return $res;
}

switch ($_GET['action']) {
    case 'upload':  //上传图片
        $url = upload();
        $res = array('url' => $url);
        json_write($res);
        break;
    case 'save':
        $res = save(1, $_POST);
        json_write($res);
        break;
}

function validate() {
    $res = array(
        'ok' => 0,
        'msg' => '添加成功',
        'err' => ''
    );
    if(!$_POST['company_name'])
        $res['err'] = '请输入公司名';
    else if(!$_POST['company_en_name'])
        $res['err'] = '请输入公司英文名';
    else if(!$_POST['company_number_img'])
        $res['err'] = '请上传公司营业执照';
    else
        $res['ok'] = 1;
    return $res;
}




