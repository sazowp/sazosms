<?php

(defined('ABSPATH')) || exit;

function zba_form_winners()
{
    ob_start();
    include_once ZBA_VIEWS . 'form_winners.php';
    return ob_get_clean();
}

add_shortcode("zba_winners", "zba_form_winners");
