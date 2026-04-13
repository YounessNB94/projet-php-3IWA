# copilot-instruction.md

Tu es un assistant de generation de code pour un projet scolaire en PHP natif oriente MVC.

Je travaille sur un CMS leger en PHP sans framework. Le projet doit respecter une architecture MVC propre, avec separation stricte des responsabilites.

---

## 1. Contexte general du projet

### Objectif

A la fin du projet, les etudiants sauront realiser un CMS (Content Management System) leger en PHP natif permettant de gerer des pages de contenu avec un systeme d'utilisateurs et de droits.

### Contexte general

Le projet doit etre realise en travail collaboratif sur GitLab ou GitHub en public.

Le CMS doit etre developpe en respectant une architecture MVC :

- Models : acces aux donnees
- Views : affichage HTML
- Controllers : logique metier

### Architecture du projet

```txt
/projet-mvc
│
├── docker-compose.yml
├── Dockerfile
├── .env
├── php.ini
├── README.md
│
├── www/
│   ├── index.php
│   │
│   ├── app/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── UserController.php
│   │   │   ├── PageController.php
│   │   │   └── AdminController.php
│   │   │
│   │   ├── Models/
│   │   │   ├── Database.php
│   │   │   ├── User.php
│   │   │   ├── Role.php
│   │   │   └── Page.php
│   │   │
│   │   ├── Views/
│   │   │   ├── auth/
│   │   │   │   ├── login.php
│   │   │   │   └── register.php
│   │   │   │
│   │   │   ├── admin/
│   │   │   └── front/
│   │   │
│   │   ├── Core/
│   │   │   ├── Router.php
│   │   │   ├── Controller.php
│   │   │   ├── Auth.php
│   │   │   └── Security.php
│   │   │
│   │   ├── Middleware/
│   │   │   ├── AuthMiddleware.php
│   │   │   └── RoleMiddleware.php
│   │   │
│   │   └── config/
│   │       ├── database.php
│   │       └── roles.php
│   │
│   ├── public/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   │
│   └── .htaccess
│
└── storage/
    └── logs/
```

## 2. Cahier des charges

### Gestion des utilisateurs et des roles

Le systeme doit gerer plusieurs types d'utilisateurs avec des droits differents :

- Admin : acces complet
- Editeur : gestion des pages uniquement
- Visiteur : acces au frontoffice uniquement

Fonctionnalites a mettre en place :

- inscription
- connexion
- deconnexion
- gestion des utilisateurs (CRUD, accessible a l'admin seulement)
- gestion des roles et des droits
- mot de passe oublie
- activation du compte par mail

### Gestion des pages

Chaque page doit contenir :

- titre
- contenu
- slug (URL)
- statut : publiee / brouillon
- auteur
- date

### Backoffice

Le projet doit contenir un espace d'administration permettant :

- creer une page
- modifier une page
- supprimer une page
- publier / depublier une page

### Frontoffice

Affichage des pages publiees avec une route dynamique de type :

- /page/mon-slug

### Securite minimale

- sessions securisees
- hash des mots de passe avec password_hash
- protection des routes du backoffice
- verification des droits d'acces

### Contraintes techniques obligatoires

- Pattern obligatoire : Singleton
- Un Singleton doit etre implemente pour la connexion a la base de donnees
- Autoloader et namespaces

### Resume des livrables fonctionnels

- gestion des comptes utilisateurs
- gestion des roles et permissions
- authentification complete
- gestion des pages dans le backoffice
- affichage public des pages publiees
- securisation des acces
- architecture MVC propre
- connexion base de donnees centralisee via Singleton

### Technologies imposees

- PHP natif
- Architecture MVC
- GitLab ou GitHub
- Travail collaboratif
- Projet public

## 3. Regles d'architecture

- PHP natif uniquement, sans framework.
- Respect strict du modele MVC.
- index.php est le Front Controller unique.
- Toutes les requetes passent par index.php.
- Database.php doit utiliser le pattern Singleton.
- Les Controllers gerent la logique metier.
- Les Models gerent l'acces aux donnees.
- Les Views contiennent uniquement l'affichage.
- Les Middlewares gerent l'authentification et les roles.
- Le backoffice doit etre protege.
- Le code doit etre simple, pedagogique, lisible et decoupe proprement.
- Eviter le code duplique.
- Utiliser PDO pour la base de donnees.
- Utiliser password_hash() et password_verify() pour les mots de passe.
- Utiliser les sessions PHP pour l'authentification.
- Prevoir une securite minimale : validation des entrees, protection XSS basique via htmlspecialchars, verification des acces, redirections securisees.
- Le code genere doit etre compatible avec une base MySQL.

## 4. Base de donnees

### Schema SQL

```sql
CREATE DATABASE IF NOT EXISTS projet_mvc
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE projet_mvc;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description VARCHAR(255)
);

INSERT INTO roles (name, description) VALUES
('admin', 'Acces complet a l administration'),
('editor', 'Gestion des pages uniquement'),
('visitor', 'Acces au site public uniquement');

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_users_role
        FOREIGN KEY (role_id)
        REFERENCES roles(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    content TEXT NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    status ENUM('published', 'draft') DEFAULT 'draft',
    author_id INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_pages_author
        FOREIGN KEY (author_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
```

## 5. Repartition de l'equipe

Projet realise en groupe de 3. Chaque membre ne doit toucher qu'a son perimetre.

### Fonctionnalite 1 — Authentification & Acces (Personne A)

**Perimetre autorise :**

- Models/User.php
- Models/Role.php
- Controllers/AuthController.php
- Views/auth/*
- routes liees a /login, /register, /logout
- sessions
- hash des mots de passe

**Responsabilites :**

- inscription
- connexion
- deconnexion
- validation des formulaires d'auth
- recuperation des roles utiles a l'auth

### Fonctionnalite 2 — Gestion des pages (CMS) (Personne B)

**Perimetre autorise :**

- Models/Page.php
- Controllers/PageController.php
- Views/pages/*
- Views/front/page.php
- routes de pages
- affichage public par slug

**Responsabilites :**

- CRUD des pages
- generation ou gestion du slug
- affichage public des pages publiees
- routes dynamiques /page/mon-slug

### Fonctionnalite 3 — Administration & Droits (Personne C)

**Perimetre autorise :**

- Models/Permission.php si necessaire
- Controllers/AdminController.php
- Views/admin/*
- Middleware/*
- gestion des acces admin
- gestion des roles et permissions selon le besoin

**Responsabilites :**

- acces restreint par role
- dashboard admin
- securisation des routes admin
- gestion des droits

## 6. Organisation des routes

Les routes sont separees pour eviter les conflits.

**Structure voulue :**

```txt
routes/
├── auth.php
├── pages.php
└── admin.php
```

**Dans routes/web.php :**

- charger auth.php
- charger pages.php
- charger admin.php

**Important :**

- ne jamais melanger les routes des fonctionnalites
- respecter le perimetre de chaque personne

## 7. Style de generation attendu

Quand tu generes du code :

- genere du code complet, executable, coherent avec cette architecture
- n'invente pas de framework
- n'utilise pas Laravel, Symfony ou autre
- reste en PHP oriente objet simple
- respecte les noms de fichiers et dossiers donnes
- privilegie des classes courtes et claires
- ajoute des commentaires utiles mais pas excessifs
- si tu crees une methode, explique brievement son role
- si une vue est generee, elle doit etre simple, fonctionnelle et compatible avec un projet scolaire
- si tu crees des requetes SQL, utilise des requetes preparees PDO
- si un code depend d'un autre fichier, indique precisement le chemin et le contenu attendu
- ne modifie pas le perimetre des autres membres
- si une fonctionnalite n'est pas encore implementee, propose une version minimale et progressive

## 8. Methode de travail pour Copilot

Je veux avancer etape par etape.

Pour chaque demande :

- rappelle brievement l'objectif
- liste les fichiers a creer ou modifier
- genere le code complet
- explique comment tester
- n'implemente pas autre chose que ce qui est demande

Si quelque chose manque, fais l'hypothese la plus simple possible sans casser l'architecture.

Commence toujours par une version minimale fonctionnelle, puis propose une amelioration progressive.

## 9. TODO — Projet CMS PHP MVC

### Objectif du projet

Developper un CMS leger en PHP natif en respectant une architecture MVC propre, avec :

- un Front Controller unique (index.php)
- une connexion base de donnees en Singleton
- une separation claire entre Models / Views / Controllers
- une gestion de l'authentification
- une gestion des pages CMS
- une gestion de l'administration et des droits
- une protection du backoffice
- une organisation de travail claire pour une equipe de 3 personnes

### 1. Mise en place du socle technique commun

**Structure du projet :**

- creer l'arborescence complete du projet
- verifier l'organisation des dossiers Controllers, Models, Views, Core, Middleware, config
- creer le dossier public/ pour les assets
- creer le dossier storage/logs/

**Environnement :**

- configurer docker-compose.yml
- configurer Dockerfile
- configurer .env
- configurer php.ini
- verifier que le conteneur PHP fonctionne
- verifier que MySQL fonctionne
- tester la connexion entre PHP et MySQL

**Base de donnees :**

- creer la base projet_mvc
- creer la table roles
- creer la table users
- creer la table pages
- inserer les roles par defaut : admin, editor, visitor
- tester les cles etrangeres
- verifier que les contraintes SQL fonctionnent correctement

**Noyau MVC :**

- creer www/index.php comme point d'entree unique
- creer app/Core/Router.php
- creer app/Core/Controller.php
- creer app/Models/Database.php en Singleton
- creer app/Core/Auth.php
- creer app/Core/Security.php
- configurer www/.htaccess pour rediriger vers index.php
- tester une route simple
- tester une page 404 minimale

**Routes partagees :**

- creer le dossier routes/ si necessaire
- creer routes/web.php
- creer routes/auth.php
- creer routes/pages.php
- creer routes/admin.php
- verifier que web.php charge correctement les 3 fichiers de routes
- verifier qu'aucune personne ne modifie les routes des autres

### 2. Fonctionnalite 1 — Authentification & Acces (Personne A)

**Perimetre autorise :**

- Models/User.php
- Models/Role.php
- Controllers/AuthController.php
- Views/auth/login.php
- Views/auth/register.php
- routes/auth.php
- gestion des sessions
- hash des mots de passe

**Modele User :**

- creer la classe User
- ajouter une methode pour creer un utilisateur
- ajouter une methode pour trouver un utilisateur par email
- ajouter une methode pour trouver un utilisateur par id
- ajouter une methode pour recuperer le role d'un utilisateur si necessaire
- utiliser uniquement des requetes preparees PDO

**Modele Role :**

- creer la classe Role
- ajouter une methode pour recuperer tous les roles
- ajouter une methode pour recuperer un role par id
- ajouter une methode pour recuperer un role par nom si necessaire

**AuthController :**

- creer la methode showLogin()
- creer la methode showRegister()
- creer la methode register()
- creer la methode login()
- creer la methode logout()
- ajouter la validation des champs du formulaire
- verifier que l'email est unique a l'inscription
- hasher le mot de passe avec password_hash()
- verifier le mot de passe avec password_verify()
- demarrer la session correctement
- stocker les informations utiles de l'utilisateur en session
- rediriger proprement apres connexion
- detruire la session a la deconnexion

**Vues auth :**

- creer la vue login.php
- creer la vue register.php
- ajouter les champs necessaires
- ajouter l'affichage des erreurs
- conserver les anciennes valeurs des champs si necessaire
- securiser l'affichage avec htmlspecialchars()

**Routes auth :**

- ajouter la route GET /login
- ajouter la route POST /login
- ajouter la route GET /register
- ajouter la route POST /register
- ajouter la route /logout

**Tests Auth :**

- tester l'inscription d'un nouvel utilisateur
- tester l'inscription avec email deja existant
- tester la connexion avec bon mot de passe
- tester la connexion avec mauvais mot de passe
- tester la deconnexion
- verifier la session apres connexion
- verifier qu'un utilisateur connecte reste connecte tant que la session existe

### 3. Fonctionnalite 2 — Gestion des pages (CMS) (Personne B)

**Perimetre autorise :**

- Models/Page.php
- Controllers/PageController.php
- Views/pages/index.php
- Views/pages/create.php
- Views/pages/edit.php
- Views/front/page.php
- routes/pages.php
- affichage public par slug

**Modele Page :**

- creer la classe Page
- ajouter une methode pour recuperer toutes les pages
- ajouter une methode pour recuperer une page par id
- ajouter une methode pour recuperer une page par slug
- ajouter une methode pour creer une page
- ajouter une methode pour mettre a jour une page
- ajouter une methode pour supprimer une page
- ajouter une methode pour recuperer uniquement les pages publiees
- utiliser des requetes preparees PDO

**Gestion du slug :**

- definir une methode pour generer un slug propre a partir du titre
- verifier l'unicite du slug
- prevoir une strategie si le slug existe deja
- empecher les caracteres problematiques dans l'URL

**PageController :**

- creer la methode index()
- creer la methode create()
- creer la methode store()
- creer la methode edit()
- creer la methode update()
- creer la methode delete()
- creer la methode showBySlug()
- ajouter la validation des champs
- gerer les erreurs si une page n'existe pas
- filtrer l'affichage public pour ne montrer que les pages published

**Vues pages :**

- creer views/pages/index.php
- creer views/pages/create.php
- creer views/pages/edit.php
- creer views/front/page.php
- afficher la liste des pages
- ajouter le formulaire de creation
- ajouter le formulaire de modification
- afficher le contenu public d'une page
- securiser les sorties avec htmlspecialchars() quand necessaire

**Routes pages :**

- ajouter la route GET /pages
- ajouter la route GET /pages/create
- ajouter la route POST /pages/store
- ajouter la route GET /pages/edit/{id} ou equivalent
- ajouter la route POST /pages/update/{id} ou equivalent
- ajouter la route POST /pages/delete/{id} ou equivalent
- ajouter la route GET /page/{slug}

**Tests Pages :**

- tester l'affichage de la liste des pages
- tester la creation d'une page
- tester la modification d'une page
- tester la suppression d'une page
- tester l'acces public via slug
- verifier qu'une page en draft n'est pas visible publiquement
- verifier qu'un slug inexistant retourne une 404

### 4. Fonctionnalite 3 — Administration & Droits (Personne C)

**Perimetre autorise :**

- Controllers/AdminController.php
- Middleware/AuthMiddleware.php
- Middleware/RoleMiddleware.php
- Views/admin/*
- Models/Permission.php si vraiment necessaire
- gestion des acces restreints par role

**AuthMiddleware :**

- creer AuthMiddleware.php
- verifier qu'un utilisateur est connecte
- rediriger vers /login si non connecte
- prevoir un message d'erreur ou une redirection claire

**RoleMiddleware :**

- creer RoleMiddleware.php
- verifier le role de l'utilisateur connecte
- autoriser seulement certains roles selon la route
- refuser l'acces si role insuffisant
- gerer le cas d'acces interdit proprement

**AdminController :**

- creer la methode dashboard()
- creer une methode pour afficher les utilisateurs si demande
- creer une methode pour afficher les roles si demande
- preparer une page d'administration simple
- verifier que les acces admin passent bien par les middlewares

**Vues admin :**

- creer views/admin/dashboard.php
- creer views/admin/users.php si necessaire
- creer views/admin/roles.php si necessaire
- afficher une interface simple et claire
- afficher les informations importantes d'administration

**Routes admin :**

- ajouter la route GET /admin
- proteger la route /admin
- proteger les eventuelles routes /admin/users
- proteger les eventuelles routes /admin/roles

**Tests Admin :**

- verifier qu'un utilisateur non connecte est redirige
- verifier qu'un utilisateur connecte sans role admin n'a pas acces
- verifier qu'un admin accede au dashboard
- verifier que les middlewares bloquent correctement les acces

## 10. Securite minimale du projet

**Entrees utilisateur :**

- valider les champs cote serveur
- verifier les champs obligatoires
- verifier les formats email
- verifier la longueur minimale des mots de passe
- verifier les donnees envoyees pour les pages

**Sorties HTML :**

- utiliser htmlspecialchars() pour les sorties visibles
- eviter l'affichage direct de donnees brutes utilisateur

**Sessions :**

- demarrer la session proprement
- regenerer l'identifiant de session apres connexion si possible
- detruire totalement la session a la deconnexion

**Acces :**

- verifier les acces au backoffice
- verifier les acces a l'administration
- proteger les routes sensibles

**Base de donnees :**

- utiliser exclusivement PDO
- utiliser des requetes preparees
- ne jamais concatener directement des donnees utilisateur dans SQL

## 11. Integration finale du projet

**Fusion des fonctionnalites :**

- fusionner feature/auth
- fusionner feature/pages
- fusionner feature/admin
- resoudre les conflits proprement
- verifier que chaque fonctionnalite reste dans son perimetre

**Verifications globales :**

- tester le frontoffice
- tester le backoffice
- tester l'authentification
- tester le CRUD des pages
- tester l'acces admin
- tester les routes dynamiques
- tester les erreurs 404
- verifier les redirections

**Nettoyage :**

- supprimer le code mort
- harmoniser les noms de methodes
- harmoniser les noms de variables
- relire les commentaires
- verifier les chemins d'inclusion
- verifier les imports / require / autoload eventuels

**Documentation :**

- rediger un README.md
- expliquer comment lancer le projet
- expliquer comment configurer la base de donnees
- expliquer les comptes de test
- expliquer la repartition des fonctionnalites
- expliquer l'architecture MVC utilisee

## 12. Organisation Git

**Branches :**

- creer feature/auth
- creer feature/pages
- creer feature/admin

**Regles :**

- ne jamais push directement sur main
- passer par Pull Request
- faire relire par les 2 autres membres
- respecter le perimetre de chaque branche

**Convention de commits :**

- utiliser des commits clairs
- exemple : [AUTH] Login + session
- exemple : [PAGES] CRUD pages
- exemple : [ADMIN] Middleware roles

## 13. Ordre conseille pour avancer

**Sprint 1 — Base commune :**

- environnement Docker
- base de donnees
- Database Singleton
- Front Controller
- Router
- Controller de base
- .htaccess

**Sprint 2 — Auth :**

- User model
- Role model
- AuthController
- login/register/logout
- sessions

**Sprint 3 — Pages CMS :**

- Page model
- CRUD pages
- slug
- affichage public

**Sprint 4 — Admin & droits :**

- middlewares
- dashboard admin
- protection par role

**Sprint 5 — Finalisation :**

- tests complets
- corrections
- nettoyage
- documentation
- preparation de la soutenance

## 14. Resultat attendu en fin de projet

- un utilisateur peut s'inscrire
- un utilisateur peut se connecter
- un utilisateur peut se deconnecter
- un utilisateur autorise peut creer une page
- un utilisateur autorise peut modifier une page
- un utilisateur autorise peut supprimer une page
- une page publiee est accessible publiquement via son slug
- le backoffice est protege
- l'espace admin est protege par role
- l'architecture MVC est respectee
- le projet est propre, lisible et demonstrable

## 15. Consigne finale a Copilot

Quand je te demande du code pour ce projet :

- respecte strictement l'architecture MVC
- respecte le perimetre de la fonctionnalite concernee
- n'invente pas d'autres fichiers que ceux utiles a la demande
- ne melange pas les responsabilites des membres de l'equipe
- commence toujours par une version minimale fonctionnelle
- explique brievement comment tester
- utilise PDO, les sessions PHP, password_hash(), password_verify(), htmlspecialchars()
- protege les acces sensibles
- garde un code simple, lisible, propre, pedagogique et compatible avec un projet scolaire en PHP natifv