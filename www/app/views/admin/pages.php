<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pages</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="theme-contrast">
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="layout-container">
        <section class="layout-hero">
            <h1>Gestion des pages</h1>
            <p>Vue admin statique (exemple de tableau).</p>
        </section>

        <section class="card">
            <table>
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Slug</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Page demo</td>
                        <td>page-demo</td>
                        <td>published</td>
                        <td>
                            <button class="button">Editer</button>
                            <button class="button button--danger">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
    <script src="/js/app.js"></script>
</body>
</html>
