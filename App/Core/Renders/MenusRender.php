<?php
namespace SazoWP\App\Core\Renders;

use Exception;

(defined('ABSPATH')) || exit;

class MenusRender
{

    private string $moduleName = 'Menus';

    public function __construct()
    {
        $path = ZBA_PATH . 'App/Modules/' . $this->moduleName . '/';

        if (! is_dir($path)) {
            throw new Exception("PostTypes directory not found: " . $path);
        }

        $files = glob($path . '*.php');

        if (empty($files)) {
            throw new Exception("No PostTypes files found in: " . $path);
        }

        foreach ($files as $file) {
            try {
                $fileName      = pathinfo($file, PATHINFO_FILENAME);
                $fullClassName = 'ZBA\\App\\Modules\\' . $this->moduleName . '\\' . $fileName;

                if (! class_exists($fullClassName)) {
                    throw new Exception("Class {$fullClassName} not found");
                }

                new $fullClassName();

            } catch (Exception $e) {
                error_log('PostTypeRender Error: ' . $e->getMessage());
                continue; 
            }
        }
    }
}
