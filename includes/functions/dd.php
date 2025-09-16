<?php

(defined('ABSPATH')) || exit;

ob_start();

function dd(mixed ...$values)
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

    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>🐛 Debug Output</title>
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                background: #1a1a1a;
                color: #e1e1e1;
                font-family: "Fira Code", "Consolas", monospace;
                padding: 20px;
                line-height: 1.6;
            }
            .debug-container {
                max-width: 1200px;
                margin: 0 auto;
                background: #2d2d2d;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            }
            .debug-header {
                background: #570303ff;
                color: #fff;
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 20px;
                font-weight: bold;
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .debug-item {
                background: #3d3d3d;
                padding: 15px;
                border-radius: 6px;
                margin-bottom: 15px;
                border-left: 4px solid #4ecdc4;
                overflow-x: auto;
            }
            pre {
                white-space: pre-wrap;
                word-wrap: break-word;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <div class="debug-container">
            <div class="debug-header">
                📂 ' . htmlspecialchars($file) . ':' . htmlspecialchars($line) . '
            </div>';

    if (empty($values)) {
        echo '<div class="debug-item">🐛</div>';
    } else {
        foreach ($values as $value) {
            echo '<div class="debug-item"><pre>';
            var_dump($value);
            echo '</pre></div>';
        }
    }

    echo '</div></body></html>';

    $output = ob_get_clean();
    echo $output;

    exit(1);
    die(1);
}