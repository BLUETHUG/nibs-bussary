<?php
declare(strict_types=1);

namespace App\Helpers;

class CloudinaryUpload
{
    private static string $cloudName = '';
    private static string $apiKey = '';
    private static string $apiSecret = '';
    private static string $uploadPreset = '';

    /**
     * Initialize with credentials from config or environment.
     * Call once at bootstrap: CloudinaryUpload::init($config);
     */
    public static function init(array $config): void
    {
        self::$cloudName    = $config['cloud_name'] ?? '';
        self::$apiKey       = $config['api_key'] ?? '';
        self::$apiSecret    = $config['api_secret'] ?? '';
        self::$uploadPreset = $config['upload_preset'] ?? '';
    }

    /**
     * Check if Cloudinary is configured.
     */
    public static function isConfigured(): bool
    {
        return !empty(self::$cloudName) && !empty(self::$apiKey) && !empty(self::$apiSecret);
    }

    /**
     * Upload a file to Cloudinary.
     *
     * @param string $filePath  Absolute path to the file on disk.
     * @param array  $options   Optional transformations (folder, public_id, etc.)
     * @return array{url: string, public_id: string}|null
     */
    public static function upload(string $filePath, array $options = []): ?array
    {
        if (!self::isConfigured() || !file_exists($filePath)) {
            return null;
        }

        $timestamp = time();
        $folder    = $options['folder'] ?? 'nibs-bursary/documents';
        $publicId  = $options['public_id'] ?? bin2hex(random_bytes(16));

        $params = [
            'timestamp'     => $timestamp,
            'folder'        => $folder,
            'public_id'     => $publicId,
            'resource_type' => 'auto',
        ];

        // Generate signature
        $signature = self::sign($params);

        $params['api_key'] = self::$apiKey;
        $params['signature'] = $signature;

        $ch = curl_init();
        $postData = $params;
        $postData['file'] = new \CURLFile($filePath);

        curl_setopt_array($ch, [
            CURLOPT_URL            => 'https://api.cloudinary.com/v1_1/' . self::$cloudName . '/auto/upload',
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) return null;

        $data = json_decode($response, true);
        if (!isset($data['secure_url'])) return null;

        return [
            'url'       => $data['secure_url'],
            'public_id' => $data['public_id'] ?? $publicId,
        ];
    }

    /**
     * Delete a file from Cloudinary by public_id.
     */
    public static function delete(string $publicId): bool
    {
        if (!self::isConfigured()) return false;

        $timestamp = time();
        $params = [
            'timestamp'  => $timestamp,
            'public_id'  => $publicId,
        ];

        $signature = self::sign($params);
        $params['api_key'] = self::$apiKey;
        $params['signature'] = $signature;

        $ch = curl_init('https://api.cloudinary.com/v1_1/' . self::$cloudName . '/image/destroy');
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        return ($data['result'] ?? '') === 'ok';
    }

    /**
     * Generate an SHA-1 signature for Cloudinary API calls.
     */
    private static function sign(array $params): string
    {
        ksort($params);
        $str = '';
        foreach ($params as $key => $value) {
            $str .= $key . '=' . $value . '&';
        }
        $str = rtrim($str, '&');
        return sha1($str . self::$apiSecret);
    }
}
