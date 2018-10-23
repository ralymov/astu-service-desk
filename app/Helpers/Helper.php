<?php

if (!function_exists('fill_seeds')) {
    function fill_seeds(array $records, $model, $uniqueField = 'code') {
        foreach ($records as $record) {
            $model::updateOrCreate(
                [$uniqueField => $record[$uniqueField]],
                $record
            );
        }
    }
}




