<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class sendPurchaseCompletedMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($price_include_tax,$order_date,$zipcode,$address,$payment_method)
    {
        $this->price_include_tax = $price_include_tax;
        $this->order_date = $order_date;
        $this->zipcode = $zipcode;
        $this->address = $address;
        $this->payment_method = $payment_method;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('商品の購入が完了しました')
                    ->line('購入金額: '.$this->price_include_tax)
                    ->line('購入確定日時: '.$this->order_date)
                    ->line('配送場所: '.$this->address)
                    ->line('支払方法: '.$this->payment_method)
                    ->line('Thank you for using our application!')
                    ->action('サイトトップに戻る', url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
