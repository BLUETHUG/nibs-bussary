<?php
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

    public static function validatePassword(string $password): array {
        $errors = [];
        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters.';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }
        if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
            $errors[] = 'Password must contain at least one special character.';
        }
        return $errors;
    }
}
