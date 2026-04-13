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
    <h1>Inscription</h1>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="/register">
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirm">Confirmer le mot de passe</label>
        <input type="password" id="password_confirm" name="password_confirm" required>

        <button type="submit">S'inscrire</button>
    </form>

    <p><a href="/login">J'ai deja un compte</a></p>
</body>
</html>
