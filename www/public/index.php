<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

$routes = require __DIR__ . '/../routes/web.php';

$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
if ($path !== '/') {
	$path = rtrim($path, '/');
	if ($path === '') {
		$path = '/';
	}
}

$handler = $routes[$method][$path] ?? null;
$params = [];

if ($handler === null) {
	foreach ($routes[$method] ?? [] as $route => $routeHandler) {
		if (strpos($route, '{') === false) {
			continue;
		}

		$pattern = preg_replace('/\{[^\/]+\}/', '([^\/]+)', $route);
		$pattern = '#^' . $pattern . '$#';

		if (preg_match($pattern, $path, $matches)) {
			$handler = $routeHandler;
			$params = array_values(array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY));
			if ($params === []) {
				$params = array_slice($matches, 1);
			}
			break;
		}
	}
}

if ($handler === null) {
	if ($path === '/') {
		http_response_code(200);
		echo '<!doctype html>';
		echo '<html lang="fr">';
		echo '<head><meta charset="utf-8"><title>CMS MVC</title>';
		echo '<link rel="stylesheet" href="/css/main.css"></head>';
		echo '<body class="theme-contrast">';
		$isLoggedIn = !empty($_SESSION['user_id']);
		ob_start();
		require __DIR__ . '/../app/views/partials/header.php';
		echo ob_get_clean();
		echo '<main class="layout-container">';
		echo '<section class="layout-hero">';
		echo '<h1>CMS MVC - Editorial</h1>';
		echo '<p>Un espace sobre pour gerer et publier vos contenus.</p>';
		echo '<div>'; 
		echo '<a class="button button--primary" href="/pages">Explorer les pages</a> ';
		echo '<a class="button" href="/styleguide">Voir le design guide</a>';
		echo '</div>';
		echo '</section>';
		echo '<section class="card">';
		echo '<h2>Pourquoi ce CMS ?</h2>';
		echo '<p>Gestion simple des pages, roles clairs, interface legere pour un projet scolaire.</p>';
		echo '</section>';
		echo '</main>';
		echo '<script src="/js/app.js"></script>';
		echo '</body></html>';
		exit;
	}

	http_response_code(404);
	echo '<!doctype html>';
	echo '<html lang="fr">';
	echo '<head><meta charset="utf-8"><title>404</title></head>';
	echo '<body><h1>404 - Page introuvable</h1></body></html>';
	exit;
}

if (is_callable($handler)) {
	$result = $handler(...$params);
	if (is_string($result)) {
		echo $result;
	}
	exit;
}

if (is_string($handler) && is_file($handler)) {
	require $handler;
	exit;
}

http_response_code(500);
echo '<!doctype html><html lang="fr"><head><meta charset="utf-8"><title>Erreur</title></head>';
echo '<body><h1>Erreur de routeur</h1></body></html>';
