<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/20
 * Time: 上午9:47
 */
require_once ("../../path.php");
require_once ("$SERVER/conf/db.php");

function list_log() {
    $db = new DB();
    $res = $db->query('log');
    return $res;
}