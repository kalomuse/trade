<?php
function upload_asiamachinery($filename, $product_id, $cookie) {
    $url = "https://www.asiamachinery.net/admin/product_new_step3.asp";
    $post_data = array(
        'file'=> new CURLFile($filename),
        'ProID'=> $product_id,
        'Submit'=> 'upload'
    );
    $response = upload($url, $post_data, $cookie);
    preg_match('/Product image uploaded/', $response['res'], $match);
    if($match) {
        return [1, '上传成功'];
    } else {
        return [0, '上传失败'];
    }

}
