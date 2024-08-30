<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rent;
use Carbon\Carbon;
use App\Mail\OverdueRentalNotification;
use Illuminate\Support\Facades\Mail;

class MarkOverdueRentals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rentals:mark-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark rentals as overdue if they are not returned within 2 weeks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $overdueRentals = Rent::whereNull('return_date')
            ->where('rent_date', '<=', $now->subWeeks(2))
            ->whereNull('overdue_date')
            ->get();

        foreach ($overdueRentals as $rental) {
            $rental->overdue_date = Carbon::now(); 
            $rental->save();

            Mail::to($rental->user->email)->send(new OverdueRentalNotification($rental));
        }

        $this->info('Overdue rentals have been marked successfully.');
        return 0;
    }
}