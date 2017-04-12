<?php

function upload_bikudo($filename, $cookie) {
    $get_url = "http://www.bikudo.com/manage_products.do";
    $response = get($get_url, $cookie, 0, 3);
    preg_match('/<a href="javascript:displayWindow\(\'(.*)\',(.*)\)">Add Photo<\/a>/', $response['res'], $match);
    preg_match('/sb_id=(.*)\',/', $match[1], $match);
    $url = "http://www.bikudo.com/upload_product_image.do";
    $post_data = array(
        'userfile'=> new CURLFile($filename),
        'act'=>'upload',
        'pid'=>$match[1],
        'num'=>'0',
        'MAX_FILE_SIZE'=>'1000000',
        'Submit'=>'Upload',
    );
    $response = upload($url, $post_data, $cookie, 1, 3);
    preg_match('/Location:(.*)/',$response['res'], $match);
    if(preg_match('/successfully/', $match[1])) {
        return 'success';
    } else
        return $match[1];

}
