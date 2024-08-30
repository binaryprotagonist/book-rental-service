<?php

namespace App\Mail;

use App\Models\Rent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OverdueRentalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $rental;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Rent $rental)
    {
        $this->rental = $rental;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Rental is Overdue')
                    ->view('emails.overdue_notification');
    }
}
