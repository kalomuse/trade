<?php
/**
 * Created by PhpStorm.
 * User: apple
 * Date: 17/3/20
 * Time: 下午1:41
 */
function get_attr($url, $cookie='') {
    $response = get($url, $cookie);
    preg_match('/id="__VIEWSTATE" value="(.*)" \/>/', $response['res'], $match);
    $view = $match[1];
    preg_match('/id="__EVENTVALIDATION" value="(.*)" \/>/', $response['res'], $match);
    $event = $match[1];
    return array(
        'view' => $view,
        'event' => $event
    );
}