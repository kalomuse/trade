<?php
/**
 * Created by kalomuse.
 * User: apple
 * Date: 17/3/17
 * Time: 下午4:50
 */
require_once ('../../path.php');
require_once ("$SERVER/conf/db.php");
require_once ("$SERVER/util/Request.php");
require_once ("$SERVER/util/File.php");
require_once ("$SERVER/util/cookie.php");
require_once ("$SERVER/util/code/test.php");

$res = array(
    'ok' => 0,
    'err' => '',
    'msg' => ''
);
$db = new DB();
//取出产品详情
$product = $db->query('product', "id=".$_POST['id']);
$product = $product[0];

if($product) {
    $pid = pcntl_fork();
    if ($pid == -1) {
        die('could not fork');
    } else if (!$pid) {
        //调用队列
        $dh = opendir('./');
        while (($file = readdir($dh)) != false) {
            //if($file == 'canetads.com')
            if ($file != 'index.php' && $file != '.' && $file != '..' && $file != 'keys') {
                $db = new DB();
                $web = $db->query('account', "mark=\"$file\"");
                $web = $web[0];
                if ($web['account'] && $web['password']) {
                    if (file_exists("$file/send.php")) {
                        $t = explode('.', $file);
                        $t_str = '';
                        for ($i = 0; $i < count($t) - 1; $i++) {
                            $t_str .= "_" . $t[$i];
                        }
                        require_once("$file/send.php");
                        $send = "send$t_str";
                        $msg = $send($web, $product);
                    } else {
                        $msg = $web['website_url'] . "文件不存在，请联系开发人员";
                    }
                } else {
                    $msg = "请绑定" . $web['website_url'] . "正确账号";
                }
                //写入log
                $set = array(
                    'site_name' => $web['site_name'],
                    'site_url' => $web['site_url'],
                    'product_name' => $product['name'],
                    'product_id' => $product['id'],
                    'success' => 0,
                    'msg' => $msg,
                );
                if ($msg == 'success') {
                    $set['success'] = 1;
                    $set['msg'] = '发送成功';
                }
                $db->insert('log', $set);
            }
        }
    } else {
        //count + 1
        $set = array(
            'count' => array(
                'value' => 'count + 1',
                'no_str' => 1
            ),
        );
        $db = new DB();
        $db->update('product', $set, "id=".$product['id']);

	ob_start();
        //返回结果
        json_write(array(
            'ok' => 1,
            'err' => '',
            'msg' => '发送成功'
        ));
	$size = ob_get_length();
	header("Content-Length: ". $size . "\r\n"); 
	ob_end_flush();
	flush();
        //fastcgi_finish_request();
    }
} else {
    $res['err'] = "该产品不存在";
    return json_write($res);
}
