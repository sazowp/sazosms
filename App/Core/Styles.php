<?php
namespace SazoWP\App\Core;

use SazoWP\App\Class\ZBAOption;

(defined('ABSPATH')) || exit;

class Styles
{

    private $style_dep      = [  ];
    private $javascript_dep = [ 'jquery' ];

    public function __construct()
    {

        add_action('admin_enqueue_scripts', [ $this, 'admin_script' ]);

        add_action('wp_enqueue_scripts', [ $this, 'public_style' ]);

    }

    public function admin_script()
    {
        wp_enqueue_media();

        $this->jalalidatepicker();
        $this->select2();

        wp_enqueue_style(
            'zba_admin',
            ZBA_CSS . 'admin.css',
            $this->style_dep,
            ZBA_VERSION
        );

        wp_enqueue_script(
            'zba_admin',
            ZBA_JS . 'admin.js',
            $this->javascript_dep,
            ZBA_VERSION,
            true
        );

        wp_enqueue_script(
            'zba_admin',
            ZBA_JS . 'admin.js',
            [ 'jquery', 'jalalidatepicker' ],
            ZBA_VERSION,
            true
        );

        wp_localize_script(
            'zba_admin',
            'zba_js',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('ajax-nonce'),
                'socials' => config('app.socials', [  ]),
                'appLinks' => config('app.appLinks', [  ]),
             ]
        );

    }

    public function public_style()
    {
        $this->bootstrap();
        $this->select2();
        $this->jalalidatepicker();
        $this->swiper();

        wp_enqueue_style(
            'zba_style',
            ZBA_CSS . 'public.css',
            $this->style_dep,
            ZBA_VERSION
        );

        wp_enqueue_script(
            'zba_js',
            ZBA_JS . 'public.js',
            $this->javascript_dep,
            ZBA_VERSION,
            true
        );

        $ZBAOption = new ZBAOption();

        wp_localize_script(
            'zba_js',
            'zba_js',
            [
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce'   => wp_create_nonce('ajax-nonce' . zba_cookie()),
                'option'  => $ZBAOption->get(),
             ]
        );

    }

    private function bootstrap()
    {

        $this->style_dep[  ]      = 'bootstrap.icons';
        $this->javascript_dep[  ] = 'bootstrap';

        wp_register_style(
            'bootstrap.rtl',
            ZBA_VENDOR . 'bootstrap/bootstrap.rtl.min.css',
            [  ],
            '5.3.7'
        );
        wp_register_style(
            'bootstrap.icons',
            ZBA_VENDOR . 'bootstrap/bootstrap-icons.min.css',
            [ 'bootstrap.rtl' ],
            '1.13.1'
        );
        wp_register_script(
            'bootstrap',
            ZBA_VENDOR . 'bootstrap/bootstrap.min.js',
            [  ],
            '5.3.7',
            true
        );

    }

    private function select2()
    {

        $this->style_dep[  ] = $this->javascript_dep[  ] = 'select2';

        wp_register_style(
            'select2',
            ZBA_VENDOR . 'select2/select2.min.css',
            [  ],
            '4.1.0-rc.0'
        );
        wp_register_script(
            'select2',
            ZBA_VENDOR . 'select2/select2.min.js',
            [  ],
            '4.1.0-rc.0',
            true
        );

    }

    private function jalalidatepicker()
    {

        $this->style_dep[  ] = $this->javascript_dep[  ] = 'jalalidatepicker';

        wp_register_style(
            'jalalidatepicker',
            ZBA_VENDOR . 'jalalidatepicker/jalalidatepicker.min.css',
            [  ],
            '0.9.6'
        );
        wp_register_script(
            'jalalidatepicker',
            ZBA_VENDOR . 'jalalidatepicker/jalalidatepicker.min.js',
            [  ],
            '0.9.6',
            true
        );

    }

    private function swiper()
    {
        $this->style_dep[  ] = $this->javascript_dep[  ] = 'swiper';

        wp_register_style(
            'swiper',
            ZBA_VENDOR . 'swiper/swiper-bundle.min.css',
            [  ],
            '11.2.2',
        );

        wp_register_script(
            'swiper',
            ZBA_VENDOR . 'swiper/swiper-bundle.min.js',
            [  ],
            '11.2.2',

        );

    }

}
