<?php

function upload_b2bage($url, $post_data, $cookie) {
    $response = upload($url, $post_data, $cookie, 0, 3);
    if(isset($response['res'])) {
        return 'success';
    } else {
        return '发送失败';
    }

}
