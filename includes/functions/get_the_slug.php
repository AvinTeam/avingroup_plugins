<?php

(defined('ABSPATH')) || exit;

function get_the_slug($id = null)
{
    if (is_null($id)) {$id = get_the_ID();}

    $url = get_the_permalink(intval($id));

    return basename(rtrim($url, '/'));

}
