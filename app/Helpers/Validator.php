<?php
// app/Helpers/Validator.php
declare(strict_types=1);

namespace App\Helpers;

class Validator {
    public static function clean(string $data): string {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    public static function validateEmail(string $email): bool {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validateRequired(array $data, array $fields): array {
        $errors = [];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('_', ' ', $field)) . " is required.";
            }
        }
        return $errors;
    }
}
