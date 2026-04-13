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
</head>
<body>
    <nav>
        <a href="/">Accueil</a> |
        <a href="/pages">Pages</a> |
        <a href="/admin">Admin</a>
        <?php if ($isLoggedIn) : ?>
            | <a href="/logout">Deconnexion</a>
            <span style="float:right;">Connecte</span>
        <?php else : ?>
            | <a href="/login">Connexion</a>
            | <a href="/register">Inscription</a>
        <?php endif; ?>
    </nav>
    <hr>
    <h1>Pages</h1>

    <p><a href="/pages/create">Creer une page</a></p>

    <?php if (empty($pages)) : ?>
        <p>Aucune page.</p>
    <?php else : ?>
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
                <?php foreach ($pages as $page) : ?>
                    <tr>
                        <td><?= htmlspecialchars($page['title'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($page['slug'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($page['status'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="/pages/edit/<?= (int)$page['id'] ?>">Modifier</a>
                            <form method="post" action="/pages/delete/<?= (int)$page['id'] ?>" style="display:inline">
                                <button type="submit" onclick="return confirm('Supprimer cette page ?')">Supprimer</button>
                            </form>
                            <?php if ($page['status'] === 'published') : ?>
                                <a href="/page/<?= htmlspecialchars($page['slug'], ENT_QUOTES, 'UTF-8') ?>" target="_blank">Voir</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
