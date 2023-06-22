<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\DiscordNotification;
use Symfony\Component\Notifier\Notification\Notification;

class DiscordNotificationFactory implements NotificationFactoryInterface, IterableNotificationFactoryInterface
{

    public function createNotification(string $subject): Notification
    {
        return new DiscordNotification($subject);
    }

    public static function getIndex(): string
    {
        return 'discord';
    }
}
