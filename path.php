<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
$PATH = dirname(__FILE__);
$CLIENT = $PATH.'/client';
$SERVER = $PATH.'/server';
function json_write($res) {
    Header('Content-type:application/json; charset=UTF-8');
    echo json_encode($res);
}
function register_status($db, $mark, $msg) {
    $web = $db->query('account', "mark=\"$mark\"");
    $web = $web[0];
    //写入log
    $set = array(
        'site_name' => $web['site_name'],
        'msg' => $msg,
        'site_url' => $web['site_url'],
        'success' => 0,

    );
    if ($msg == 'success') {
        $set['success'] = 1;
        $set['msg'] = '注册成功';
    }
    $db->insert('log', $set);
}
