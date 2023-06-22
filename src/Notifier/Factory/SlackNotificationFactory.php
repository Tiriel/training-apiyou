<?php

namespace App\Notifier\Factory;

use App\Notifier\Notification\SlackNotification;
use Symfony\Component\Notifier\Notification\Notification;

class SlackNotificationFactory implements NotificationFactoryInterface, IterableNotificationFactoryInterface
{

    public function createNotification(string $subject): Notification
    {
        return new SlackNotification($subject);
    }

    public static function getIndex(): string
    {
        return 'slack';
    }
}
