<?php

namespace App\Models\Storage\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * Model for events (such as olympiads, conference, etc.)
 * @property integer id
 * @property array computers
 * @property array software
 */
class Event extends Model
{

    protected $guarded = ['id'];
    protected $casts = [
        'computers' => 'array',
        'software' => 'array',
    ];

//    public function getDateAttribute($date): ?string
//    {
//        if (!$date) return null;
//        return Carbon::parse($date)->format('d.m.Y');
//    }

    public function calculateInstallationTime()
    {
        $totalInstallationTime = 0; //in minutes
        $computers = $this->computers;
        $software = $this->software;
        $currentSoftware = null;
        $currentRam = null;
        $currentProcessor = null;
        foreach ($software as $item) {
            $currentSoftware = Program::find($item['program_id']);
            foreach ($computers as $computer) {
                $currentRam = Ram::find($computer['ram_id']);
                $currentProcessor = Processor::find($computer['processor_id']);
                $totalInstallationTime += $currentSoftware->calculateInstallationTime($currentRam, $currentProcessor);
            }
        }
        return $totalInstallationTime;
    }

}
