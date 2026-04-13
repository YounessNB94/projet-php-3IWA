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
    <title>Connexion</title>
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
    <h1>Connexion</h1>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="/login">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <p><a href="/register">Creer un compte</a></p>
</body>
</html>
