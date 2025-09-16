<?php

(defined('ABSPATH')) || exit;


function get_current_relative_url()
{
    // گرفتن مسیر فعلی بدون دامنه
    $path = esc_url_raw(wp_unslash($_SERVER[ 'REQUEST_URI' ]));

    $relative_url = strtok($path, '?');
    $query_string = $_SERVER[ 'QUERY_STRING' ];

    if ($query_string) {
        $relative_url .= '?' . $query_string;
    }
    return $relative_url;
}

function zba_to_english($text)
{

    $western = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ];
    $persian = [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ];
    $arabic  = [ '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' ];
    $text    = str_replace($persian, $western, $text);
    $text    = str_replace($arabic, $western, $text);
    return $text;

}

function is_mobile($mobile)
{
    $pattern = '/^(\+98|0)?9\d{9}$/';
    return preg_match($pattern, $mobile);
}

function zba_transient()
{
    $zba_transient = get_transient('zba_transient');

    if ($zba_transient) {
        delete_transient('zba_transient');
        return $zba_transient;
    }

}

function linktocode($input)
{
    if (preg_match('/^[a-zA-Z0-9]+$/', $input)) {
        return $input; // ورودی همان کد است
    }

    if (preg_match('/aparat\.com\/v\/([a-zA-Z0-9]+)/', $input, $matches)) {
        return $matches[ 1 ]; // کد ویدیو را برگردان
    }

    return null;
}

