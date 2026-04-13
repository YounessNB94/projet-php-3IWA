<?php

declare(strict_types=1);

$page = $page ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page['title'] ?? 'Page', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <article>
        <h1><?= htmlspecialchars($page['title'] ?? '', ENT_QUOTES, 'UTF-8') ?></h1>
        <div>
            <?= nl2br(htmlspecialchars($page['content'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
        </div>
    </article>
</body>
</html>
