<?php

(defined('ABSPATH')) || exit;

ob_start();

function ddd(mixed ...$values)
{
    ob_clean();

    if (! headers_sent()) {
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: text/html; charset=UTF-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
    }

    // اطلاعات مکان فراخوانی
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1)[ 0 ];
    $file      = str_replace(str_replace('\\', '/', ABSPATH . "wp-content\\"), '', str_replace('\\', '/', $backtrace[ 'file' ]));
    $file      = ltrim(str_replace('/', '\\', $file), '\\');
    $line      = $backtrace[ 'line' ] ?? 'unknown';

    ob_get_clean();

    $data[ 'line' ] = htmlspecialchars($file) . ':' . htmlspecialchars($line);

    if (empty($values)) {
        $data[ 'data' ] = '🐛';
    } else {
        $m = 0;

        foreach ($values as $value) {

            $data[ 'data' . $m ] = $value;

            $m++;

        }

    }

    wp_send_json_error($data);

    exit(1);
    die(1);
}