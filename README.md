# Actupolitique

Actupolitique est une plateforme web d'actualites politiques. Elle permet de publier des articles, de les organiser par categories et de les presenter sur un site public. Un back-office protege permet aux administrateurs et aux auteurs de gerer le contenu.

## Fonctionnalites

### Site public

- Page d'accueil avec les articles recents et mis en avant.
- Consultation d'un article par son slug.
- Navigation par categorie.
- Recherche d'articles.
- Commentaires avec moderation.
- Page de contact et liens vers les reseaux sociaux.
- Affichage des tags et des informations du site.

### Back-office

- Tableau de bord avec les statistiques principales.
- Creation, modification, publication et suppression d'articles.
- Ajout d'images aux articles.
- Association d'un article a une categorie et a son auteur.
- Gestion des tags, commentaires et vues.
- Gestion des categories actives ou inactives.
- Gestion des auteurs et des utilisateurs.
- Gestion des medias sociaux et des parametres du site.
- Gestion du profil et du mot de passe.

## Roles

| Role | Acces |
| --- | --- |
| `admin` | Acces complet au back-office : articles, categories, auteurs, commentaires, contacts, medias sociaux et parametres. |
| `author` | Creation et gestion de ses articles, consultation du tableau de bord et moderation des commentaires selon les droits de la route. |

L'authentification utilise Laravel Breeze. La permission `admin-access` controle l'affichage des menus d'administration et les routes sensibles utilisent le middleware `Admin`.

## Technologies

- PHP 8.1 ou superieur
- Laravel 10.10
- MySQL
- Laravel Breeze pour l'authentification
- Laravel Sanctum pour l'authentification API
- Vite 5, Tailwind CSS, Alpine.js et Axios
- `spatie/laravel-sluggable` pour les slugs automatiques
- `rtconner/laravel-tagging` pour les tags

## Installation locale

### Prerequis

- PHP 8.1+
- Composer
- MySQL demarre
- Node.js et npm

### Installation

Depuis le dossier du projet :

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Configurez ensuite la connexion MySQL dans `.env` :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

La base `laravel` doit exister dans MySQL. Puis executez :

```powershell
php artisan migrate
php artisan storage:link
npm install
npm run build
php artisan serve
```

Le site est alors disponible sur [http://127.0.0.1:8000](http://127.0.0.1:8000).

> `php artisan storage:link` est necessaire pour afficher les images stockees dans `storage/app/public/asset`.

## Connexion de demonstration

Les comptes locaux actuellement disponibles sont :

| Compte | Email | Mot de passe | Role |
| --- | --- | --- | --- |
| Super administrateur | `superadmin@example.com` | `SuperAdmin123!` | `admin` |
| Administrateur auteur | `auteur@example.com` | `Auteur123!` | `author` |

Page de connexion : [http://127.0.0.1:8000/login](http://127.0.0.1:8000/login)

Ces identifiants sont destines au developpement local. Ils doivent etre modifies avant toute mise en production.

## Commandes utiles

```powershell
# Demarrer le serveur Laravel
php artisan serve

# Vider les caches Laravel
php artisan optimize:clear

# Voir l'etat des migrations
php artisan migrate:status

# Appliquer les migrations
php artisan migrate

# Reinitialiser la base puis rejouer les migrations
php artisan migrate:fresh

# Refaire le lien des images publiques
php artisan storage:link

# Construire les assets frontend
npm run build

# Lancer Vite en mode developpement
npm run dev

# Executer les tests
php artisan test
```

## Structure du projet

```text
app/
  Http/Controllers/      Controleurs web et authentification
  Http/Middleware/       Controle des roles et acces
  Models/                Modeles Eloquent
  Providers/             Services, permissions et routes
database/
  migrations/            Structure de la base de donnees
  seeders/               Donnees initiales
resources/views/
  Admin/                 Interface du back-office
  Front/                 Interface publique
  auth/                  Pages de connexion et inscription
routes/
  web.php                Routes publiques et back-office
  auth.php               Routes d'authentification
public/
  back_auth/             Assets du back-office
  front_user/            Assets du site public
storage/app/public/      Images televersees par les utilisateurs
```

## Principales routes

| URL | Description | Acces |
| --- | --- | --- |
| `/` | Accueil public | Public |
| `/details/{slug}` | Detail d'un article | Public |
| `/categorie/{slug}` | Articles d'une categorie | Public |
| `/contact/front` | Formulaire de contact | Public |
| `/login` | Connexion | Public |
| `/dashboard` | Tableau de bord | Admin ou auteur |
| `/article` | Gestion des articles | Utilisateur connecte |
| `/category` | Gestion des categories | Admin |
| `/author` | Gestion des auteurs | Admin |
| `/social` | Gestion des reseaux sociaux | Admin |
| `/contact` | Gestion des messages | Admin |
| `/parametre` | Parametres du site | Admin |

## Images et fichiers uploades

Les images d'articles et le logo sont enregistres dans `storage/app/public/asset`. Laravel les expose via `/storage`. Si une image ne s'affiche pas, executez :

```powershell
php artisan storage:link
```

Puis verifiez que le fichier existe dans `storage/app/public/asset` et rechargez la page avec `Ctrl + F5`.

## Tests et qualite

Avant une livraison, executez les migrations sur une base de test puis lancez :

```powershell
php artisan test
php artisan config:clear
npm run build
```

Ne versionnez jamais le fichier `.env`, les mots de passe ou les cles API. Le fichier `.env.example` sert uniquement de modele de configuration.
