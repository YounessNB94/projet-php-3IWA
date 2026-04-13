<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_id']);
$page = $page ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page['title'] ?? 'Page', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="theme-contrast">
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <main class="layout-container">
        <article class="card">
            <h1><?= htmlspecialchars($page['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h1>
            <div>
                <?= nl2br(htmlspecialchars($page['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
            </div>
        </article>
    </main>
    <script src="/js/app.js"></script>
</body>
</html>
