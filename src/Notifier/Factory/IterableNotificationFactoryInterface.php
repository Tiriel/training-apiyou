<?php

namespace App\Notifier\Factory;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.notification_factory')]
interface IterableNotificationFactoryInterface
{
    public static function getIndex(): string;
}
