<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatDateTrait
{

    public function getCreatedAtAttribute($date): ?string
    {
        if (!$date) return null;
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i:s');
    }

    public function getUpdatedAtAttribute($date): ?string
    {
        if (!$date) return null;
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i:s');
    }

}
