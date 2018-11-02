<?php

namespace App\Http\Controllers\Api\Ticket\References;

use App\Http\Controllers\Api\ApiController;
use App\Models\Storage\Ticket\References\TicketPriority;

class TicketPriorityController extends ApiController
{

    public function index()
    {
        return TicketPriority::all();
    }

}
