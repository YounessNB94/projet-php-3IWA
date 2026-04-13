<?php

declare(strict_types=1);

class RoleMiddleware
{
    public static function ensureRole(array $allowedRoles): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $role = $_SESSION['user_role'] ?? null;
        if ($role === null || !in_array($role, $allowedRoles, true)) {
            http_response_code(403);
            echo 'Acces interdit.';
            exit;
        }
    }
}
