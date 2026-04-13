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
    <title>Styleguide UI</title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body class="theme-contrast">
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="layout-container" style="display:grid; gap: var(--space-5);">
        <section class="layout-hero">
            <h1>Bibliotheque de composants</h1>
            <p>Contexte metier : CMS editorial, chaleureux, artisanal, avec une touche magazine.</p>
        </section>

        <section class="card">
            <h2>Typographie</h2>
            <p>Texte courant avec hierarchie claire.</p>
            <h3>Titre secondaire</h3>
            <p class="muted">Texte plus discret.</p>
        </section>

        <section class="card">
            <h2>Formulaires</h2>
            <label>Champ texte</label>
            <input type="text" class="input" placeholder="Ex: Nom de page">
            <label>Selection</label>
            <select class="select">
                <option>Publie</option>
                <option>Brouillon</option>
            </select>
            <div>
                <button class="button button--primary">Action principale</button>
                <button class="button">Action secondaire</button>
            </div>
        </section>

        <section class="card">
            <h2>Cartes / Conteneurs</h2>
            <div class="card">
                <h3>Carte article</h3>
                <p>Exemple de contenu editorial.</p>
            </div>
        </section>

        <section class="card">
            <h2>Navigation</h2>
            <div class="breadcrumbs">
                <span>Accueil</span> / <span>Pages</span> / <span>Detail</span>
            </div>
            <div class="pagination">
                <a href="#">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
            </div>
        </section>

        <section class="card">
            <h2>Alertes & Modale</h2>
            <div class="alert alert--success">Succes: action effectuee.</div>
            <div class="alert alert--error">Erreur: veuillez verifier.</div>
            <button class="button" data-toggle="demo-modal">Ouvrir modale</button>
            <div id="demo-modal" class="modal">
                <div class="modal__content">
                    <h3>Modale</h3>
                    <p>Exemple de modale simple.</p>
                    <button class="button" data-toggle="demo-modal">Fermer</button>
                </div>
            </div>
        </section>

        <section class="card">
            <h2>Accordeon</h2>
            <div class="accordion">
                <div class="accordion__header" data-accordion="panel-1">Section 1</div>
                <div id="panel-1" class="accordion__panel">
                    <p>Contenu de la section 1.</p>
                </div>
            </div>
        </section>
    </main>

    <script src="/js/app.js"></script>
</body>
</html>
