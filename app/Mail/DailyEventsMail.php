<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DailyEventsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $events;

    public function __construct($events)
    {
        $this->events = $events;
    }

    public function build()
    {
        return $this->view('emails.daily_events')
                    ->with([
                        'events' => $this->events,
                    ]);
    }
}
