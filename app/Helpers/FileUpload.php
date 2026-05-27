<?php
declare(strict_types=1);

namespace App\Helpers;

class FileUpload
{
    /**
     * Securely handle a file upload.
     *
     * @param string $fieldName      The name attribute of the input field.
     * @param string $targetDir      Destination directory (must be absolute and writable).
     * @param int    $maxSizeBytes   Maximum allowed size (default 5MB).
     * @param array  $allowedMimes   Array of allowed MIME types.
     * @return string                The new filename relative to $targetDir.
     * @throws \Exception           If validation fails.
     */
    public static function upload(string $fieldName, string $targetDir, int $maxSizeBytes = 5242880, array $allowedMimes = ['application/pdf', 'image/jpeg', 'image/png']): string
    {
        if (!isset($_FILES[$fieldName])) {
            throw new \Exception('No file uploaded.');
        }
        $file = $_FILES[$fieldName];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Upload error code: ' . $file['error']);
        }
        if ($file['size'] > $maxSizeBytes) {
            throw new \Exception('File exceeds maximum allowed size.');
        }
        // Validate MIME using finfo
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!in_array($mime, $allowedMimes, true)) {
            throw new \Exception('Invalid file type: ' . $mime);
        }
        // Generate unique filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newName = bin2hex(random_bytes(16)) . '.' . $ext;
        $destPath = rtrim($targetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $newName;
        if (!move_uploaded_file($file['tmp_name'], $destPath)) {
            throw new \Exception('Failed to move uploaded file.');
        }
        // Set restrictive permissions
        chmod($destPath, 0640);
        return $newName;
    }
}
?>
