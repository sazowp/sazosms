<?php
(defined('ABSPATH')) || exit;

function get_the_image_url($path)
{
    return ZBA_IMAGE . $path . '?ver=' . ZBA_VERSION;
}
