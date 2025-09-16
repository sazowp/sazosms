<?php
(defined('ABSPATH')) || exit;

function add_url_param($url, $params = [  ])
{
    $url = trim($url);

    // اگر آدرس خالی است
    if (empty($url)) {
        return '';
    }

    // اضافه کردن پروتکل اگر وجود ندارد
    if (! preg_match('/^https?:\/\//i', $url)) {
        $url = 'https://' . $url;
    }

    // تجزیه URL برای بررسی بهتر
    $parsed_url = parse_url($url);

    // بازسازی URL پایه
    $base_url = '';
    if (isset($parsed_url[ 'scheme' ])) {
        $base_url .= $parsed_url[ 'scheme' ] . '://';
    }
    if (isset($parsed_url[ 'host' ])) {
        $base_url .= $parsed_url[ 'host' ];
    }
    if (isset($parsed_url[ 'port' ])) {
        $base_url .= ':' . $parsed_url[ 'port' ];
    }
    if (isset($parsed_url[ 'path' ])) {
        $base_url .= $parsed_url[ 'path' ];
    }

    // حذف اسلش انتهایی از base_url
    $base_url = rtrim($base_url, '/');

    // جمع‌آوری پارامترهای موجود
    $existing_params = [  ];
    if (isset($parsed_url[ 'query' ])) {
        parse_str($parsed_url[ 'query' ], $existing_params);
    }

    // ادغام پارامترهای موجود با پارامترهای جدید
    $all_params = array_merge($existing_params, $params);

    // ساخت query string
    $query_string = http_build_query($all_params);

    // اضافه کردن fragment اگر وجود دارد
    $fragment = isset($parsed_url[ 'fragment' ]) ? '#' . $parsed_url[ 'fragment' ] : '';

    return $base_url . ($query_string ? '?' . $query_string : '') . $fragment;
}
