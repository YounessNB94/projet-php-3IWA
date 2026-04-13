<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Admin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="theme-contrast">
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="layout-container">
        <section class="layout-hero">
            <h1>Dashboard Admin</h1>
            <p>Bienvenue, <?= htmlspecialchars($userName, ENT_QUOTES, 'UTF-8') ?>.</p>
        </section>

        <section class="card">
            <h2>Actions rapides</h2>
            <div>
                <a class="button button--primary" href="/pages">Gerer les pages</a>
                <a class="button" href="/admin/pages">Tableau pages</a>
                <a class="button" href="/admin/users">Tableau utilisateurs</a>
                <a class="button" href="/logout">Deconnexion</a>
            </div>
        </section>
    </main>
    <script src="/js/app.js"></script>
</body>
</html>
