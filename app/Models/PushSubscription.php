<?php
require_once '../core/Model.php';

class PushSubscription extends Model {
    protected static $table = 'user_push_subscriptions';

    public static function getForUser($userId) {
        return self::where('usuario_id', '=', $userId);
    }

    public static function subscribe($userId, $data) {
        // Evitar duplicados por endpoint
        $exists = self::db()->prepare("SELECT id FROM " . static::$table . " WHERE endpoint = ?");
        $exists->execute([$data['endpoint']]);
        if ($exists->fetch()) {
            return true; 
        }

        return self::create([
            'usuario_id' => $userId,
            'endpoint'   => $data['endpoint'],
            'p256dh'     => $data['keys']['p256dh'],
            'auth'       => $data['keys']['auth']
        ]);
    }
}
