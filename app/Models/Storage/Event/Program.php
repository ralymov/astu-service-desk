<?php

namespace App\Models\Storage\Ticket;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property float processor_weight
 * @property float ram_weight
 * @property float processor_number_factor
 * @property float processor_frequency_factor
 * @property float processor_number_offset
 * @property float processor_frequency_offset
 * @property float ram_generation_factor
 * @property float ram_generation_offset
 * @property float ram_frequency_factor
 * @property float ram_frequency_offset
 * @property float ram_memory_size_factor
 * @property float ram_memory_size_offset
 */
class Program extends Model
{

    protected $guarded = ['id'];

    public function calculateInstallationTime(Ram $ram, Processor $processor): float
    {
        $Kp = $this->processor_weight;
        $P = (
                ($this->processor_number_factor / $processor->processors_number + $this->processor_number_offset)
                + ($this->processor_frequency_factor / $processor->frequency + $this->processor_frequency_offset)
            ) / 2;

        $O = (
                ($this->ram_generation_factor / $ram->generation + $this->ram_generation_offset)
                + ($this->ram_frequency_factor / $ram->frequency + $this->ram_frequency_offset)
                + ($this->ram_memory_size_factor / $ram->memory_size + $this->ram_memory_size_offset)
            ) / 3;
        $Ko = $this->ram_weight;

        return $P * $Kp + $O * $Ko;
    }

}
