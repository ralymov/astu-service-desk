<?php

namespace App\Models\Storage\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int generation
 * @property int frequency
 * @property int memory_size
 */
class Ram extends Model
{

    protected $table = 'ram';
    protected $guarded = ['id'];

}
