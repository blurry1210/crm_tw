<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tomorrow = now()->addDay()->toDateString();
            $events = \App\Models\Event::whereDate('date', $tomorrow)->get();

            $users = \App\Models\User::all();
            foreach ($users as $user) {
                \Mail::to($user->email)->send(new \App\Mail\DailyEventsMail($events));
            }
        })->everyMinute(); // For testing, we'll use everyMinute()
    }


    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
