<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/models/Database.php';
require_once __DIR__ . '/../app/models/Page.php';
require_once __DIR__ . '/../app/controllers/PageController.php';

return [
	'GET' => [
		'/pages' => function (): void {
			(new PageController())->index();
		},
		'/pages/create' => function (): void {
			(new PageController())->create();
		},
		'/pages/edit/{id}' => function (string $id): void {
			(new PageController())->edit((int)$id);
		},
		'/page/{slug}' => function (string $slug): void {
			(new PageController())->showBySlug($slug);
		},
	],
	'POST' => [
		'/pages/store' => function (): void {
			(new PageController())->store();
		},
		'/pages/update/{id}' => function (string $id): void {
			(new PageController())->update((int)$id);
		},
		'/pages/delete/{id}' => function (string $id): void {
			(new PageController())->delete((int)$id);
		},
	],
];
