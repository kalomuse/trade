<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/17
 * Time: 上午9:48
 */
require_once ("../../path.php");
require_once ("$SERVER/conf/db.php");
function query() {
    $db = new DB();
    $res = $db -> query('account');
    return $res;
}

function save($id, $set) {
    $db = new DB();
    $res = $db->update('account', $set, "id=$id");
    return $res;
}

switch ($_GET['action']) {
    case 'save':
        if(!$_POST['account'])
            echo "请输入账号";
        else if(!$_POST['account'])
            echo "请输入网站";

        $id = $_POST['id'];
        unset($_POST['id']);
        $res = save($id, $_POST);
        if($res) {
            $res = array(
                'ok' => 1,
                'msg' => ''
            );

        } else {
            $res = array(
                'ok' => 0,
                'err' => '修改失败'
            );
        }
        json_write($res);
        break;
}




