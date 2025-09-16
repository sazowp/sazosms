<?php
/**
 * Sazo SMS
 *
 * Plugin Name: Sazo SMS
 * Plugin URI:  https://sazowp.ir//
 * Description: Sending SMS in WordPress for login and plugins
 * Version:     1.0.0
 * Author:      Mohammadreza Rashidpour Aghamahali
 * Author URI:  https://mrrashidpour.com/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Requires at least: 6.5
 * Requires PHP: 7.4
 * Text Domain: sazosms
 * Domain Path: /languages
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

use SazoWP\App\Core\FunctionAutoloader;

defined('ABSPATH') || exit;

preg_match('/Version:\s*(.+)/i', file_get_contents(__FILE__), $versionMatches);
define('SAZOSMS_VERSION', $versionMatches[ 1 ] ?? 0);

define('SAZOSMS_FILE', __FILE__);
define('SAZOSMS_PATH', plugin_dir_path(__FILE__));
define('SAZOSMS_INCLUDES', SAZOSMS_PATH . 'includes/');
define('SAZOSMS_CLASS', SAZOSMS_PATH . 'classes/');
define('SAZOSMS_VIEWS', SAZOSMS_PATH . 'views/');
define('SAZOSMS_SHORT_CODE_STYLE', SAZOSMS_VIEWS . 'style/');

define('SAZOSMS_URL', plugin_dir_url(__FILE__));
define('SAZOSMS_ASSETS', SAZOSMS_URL . 'assets/');
define('SAZOSMS_CSS', SAZOSMS_ASSETS . 'css/');
define('SAZOSMS_JS', SAZOSMS_ASSETS . 'js/');
define('SAZOSMS_IMAGE', SAZOSMS_ASSETS . 'image/');

add_action('plugin_loaded', function () {
    load_plugin_textdomain(
        'SAZOSMS',
        false,
        dirname(plugin_basename(__FILE__)) . '/languages'
    );
});


new FunctionAutoloader;