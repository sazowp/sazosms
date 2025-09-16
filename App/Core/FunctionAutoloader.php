<?php
namespace SazoWP\App\Core;
(defined('ABSPATH')) || exit;

use Exception;

class FunctionAutoloader
{

    public function __construct()
    {
        $this->loadAll();
    }

    public function loadAll()
    {
        $functions_path = ZBA_PATH . 'includes/functions/';

        if (! is_dir($functions_path)) {
            throw new Exception("Functions directory not found: " . $functions_path);
        }

        $files = glob($functions_path . '*.php');

        if (empty($files)) {
            throw new Exception("No function files found in: " . $functions_path);
        }

        foreach ($files as $file) {
            require_once $file;
        }
    }
}