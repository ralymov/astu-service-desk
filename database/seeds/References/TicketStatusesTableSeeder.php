<?php

use App\Models\Storage\Ticket\References\TicketStatus;
use Illuminate\Database\Seeder;

class TicketStatusesTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ticketStatuses = [
            ['name' => 'Новая', 'code' => TicketStatus::NEW],
            ['name' => 'Выполняется', 'code' => TicketStatus::IN_PROGRESS],
            ['name' => 'Необходимо уточнение', 'code' => TicketStatus::SPECIFY],
            ['name' => 'Завершенная', 'code' => TicketStatus::DONE],
            ['name' => 'Отменить', 'code' => TicketStatus::CANCEL],
        ];
        fill_seeds($ticketStatuses, TicketStatus::class, 'name');
    }
}
