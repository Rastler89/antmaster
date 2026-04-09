<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class WebPushHelper {
    public static function send($userId, $title, $body, $url = '') {
        require_once __DIR__ . '/../Models/PushSubscription.php';
        $subscriptions = PushSubscription::getForUser($userId);
        
        if (empty($subscriptions)) return false;

        $auth = [
            'VAPID' => [
                'subject' => 'mailto:admin@antmaster.pro',
                'publicKey' => VAPID_PUBLIC_KEY,
                'privateKey' => VAPID_PRIVATE_KEY,
            ],
        ];

        $webPush = new WebPush($auth);
        $payload = json_encode([
            'title' => $title,
            'body' => $body,
            'url' => $url ?: BASE_URL . '/dashboard'
        ]);

        foreach ($subscriptions as $sub) {
            $webPush->queueNotification(
                Subscription::create([
                    'endpoint' => $sub['endpoint'],
                    'publicKey' => $sub['p256dh'],
                    'authToken' => $sub['auth'],
                ]),
                $payload
            );
        }

        foreach ($webPush->flush() as $report) {
            $endpoint = $report->getEndpoint();
            if (!$report->isSuccess()) {
                // Si falla (ej: sub expirada), podríamos borrarla
                if ($report->isSubscriptionExpired()) {
                    PushSubscription::db()->prepare("DELETE FROM user_push_subscriptions WHERE endpoint = ?")->execute([$endpoint]);
                }
            }
        }
        
        return true;
    }
}
