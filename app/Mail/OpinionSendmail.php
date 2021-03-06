<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OpinionSendmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $opinion;

    public function __construct($opinion)
    {
        $this->opinion = $opinion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('rehamenu.official@gmail.com')
            ->subject('自動送信メール')
            ->view('emails.opinion_email')
            ->with([
                'opinion' => $this->opinion
            ]);
    }
}
