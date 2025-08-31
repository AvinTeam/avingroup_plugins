<?php

(defined('ABSPATH')) || exit;

function post_image_url()
{
    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

    return empty($thumbnail_url) ? '' : esc_url($thumbnail_url);

}