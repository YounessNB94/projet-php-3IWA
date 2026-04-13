<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/middleware/AuthMiddleware.php';
require_once __DIR__ . '/../app/middleware/RoleMiddleware.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

return [
	'GET' => [
		'/admin' => function (): void {
			AuthMiddleware::ensureAuthenticated();
			RoleMiddleware::ensureRole(['admin']);
			(new AdminController())->dashboard();
		},
		'/admin/pages' => function (): void {
			AuthMiddleware::ensureAuthenticated();
			RoleMiddleware::ensureRole(['admin']);
			require __DIR__ . '/../app/views/admin/pages.php';
		},
		'/admin/users' => function (): void {
			AuthMiddleware::ensureAuthenticated();
			RoleMiddleware::ensureRole(['admin']);
			require __DIR__ . '/../app/views/admin/users.php';
		},
	],
	'POST' => [],
];
