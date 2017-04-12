<?php
function upload_b2btrademarketing($filename, $cookie) {
    $url = "http://b2btrademarketing.com/upload_image.php?frm=add_new_product&key=";
    $post_data = array(
        'userfile'=> new CURLFile($filename, 'image/jpeg', 'aa.jpg'),
        'action'=> 'upload',
        'MAX_FILE_SIZE'=> '2097152',

    );
    $response = upload($url, $post_data, $cookie);
    preg_match('/window.opener.send_data_image\(\'(.*)\'\);/', $response['res'], $match);
    if($match) {
        return [1, $match[1]];
    } else {
        return [0, '上传失败'];
    }

}
