<?php

declare(strict_types=1);

class AuthMiddleware
{
    public static function ensureAuthenticated(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
