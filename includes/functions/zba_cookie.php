<?php

(defined('ABSPATH')) || exit;

function zba_cookie()
{

    if (! is_user_logged_in()) {

        if (! isset($_COOKIE[ "setcookie_zba_nonce" ])) {

            $is_key_cookie = wp_generate_password('15', true, true);
            ob_start();

            setcookie("setcookie_zba_nonce", $is_key_cookie, time() + 1800, "/");

            ob_end_flush();

            header("Refresh:0");
            exit;

        } else {
            $is_key_cookie = $_COOKIE[ "setcookie_zba_nonce" ];
        }
    } else {

        $is_key_cookie = get_current_user_id();

    }
    return $is_key_cookie;
}