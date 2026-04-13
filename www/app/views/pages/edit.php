<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_id']);
$errors = $errors ?? [];
$page = $page ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une page</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="theme-contrast">
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <main class="layout-container">
        <h1>Modifier une page</h1>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="/pages/update/<?= (int)($page['id'] ?? 0) ?>">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($page['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="content">Contenu</label>
        <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($page['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

        <label for="status">Statut</label>
        <select id="status" name="status">
            <option value="draft" <?= ($page['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Brouillon</option>
            <option value="published" <?= ($page['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publiee</option>
        </select>

        <button type="submit">Mettre a jour</button>
    </form>

        <p><a href="/pages">Retour</a></p>
    </main>
    <script src="/js/app.js"></script>
</body>
</html>
