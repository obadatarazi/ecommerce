<?php

namespace App\Helpers;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\MulticastSendReport;

class FirebaseHelpers
{
    private Messaging $messaging;
    public function __construct(Messaging $messaging)
    {
        $this->messaging = $messaging;
    }

    protected function createNotification(string $title , string $body): Notification
    {
        return Notification::create($title,$body);
    }

    /**
     * @throws FirebaseException
     */
    public function broadcast(string $title, string $body, $metaData = null): array
    {
        $notification = $this->createNotification($title, $body);
        $message = CloudMessage::new()
            ->toTopic('all')
            ->withNotification($notification)
            ->withData($metaData);
        return $this->sendNotification($message);
    }

    /**
     * @throws FirebaseException
     */
    public function multicast($tokens, string $title, string $body, $metaData = null): MulticastSendReport
    {
        $notification = $this->createNotification($title,$body);
        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($metaData);
        return $this->messaging->sendMulticast($message,$tokens);
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    private function sendNotification($message): array
    {
        return $this->messaging->send($message);
    }

    /**
     * @throws MessagingException
     * @throws FirebaseException
     */
    public function sendBroadcastNotification($title, $body): array
    {
        $notification = $this->createNotification($title, $body);
        $message = CloudMessage::new()
            ->toTopic('all')
            ->withNotification($notification);

        return $this->sendNotification($message);
    }
}
