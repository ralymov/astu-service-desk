<?php

namespace App\Http\Controllers\Api\Ticket\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\References\TicketType;

class TicketTypeController extends ApiController
{

    public function index()
    {
        return TicketType::all();
    }

}
