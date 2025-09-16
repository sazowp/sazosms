<?php
namespace SazoWP\App\Core;

use SazoWP\App\Core\Renders\MenusRender;

(defined('ABSPATH')) || exit;

class Render
{

    public function __construct()
    {
        new MenusRender;


    }
}
