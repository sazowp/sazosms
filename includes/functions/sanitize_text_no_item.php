<?php

(defined('ABSPATH')) || exit;

function sanitize_no_item($item)
{

    foreach ($item as $key => $value) {

        if (is_array($value) || is_object($value)) {
            $notEmptyItem = 0;
            foreach (array_values($value) as $valueItem) {
                if (! empty(trim($valueItem))) {$notEmptyItem++;}
            }

            if ($notEmptyItem == 0) {continue;}

        } else {
            if (empty(trim($value))) {continue;}
        }

        $newItem[ $key ] = $value;
    }
    return $newItem ?? [  ];

}
