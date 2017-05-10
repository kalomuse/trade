<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
$PATH = dirname(__FILE__);
$CLIENT = $PATH.'/client';
$SERVER = $PATH.'/server';
function json_write($res) {
    Header('Content-type:application/json; charset=UTF-8');
    echo json_encode($res);
}
