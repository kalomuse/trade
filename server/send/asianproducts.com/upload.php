<?php

function upload_asianproducts($filename, $cookie) {
    $get_url = "https://member.asianproducts.com/member/?op=product&action=add_new_v2&from=tab";
    $response = get($get_url,$cookie, 0, 3);
    $url = "http://images.asianproducts.com/upload_product_image.php";
    preg_match('/op=product&cno=(.*)&item_id=(.*)&preview=1/', $response['res'], $match);
    $post_data = array(
        'itemPicLarge'=> new CURLFile($filename),
        'replace_image'=>'0',
        'replace_eoimage'=>'0',
        'simple'=>'0',
        'uplimgtime'=>'0',
        'uplimgfname'=>'itemPicLarge',
        'fsmaintain'=>'0',
        'cno'=>$match[1],
        'item_id'=>$match[2],

    );
    $response = upload($url, $post_data, $cookie, 0, 3);
    if($response['res'] == 'true') {
        $response = get($url, $cookie, 0, 3);
        $res = json_decode($response['res']);
        return [1, $res->tmpurl, $match[1], $match[2]];
    } else
        return [0, '图片类型为jpg'];

}
