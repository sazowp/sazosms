<?php
namespace SazoWP\App\Core;

use SazoWP\App\Core\Traits\JDF;

(defined('ABSPATH')) || exit;

class Accesses
{

    use JDF;

    public function __construct()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_action('after_setup_theme', [ $this, 'nav_menu_theme_setup' ]);
        add_filter('wp_title', [ $this, 'title_filter' ]);
        add_filter('get_the_archive_title_prefix', [ $this, 'archive_title_prefix' ]);
        add_filter('posts_search', [ $this, 'search_by_meta' ], 10, 2);

        add_filter('get_the_date', [ $this, 'get_the_date' ]);

    }

    public function nav_menu_theme_setup()
    {
        register_nav_menus([
            'main-menu'        => 'فهرست راست هدر',
            'left-header-menu' => 'فهرست چپ هدر',
            'footer-menu'      => 'فهرست فوتر',
         ]);
    }

    public function title_filter($title)
    {
        if (is_home() || is_front_page()) {
            $title = get_bloginfo('name');
        } elseif (is_single() || is_page()) {
            $title = get_the_title() . " | " . get_bloginfo('name');
        } elseif (is_category()) {
            $title = single_cat_title('', false) . " | " . get_bloginfo('name');
        } elseif (is_tag()) {
            $title = single_tag_title('', false) . " | " . get_bloginfo('name');
        } elseif (is_search()) {
            $title = "نتایج جستجو برای " . get_search_query();
        } elseif (is_404()) {
            $title = get_bloginfo('name') . "صفحه پیدا نشد | ";
        } elseif (is_tax('cat_product')) {
            $title = get_the_archive_title() . " | " . get_bloginfo('name');

        } else {
            $title = get_bloginfo('name');
        }
        return $title;
    }

    public function archive_title_prefix($prefix)
    {

        $prefix = '';

        return $prefix;
    }

    public function search_by_meta($search, $wp_query)
    {
        global $wpdb;

        // فقط در جستجو اجرا شود و اگر عبارت جستجو خالی است از تغییر صرفنظر شود
        if (empty($search) || ! $wp_query->is_search()) {
            return $search;
        }

        // دریافت عبارت جستجو و ایجاد عبارت LIKE ایمن برای استفاده در کوئری
        $search_term = $wp_query->query_vars[ 's' ];
        $like        = '%' . $wpdb->esc_like($search_term) . '%';

        // ساخت یک کوئری سفارشی که عنوان، محتوا و متا را جستجو کند
        $search = $wpdb->prepare(" AND (
        ({$wpdb->posts}.post_title LIKE %s)
        OR ({$wpdb->posts}.post_content LIKE %s)
        OR EXISTS (
            SELECT 1 FROM {$wpdb->postmeta}
            WHERE {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
            AND {$wpdb->postmeta}.meta_value LIKE %s
        )
        )", $like, $like, $like);

        return $search;
    }

    public function get_the_date($the_date)
    {
        return $this->date($the_date);
    }

}
