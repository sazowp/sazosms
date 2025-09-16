<?php
namespace SazoWP\App\Core\Traits;

(defined('ABSPATH')) || exit;

trait AdminMessageTrait
{

    protected function success(string $massage, array $classes = [  ], string $id = "id")
    {

        wp_admin_notice(
            $massage,
            [
                'id'                 => $id,
                'type'               => 'success',
                'additional_classes' => $classes,
                'dismissible'        => true,
             ]
        );
    }

    protected function error(string $massage, array $classes = [  ], string $id = "id")
    {

        wp_admin_notice(
            $massage,
            [
                'id'                 => $id,
                'type'               => 'error',
                'additional_classes' => $classes,
                'dismissible'        => true,
             ]
        );
    }

}
