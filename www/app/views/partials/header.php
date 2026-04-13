<?php

declare(strict_types=1);

$isLoggedIn = $isLoggedIn ?? false;
?>

<header class="nav-shell">
    <div class="layout-container">
        <nav class="nav" aria-label="Navigation principale">
            <button class="nav__toggle" type="button" data-nav-toggle aria-expanded="false" aria-label="Ouvrir le menu">
                <span class="nav__icon" aria-hidden="true">&#9776;</span>
            </button>
            <div class="nav__panel" data-nav-panel>
                <div class="nav__links">
                    <a href="/">Accueil</a>
                    <a href="/pages">Pages</a>
                    <a href="/admin">Admin</a>
                    <a href="/styleguide">Styleguide</a>
                </div>
                <div class="nav__right">
                    <label class="theme-switch" aria-label="Basculer mode sombre">
                        <span class="theme-switch__icon">&#9728;</span>
                        <input class="theme-switch__input" type="checkbox" data-theme-toggle>
                        <span class="theme-switch__slider"></span>
                        <span class="theme-switch__icon">&#9790;</span>
                    </label>
                    <div class="nav__auth">
                        <?php if ($isLoggedIn) : ?>
                            <a href="/logout">Deconnexion</a>
                            <span class="nav__status nav__status--online" aria-label="Connecte"></span>
                        <?php else : ?>
                            <a href="/login">Connexion</a>
                            <a href="/register">Inscription</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
