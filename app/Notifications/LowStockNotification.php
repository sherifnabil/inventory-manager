<?php

namespace App\Notifications;

use App\Models\InventoryItem;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param \App\Models\InventoryItem $item
     * @param int $quantity
     */
    public function __construct(
        public InventoryItem $item,
        public int $quantity
    ) {}

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
            ->subject('Low Stock Alert')
            ->line("The stock for the item {$this->item->name} is running low.")
            ->line("Only {$this->quantity} items left in stock.");
    }
}
