<?php

namespace App\Notifications;

use Spatie\Backup\Notifications\Notifiable as SpatieNotifiable;

class Notifiable extends SpatieNotifiable
{
    public function routeNotificationForMail(): array
    {
        return [];
    }
}
