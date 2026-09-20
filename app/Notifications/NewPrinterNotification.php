<?php

namespace App\Notifications;

use App\Models\Printer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPrinterNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Printer $printer)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Новый принтер: ' . $this->printer->brand . ' ' . $this->printer->model)
            ->greeting('Новая новинка! 🖨️')
            ->line('В каталог добавлен новый принтер.')
            ->line('Модель: ' . $this->printer->brand . ' ' . $this->printer->model)
            ->line('Цена: ' . number_format($this->printer->price, 0, ',', ' ') . ' ₽')
            ->line('Пробег: ' . $this->printer->pages_printed)
            ->line('Состояние: ' . $this->printer->state)
            ->action('Посмотреть принтер', route('printers.show', $this->printer->id))
            ->line('Не упустите новинку!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
