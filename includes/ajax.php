<?php

// add_action('wp_ajax_nopriv_zba_logout', 'zba_logout');
// add_action('wp_ajax_zba_logout', 'zba_logout');

// function zba_logout()
// {
//     wp_logout();
//     wp_send_json_success(home_url());
// }

// ثبت AJAX برای ذخیره گالری
add_action('wp_ajax_save_zba_galleries', 'zba_galleries');

function zba_galleries()
{
    check_ajax_referer('ajax-nonce', 'security');

    if (! current_user_can('manage_options')) {
        wp_send_json_error('دسترسی غیرمجاز!');
    }

    if (isset($_POST[ 'image_ids' ])) {
        update_option($_POST[ 'gallery_type' ], sanitize_text_field($_POST[ 'image_ids' ]));
        wp_send_json_success('ذخیره شد!');
    }

    wp_send_json_error('خطا در ذخیره‌سازی!');
}
