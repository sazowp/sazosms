<?php
(defined('ABSPATH')) || exit;

/**
 * Laravel-like config system for WordPress theme
 */

if (!function_exists('config')) {
    /**
     * Get configuration value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key, $default = null)
    {
        static $configs = [];
        
        // Split the key into file and path parts
        $parts = explode('.', $key);
        $file = array_shift($parts);
        
        // Load config file if not already loaded
        if (!isset($configs[$file])) {
            $config_path = ZBA_CONFIG . $file . '.php';
            
            if (file_exists($config_path)) {
                $configs[$file] = require $config_path;
            } else {
                $configs[$file] = [];
            }
        }
        
        // Get value from config array
        $value = $configs[$file];
        
        foreach ($parts as $part) {
            if (is_array($value) && isset($value[$part])) {
                $value = $value[$part];
            } else {
                return $default;
            }
        }
        
        return $value;
    }
}

// Optional: Add config helper for use in templates
if (!function_exists('get_config')) {
    function get_config($key, $default = null) {
        return config($key, $default);
    }
}
?>