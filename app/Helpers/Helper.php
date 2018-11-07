<?php

if (!function_exists('fill_seeds')) {
    function fill_seeds(array $records, $model, $uniqueField = 'code')
    {
        foreach ($records as $record) {
            $model::updateOrCreate(
                [$uniqueField => $record[$uniqueField]],
                $record
            );
        }
    }
}

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $encoding = NULL)
    {
        if ($encoding === NULL) {
            $encoding = mb_internal_encoding();
        }
        return mb_substr(mb_strtoupper($str, $encoding), 0, 1, $encoding) . mb_substr($str, 1, mb_strlen($str) - 1, $encoding);
    }
}





