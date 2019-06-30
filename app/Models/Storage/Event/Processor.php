<?php

namespace App\Models\Storage\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property int processors_number
 * @property int frequency
 */
class Processor extends Model
{

    protected $guarded = ['id'];

}
