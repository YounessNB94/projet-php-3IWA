git<?php

declare(strict_types=1);

$router->get('/pages', [PageController::class, 'index']);
$router->get('/pages/create', [PageController::class, 'create']);
$router->post('/pages/store', [PageController::class, 'store']);

$router->get('/pages/edit/{id}', [PageController::class, 'edit']);
$router->post('/pages/update/{id}', [PageController::class, 'update']);
$router->post('/pages/delete/{id}', [PageController::class, 'delete']);

$router->get('/page/{slug}', [PageController::class, 'showBySlug']);
