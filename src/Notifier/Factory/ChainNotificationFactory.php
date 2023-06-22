<?php

namespace App\Notifier\Factory;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Notifier\Notification\Notification;

class ChainNotificationFactory implements NotificationFactoryInterface
{
    /** @var NotificationFactoryInterface[] $factories */
    private readonly iterable $factories;

    public function __construct(
        #[TaggedIterator(tag: 'app.notification_factory', defaultIndexMethod: 'getIndex')]
        iterable $factories
    ) {
        $this->factories = $factories instanceof \Traversable ? iterator_to_array($factories) : $factories;
    }

    public function createNotification(string $subject, string $platform = ''): Notification
    {
        if ('' === $platform) {
            throw new \InvalidArgumentException();
        }

        return $this->factories[$platform]->createNotification($subject);
    }
}
