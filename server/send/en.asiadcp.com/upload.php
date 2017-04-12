<?php

function upload_en_asiadcp($filename, $cookie) {
    $url = "http://en.asiadcp.com/member/mypicture.php?action=1";
    $post_data = array(
        'userfile'=> new CURLFile($filename),
        'inpid'=>'propic',
        'upload'=>'Upload',
        'method'=>'upload'

    );
    $response = upload($url, $post_data, $cookie);
    preg_match('/selectpic\(\'propic\',\'(.*)\'\);/', $response['res'], $match);

    return $match[1];

}
