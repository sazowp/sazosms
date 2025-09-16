<?php
namespace SazoWP\App\Core;

(defined('ABSPATH')) || exit;

class Init
{

    public function __construct()
    {

        add_action('init', [ $this, 'init' ]);

    }

    /**
     * Fires after WordPress has finished loading but before any headers are sent.
     *
     */
    public function init(): void
    {
        if (wp_is_json_request()) {
            zba_cookie();
        }

        // $this->voteAyeh();

    }

    // public function voteAyeh()
    // {

    //     if (isset($_POST[ 'act' ]) && $_POST[ 'act' ] == "vote_ayeh") {

    //         $massage = '';

    //         if (wp_verify_nonce($_POST[ '_wpnonce' ], 'zba_nonce_captcha' . zba_to_english($_POST[ 'captcha' ]))) {

    //             $phone = sanitize_phone($_POST[ 'phone' ]);

    //             if (! isset($_POST[ 'vote_ayeh' ])) {
    //                 $massage .= '<div class="alert alert-danger" role="alert">هیچ آیه ای انتخاب نشده است.</div>';
    //             }
    //             if (empty($phone) || ! is_mobile($phone)) {
    //                 $massage .= '<div class="alert alert-danger" role="alert">شماره موبایل شما درست نمی باشد</div>';
    //             }

    //             if (empty($massage)) {
    //                 $zbadb = new ZBADB('vote');

    //                 if ($zbadb->num([ 'mobile' => $phone ])) {
    //                     $massage .= '<div class="alert alert-danger" role="alert">شما قبلا رای خود را ثبت کردید</div>';
    //                 } else {

    //                     $ayeh = zba_to_english(intval($_POST[ 'vote_ayeh' ]));

    //                     $insert = $zbadb->insert([
    //                         'mobile' => $phone,
    //                         'ayeh'   => $ayeh,

    //                      ]);

    //                     if ($insert) {

    //                         $massage .= '<div class="alert alert-success" role="alert">رای شما ثبت شده است با تشکر از شما</div>';

    //                         update_post_meta($ayeh, '_vote_ayeh', intval($zbadb->num([ 'ayeh' => $ayeh ])));

    //                     } else {
    //                         $massage .= '<div class="alert alert-danger" role="alert">لطفا دوباره تلاش کنید</div>';
    //                     }

    //                 }

    //             }

    //         } else {
    //             $massage .= '<div class="alert alert-danger" role="alert">سوال امنیتی را اشتباه جواب دادید</div>';

    //         }

    //         set_transient('zba_transient', $massage, MINUTE_IN_SECONDS);

    //         wp_redirect($_POST[ '_wp_http_referer' ]);
    //         exit;

    //     }
    // }

}
