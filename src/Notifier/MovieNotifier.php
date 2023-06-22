<?php

namespace App\Notifier;

use App\Notifier\Factory\ChainNotificationFactory;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;

class MovieNotifier
{
    public function __construct(
        private readonly NotifierInterface $notifier,
        private readonly ChainNotificationFactory $factory,
    ) {}

    public function sendNotification(string $message)
    {
        $user = new class () {
            public function getPlatform(): string {
                return 'slack';
            }
        };

        $notification = $this->factory->createNotification($message, $user->getPlatform());

        $this->notifier->send($notification, new Recipient());
    }
}
