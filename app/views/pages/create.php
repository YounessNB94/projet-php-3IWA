<?php

declare(strict_types=1);

$errors = $errors ?? [];
$old = $old ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Creer une page</title>
</head>
<body>
    <h1>Creer une page</h1>

    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="/pages/store">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($old['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>

        <label for="content">Contenu</label>
        <textarea id="content" name="content" rows="10" required><?= htmlspecialchars($old['content'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

        <label for="status">Statut</label>
        <select id="status" name="status">
            <option value="draft" <?= ($old['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Brouillon</option>
            <option value="published" <?= ($old['status'] ?? '') === 'published' ? 'selected' : '' ?>>Publiee</option>
        </select>

        <button type="submit">Enregistrer</button>
    </form>

    <p><a href="/pages">Retour</a></p>
</body>
</html>
