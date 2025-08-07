<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\LowStockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class LowStockNotificationListener
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $supposedAdminEmail = User::where('email', 'admin@app.com')->first()->email;

        Notification::route('mail', $supposedAdminEmail)
            ->notify(new LowStockNotification($event->item, $event->quantity));
    }
}
