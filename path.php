<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
$PATH = dirname(__FILE__);
$CLIENT = $PATH.'/client';
$SERVER = $PATH.'/server';
function json_write($res, $mark='') {
    if($mark) {
        $mark_arr = explode('/', $mark);
        $mark = $mark_arr[count($mark_arr) - 1];
        if($mark) {
            global $SERVER;
            include_once("$SERVER/conf/db.php");
            $db = new DB();
            register_status($db, $mark, $res);
        }
    }
    Header('Content-type:application/json; charset=UTF-8');
    echo json_encode($res);
}
function register_status($db, $mark, $res) {
    $web = $db->query('account', "mark=\"$mark\"");
    $web = $web[0];
    //写入log
    $set = array(
        'site_name' => $web['site_name'],
        'msg' => $res['msg'],
        'site_url' => $web['site_url'],
        'success' => $res['ok'],
    );
    $db->insert('log', $set);
}
