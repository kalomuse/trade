<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/4/10
 * Time: 下午4:10
 */
require_once ("../../../path.php");
json_write(array('ok' => 1, 'msg' => '注册成功'));

require_once ("$SERVER/conf/db.php");
$db = new DB();
register_status($db, 'canetads.com', 'success');