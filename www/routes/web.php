<?php

declare(strict_types=1);

$authRoutes = require __DIR__ . '/auth.php';
$pagesRoutes = require __DIR__ . '/pages.php';
$adminRoutes = require __DIR__ . '/admin.php';

return array_replace_recursive(
	[
		'GET' => [],
		'POST' => [],
	],
	$authRoutes,
	$pagesRoutes,
	$adminRoutes
);
