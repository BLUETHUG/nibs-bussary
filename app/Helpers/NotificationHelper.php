<?php
declare(strict_types=1);

namespace App\Helpers;

class NotificationHelper
{
    /**
     * Send a notification via all enabled channels.
     * Falls back gracefully if a channel is not configured.
     */
    public static function send(int $userId, string $title, string $message, array $channels = ['database']): void
    {
        if (in_array('database', $channels)) {
            self::storeDatabase($userId, $title, $message);
        }
        if (in_array('email', $channels)) {
            self::sendEmail($userId, $title, $message);
        }
        if (in_array('sms', $channels)) {
            self::sendSms($userId, $message);
        }
    }

    /**
     * Store notification in the local database.
     */
    public static function storeDatabase(int $userId, string $title, string $message): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO notifications (user_id, title, message) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $title, $message]);
    }

    /**
     * Send email notification using PHP mail() or SMTP.
     * Configure SMTP settings in config/app.php under 'mail'.
     */
    public static function sendEmail(int $userId, string $subject, string $body): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT email, full_name FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        if (!$user) return;

        $to      = $user['email'];
        $headers = "From: NIBS Bursary Portal <noreply@nibs.ac.ke>\r\n";
        $headers .= "Reply-To: support@nibs.ac.ke\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $htmlBody = <<<HTML
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
body { font-family: 'Inter', Arial, sans-serif; background: #f4f4f8; padding: 24px; }
.container { max-width: 560px; margin: 0 auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
.header { background: linear-gradient(135deg, #4f46e5, #7c3aed); padding: 24px; text-align: center; }
.header h1 { color: #fff; margin: 0; font-size: 1.2rem; }
.body { padding: 24px; color: #1a1a2e; font-size: 0.9rem; line-height: 1.6; }
.footer { padding: 16px 24px; background: #f8f9ff; text-align: center; font-size: 0.78rem; color: #94a3b8; }
</style></head><body>
<div class="container">
    <div class="header"><h1>NIBS Bursary Portal</h1></div>
    <div class="body">
        <p>Dear {$user['full_name']},</p>
        {$body}
        <p style="margin-top:20px;color:#94a3b8;font-size:0.8rem;">If you have any questions, contact support@nibs.ac.ke or call +254 111 030 100.</p>
    </div>
    <div class="footer">&copy; NIBS Technical College &mdash; Bursary Management System</div>
</div>
</body></html>
HTML;

        @mail($to, $subject, $htmlBody, $headers);
    }

    /**
     * Send SMS via Africa's Talking API.
     * Requires API key and username in config/app.php under 'sms.africastalking'.
     */
    public static function sendSms(int $userId, string $message): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT phone FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        if (!$user || empty($user['phone'])) return;

        $phone   = $user['phone'];
        $apiKey  = defined('AT_API_KEY') ? AT_API_KEY : '';
        $username = defined('AT_USERNAME') ? AT_USERNAME : 'sandbox';

        if (empty($apiKey)) return;

        $postData = [
            'username' => $username,
            'to'       => $phone,
            'message'  => $message,
            'from'     => 'NIBS-BUR',
        ];

        $ch = curl_init('https://api.africastalking.com/version1/messaging');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($postData),
            CURLOPT_HTTPHEADER     => ['ApiKey: ' . $apiKey, 'Accept: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        curl_exec($ch);
        curl_close($ch);
    }

    /**
     * Send a bulk notification to all users with a given role.
     */
    public static function broadcast(string $role, string $title, string $message, array $channels = ['database']): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT id FROM users WHERE role = ? AND is_active = 1");
        $stmt->execute([$role]);
        $users = $stmt->fetchAll();

        foreach ($users as $user) {
            self::send((int)$user['id'], $title, $message, $channels);
        }
    }

    /**
     * Mark a notification as read.
     */
    public static function markRead(int $notificationId, int $userId): void
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
        $stmt->execute([$notificationId, $userId]);
    }

    /**
     * Get unread notification count for a user.
     */
    public static function unreadCount(int $userId): int
    {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn();
    }
}
