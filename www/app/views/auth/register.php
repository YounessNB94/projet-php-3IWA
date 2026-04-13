<?php

declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$isLoggedIn = !empty($_SESSION['user_id']);
$errors = $errors ?? [];
$old = $old ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="theme-contrast">
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <main class="layout-container">
        <section class="form-card">
            <h1>Inscription</h1>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

        <form method="post" action="/register" class="form">
            <label for="name">Nom</label>
            <input class="input" type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="email">Email</label>
            <input class="input" type="email" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

            <label for="password">Mot de passe</label>
            <input class="input" type="password" id="password" name="password" required>

            <label for="password_confirm">Confirmer le mot de passe</label>
            <input class="input" type="password" id="password_confirm" name="password_confirm" required>

            <button class="button button--primary" type="submit">S'inscrire</button>
        </form>

        <p><a href="/login">J'ai deja un compte</a></p>
        </section>
    </main>
    <script src="/js/app.js"></script>
</body>
</html>
