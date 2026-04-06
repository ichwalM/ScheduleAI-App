<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;

class DailyScheduleReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $items;
    public $day;

    /**
     * Create a new message instance.
     */
    public function __construct($user, Collection $items, string $day)
    {
        $this->user = $user;
        $this->items = $items;
        $this->day = $day;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Jadwal Kamu Hari Ini: ' . ucfirst(strtolower($this->day)),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.daily-reminder',
            with: [
                'user'  => $this->user,
                'items' => $this->items,
                'day'   => $this->day,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
