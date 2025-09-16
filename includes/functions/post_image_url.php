<?php

(defined('ABSPATH')) || exit;

function post_image_url($id = null)
{
    if (is_null($id)) {$id = get_the_ID();}

    $thumbnail_url = get_the_post_thumbnail_url($id, 'full');

    return empty($thumbnail_url) ? '' : esc_url($thumbnail_url);

}
