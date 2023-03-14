<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$price_include_tax,$order_date,$zipcode,$address,$payment_method)
    {
        $this->name = $name;
        $this->price_include_tax = $price_include_tax;
        $this->order_date = $order_date;
        $this->zipcode = $zipcode;
        $this->address = $address;
        $this->payment_method = $payment_method;

    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Test Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'testMail',
            with: [
                'greeting' => '商品の購入が完了しました',
                'name' => $this->name,
                'price_include_tax' => $this->price_include_tax,
                'order_date' => $this->order_date,
                'zipcode' => $this->zipcode,
                'address' => $this->address,
                'payment_method' => $this->payment_method
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
