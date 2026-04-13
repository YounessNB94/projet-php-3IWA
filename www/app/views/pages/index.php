<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_id']);
$pages = $pages ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Pages</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="theme-contrast">
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <main class="layout-container">
        <h1>Pages</h1>

    <p><a href="/pages/create">Creer une page</a></p>

    <?php if (empty($pages)) : ?>
        <p>Aucune page.</p>
    <?php else : ?>
        <section class="card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Slug</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $page) : ?>
                        <tr>
                            <td><?= htmlspecialchars($page['title'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($page['slug'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($page['status'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <a class="button" href="/pages/edit/<?= (int)$page['id'] ?>">Editer</a>
                                <form method="post" action="/pages/delete/<?= (int)$page['id'] ?>" style="display:inline">
                                    <button class="button button--danger" type="submit" onclick="return confirm('Supprimer cette page ?')">Supprimer</button>
                                </form>
                                <?php if ($page['status'] === 'published') : ?>
                                    <a class="button" href="/page/<?= htmlspecialchars($page['slug'], ENT_QUOTES, 'UTF-8') ?>" target="_blank">Voir</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php endif; ?>
    </main>
    <script src="/js/app.js"></script>
</body>
</html>
