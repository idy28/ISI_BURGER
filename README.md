# ISI_BURGER

Un projet de boutique de burgers construit avec Laravel — application d'exemple pour la gestion de burgers, commandes, paiements et utilisateurs.

## Sommaire

- **Description**
- **Fonctionnalités**
- **Prérequis**
- **Installation locale**
- **Utilisation via Docker**
- **Migrations & Seeds**
- **Tests**
- **Structure du projet**
- **Contribuer**

## Description

ISI_BURGER est une application web développée avec Laravel destinée à gérer un catalogue de burgers, les commandes clients, les éléments de commande et les paiements. Ce dépôt contient le code, les migrations, les seeders et la configuration nécessaire pour démarrer rapidement en local ou avec Docker.

## Fonctionnalités

- Liste et gestion des burgers
- Création et suivi des commandes
- Gestion des items d'une commande
- Enregistrement des paiements
- API minimale pour consultation

## Prérequis

- PHP 8.1+ (ou version compatible indiquée dans `composer.json`)
- Composer
- Node.js et npm / Yarn
- MySQL (ou autre SGBD configuré dans `.env`)
- Optionnel : Docker et Docker Compose pour environnement conteneurisé

## Installation locale (sans Docker)

1. Cloner le dépôt :

```bash
git clone <votre-repo-url> ISI_BURGER
cd ISI_BURGER
```

2. Installer les dépendances PHP :

```bash
composer install
```

3. Installer les dépendances Node et compiler les assets :

```bash
npm install
npm run build    # ou `npm run dev` pour le mode développement
```

4. Copier et configurer l'environnement :

```bash
cp .env.example .env
php artisan key:generate
# Éditez .env pour configurer la connexion BD et autres variables
```

5. Préparer le stockage public :

```bash
php artisan storage:link
```

6. Lancer les migrations et les seeders :

```bash
php artisan migrate --seed
```

7. Démarrer le serveur local :

```bash
php artisan serve
# Puis ouvrir http://127.0.0.1:8000
```

## Utilisation via Docker

Le projet inclut un `docker/` et un `docker-compose.yml` pour démarrer un environnement composé (PHP-FPM, Nginx, MySQL).

1. Construire et démarrer les containers :

```bash
docker-compose up -d --build
```

2. Installer les dépendances dans le container PHP (si nécessaire) :

```bash
docker-compose exec php composer install
docker-compose exec php php artisan migrate --seed
docker-compose exec php npm install
docker-compose exec php npm run build
```

3. Les logs Nginx / PHP et la base de données sont accessibles via les containers.

## Migrations & Seeders

- Les migrations se trouvent dans `database/migrations/`.
- Les seeders sont dans `database/seeders/` et le point d'entrée est `DatabaseSeeder.php`.

Commandes utiles :

```bash
php artisan migrate            # exécute les migrations
php artisan migrate:fresh --seed   # réinitialise la BD et exécute les seeders
```

## Tests

Exécuter la suite de tests :

```bash
php artisan test
# ou
vendor/bin/phpunit
```

## Structure importante du projet

- `app/Models/` : modèles Eloquent (`Burger.php`, `Order.php`, `OrderItem.php`, `Payment.php`, `User.php`)
- `app/Http/Controllers/` : contrôleurs
- `routes/web.php` : routes web
- `database/migrations/` : définitions des tables
- `database/seeders/` : seeders
- `public/` : fichiers publics (images, assets compilés)

Fichiers clés : `artisan`, `composer.json`, `vite.config.js`, `docker-compose.yml`

## Debug & Logs

- Logs applicatifs : `storage/logs/laravel.log`
- Cache / vue compilée : `storage/framework/`

## Déploiement

Pour un déploiement simple :

1. Construire les assets (`npm run build`).
2. Déployer les fichiers sur le serveur.
3. Exécuter les migrations et seeders en production avec précaution.

## Contribuer

- Ouvrez une issue pour discuter des changements importants.
- Faites une branche dédiée et un PR clair.
- Exécutez les tests avant de soumettre : `php artisan test`.

## Licence

Ce projet est fourni sous licence MIT — voir le fichier `LICENSE` si présent.

## Contact

Pour toute question relative à ce dépôt, contactez le mainteneur du projet.

---

Bonne exploration et développement !
