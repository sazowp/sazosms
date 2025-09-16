<?php
(defined('ABSPATH')) || exit;

add_action('wp_dashboard_setup', 'mph_dashboard_widget');
function mph_dashboard_widget()
{

    wp_add_dashboard_widget(
        'mph_dashboard',
        'تعداد از تپسل',
        'mph_dashboard_callback',
        null,
        null,
        'normal',
        'high'
    );

    function mph_dashboard_callback()
    {
        $tapsell_download_app = absint(get_option('tapsell_download_app'));

        echo number_format($tapsell_download_app);

    }

}

if (isset($_GET[ 'tapsell' ])) {
    $tapsell_download_app = absint(get_option('tapsell_download_app'));

    $tapsell_download_app++;

    update_option('tapsell_download_app', $tapsell_download_app);

    wp_redirect('https://zendegibaayeha.ir/app/');
    exit;

}
