<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Role.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

return [
    'GET' => [
        '/login' => function (): void {
            (new AuthController())->showLogin();
        },
        '/register' => function (): void {
            (new AuthController())->showRegister();
        },
        '/logout' => function (): void {
            (new AuthController())->logout();
        },
    ],
    'POST' => [
        '/login' => function (): void {
            (new AuthController())->login();
        },
        '/register' => function (): void {
            (new AuthController())->register();
        },
    ],
];
