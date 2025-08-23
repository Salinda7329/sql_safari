<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class BadgeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $achievement;

    public function __construct($user, $achievement)
    {
        $this->user = $user;
        $this->achievement = $achievement;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.badge', [
            'user' => $this->user,
            'achievement' => $this->achievement,
        ]);

        return $this->subject("Your Badge: {$this->achievement->name}")
            ->view('emails.badge') 
            ->with([
                'user' => $this->user,
                'achievement' => $this->achievement,
            ])
            ->attachData(
                $pdf->output(),
                "badge-{$this->achievement->id}.pdf",
                ['mime' => 'application/pdf']
            );
    }
}
