<?php
namespace SazoWP\App\Core;

(defined('ABSPATH')) || exit;

class MetaBoxes
{

    public function __construct()
    {

        add_action('add_meta_boxes', [ $this, 'meta_boxes' ]);

        add_action('save_post', [ $this, 'save' ], 1, 3);

    }

    public function meta_boxes(): void
    {

        add_meta_box(
            'products_info',
            'اطلاعات محصول',
            [ $this, 'products_info' ],
            'products',
            'normal',
            'high'

        );

    }

    public function products_info($post)
    {
        $version     = get_post_meta(get_the_ID(), '_version', true);
        $link        = get_post_meta(get_the_ID(), '_link', true);
        $wp_version  = get_post_meta(get_the_ID(), '_wp_version', true);
        $php_version = get_post_meta(get_the_ID(), '_php_version', true);
        $last_update = get_post_meta(get_the_ID(), '_last_update', true);
        $aparat      = get_post_meta(get_the_ID(), '_aparat', true);
        $youtube     = get_post_meta(get_the_ID(), '_youtube', true);

        view('meta_post/products_info',
            [
                'version'     => $version,
                'link'        => esc_url($link),
                'wp_version'  => $wp_version,
                'php_version' => $php_version,
                'last_update' => $last_update,
                'aparat'      => esc_url($aparat),
                'youtube'     => esc_url($youtube),
             ]);

    }

    public function save($post_id, $post, $updata)
    {
        if (isset($_POST[ 'products_info' ])) {

            foreach ($_POST[ 'products_info' ] as $key => $value) {

                update_post_meta($post_id, '_' . $key, $value);
            }

        }
    }

}