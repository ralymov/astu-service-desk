<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Employee\Location;

class LocationController extends ApiController
{

    public function index()
    {
        return Location::all();
    }

}
