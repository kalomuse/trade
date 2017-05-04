<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/14
 * Time: 下午2:35
 */

function send_auto1688($web, $product) {
    global $PATH, $SERVER;
    $extra_cookie = "";

    $url = 'http://www.aunetads.com/post/post-free-ads.php';
    $response = get($url, '', 0, 3);
    preg_match('/free-ads-rand_num_image.php\?vcid=(\d*)/', $response['res'], $match);

    $url = "http://www.aunetads.com/post/post-free-ads-op.php";
    $post_data = array(
        "adTitle" => $product['name'],
        "adDescription" => $product['description'],
        "adimage" => new CURLFile($PATH . $product['img']),
        "category" => 9205,
        "targetCity" => '',
        "targetState" => '',
        "ownerName" => 'Micky',
        "contactPhone" => '',
        "contactEmail" => '',
        "adPasscode" => 'Qu999999jm',
        "vcid" => $match[1],
        "validationCode" => '',
    );
    $code_url = "http://www.aunetads.com/post/free-ads-rand_num_image.php?vcid=" . $match[1];
    return '连接超时';

    do {
        $response = get($code_url);
        file_put_contents("$SERVER/util/code/test/1.png", $response['res']);
        $post_data['validationCode'] = get_code("$SERVER/util/code/", "aunetads");
        $response = upload($url, $post_data, '', 1, 3);
        preg_match('/<ul class="ssListErrMsg"><li>(.*)<\/ul>/s', $response['res'], $match);
        if($match) {
            if(preg_match('/validation code/', $match[1])) {

            } else {
                return $match[1];
            }
        } else {
            return 'success';
        }
    } while(1);
}
