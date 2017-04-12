<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/17
 * Time: 下午1:35
 */

require_once ("../../path.php");
require_once ("$SERVER/conf/db.php");
require_once ("$SERVER/util/File.php");

function upload() {
    $url = save_file();
    return $url;
}
function add_product() {
    $db = new DB();
    $res = validate();
    $_POST['img'] = $_COOKIE['img_path'];
    if($res['ok']) {
        $ok = $db->insert('product', $_POST);
        if(!$ok) {
            $res = array(
                'ok' => 0,
                'err' => '数据库添加失败'
            );
        } else {
            setcookie('img_path','',time() - 3600);
        }
    }
    return $res;
}

function update_product() {
    $db = new DB();
    $res = validate();
    $_POST['img'] = $_COOKIE['img_path'];
    if($res['ok']) {
        $ok = $db->update('product', $_POST, "id=".$_GET['id']);
        if(!$ok) {
            $res = array(
                'ok' => 0,
                'err' => '更新失败'
            );
        } else {
            setcookie('img_path','',time() - 3600);
        }
    }
    return $res;
}

function list_product() {
    $db = new DB();
    if($_GET['id']) {
        $res = $db->query('product', "id=" . $_GET['id']);
        if($res) {
            setcookie('img_path', $res[0]['img'], null, '/');
        } else {

        }
    } else
        $res = $db->query('product');
    return $res;
}

switch ($_GET['action']) {
    case 'upload':  //上传图片
        $url = upload();
        $res = array('url' => $url);
        json_write($res);
        break;
    case 'add':     //添加产品
        $res = add_product();
        json_write($res);
        break;
    case 'update':     //修改产品
        $res = update_product();
        json_write($res);
        break;
}


function validate() {
    $res = array(
        'ok' => 0,
        'msg' => '添加成功',
        'err' => ''
    );
    if(!$_POST['name'])
        $res['err'] = '产品名为空';
    else if(!$_POST['category'])
        $res['err'] = '产品分类为空';
    else if(!$_POST['brief'])
        $res['err'] = '产品摘要为空';
    else if(!$_POST['description'])
        $res['err'] = '详细描述为空';
    else if(!$_COOKIE['img_path'])
        $res['err'] = '图片不能为空';
    else if(count(explode(' ', trim($_POST['name']))) < 4)
        $res['err'] = '产品名少于4个单词';
    else
        $res['ok'] = 1;
    return $res;
}
