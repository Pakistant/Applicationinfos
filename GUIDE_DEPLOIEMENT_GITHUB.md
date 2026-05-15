# Guide de Déploiement sur GitHub - Actupolitique

## 📋 Analyse du Projet

Votre projet est une **application Laravel 10** avec les caractéristiques suivantes :
- Framework : Laravel 10.10
- Authentification : Laravel Breeze
- Frontend : Tailwind CSS + Vite
- Packages : Laravel Sanctum, Laravel Tagging, Spatie Sluggable
- Base de données : MySQL/PostgreSQL (à configurer)

## 🚀 Étapes pour Déployer sur GitHub

### Étape 1 : Vérifier les Fichiers à Exclure

Le fichier `.gitignore` est déjà configuré et exclut :
- `/vendor` (dépendances PHP)
- `/node_modules` (dépendances JavaScript)
- `.env` (fichier de configuration sensible)
- `/storage/*.key`
- `/public/build`
- `/public/hot`

### Étape 2 : Initialiser le Dépôt Git

Ouvrez PowerShell dans le dossier du projet et exécutez :

```powershell
# Initialiser Git
git init

# Vérifier le statut
git status
```

### Étape 3 : Créer un Fichier .env.example (Recommandé)

Créez un fichier `.env.example` avec les variables d'environnement nécessaires (sans les valeurs sensibles) :

```env
APP_NAME=Actupolitique
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=actupolitique
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

### Étape 4 : Ajouter les Fichiers au Dépôt

```powershell
# Ajouter tous les fichiers (sauf ceux dans .gitignore)
git add .

# Vérifier ce qui sera commité
git status
```

### Étape 5 : Créer le Premier Commit

```powershell
# Créer le commit initial
git commit -m "Initial commit - Application Actupolitique Laravel 10"
```

### Étape 6 : Créer un Dépôt sur GitHub

1. Allez sur [GitHub.com](https://github.com)
2. Cliquez sur le bouton **"+"** en haut à droite
3. Sélectionnez **"New repository"**
4. Remplissez les informations :
   - **Repository name** : `actupolitique` (ou le nom de votre choix)
   - **Description** : "Application d'actualités politiques avec Laravel 10"
   - **Visibilité** : Public ou Private (selon votre choix)
   - **NE PAS** cocher "Initialize this repository with a README"
5. Cliquez sur **"Create repository"**

### Étape 7 : Connecter le Dépôt Local à GitHub

GitHub vous donnera des commandes. Utilisez celles pour un dépôt existant :

```powershell
# Ajouter le remote GitHub (remplacez USERNAME par votre nom d'utilisateur GitHub)
git remote add origin https://github.com/USERNAME/actupolitique.git

# Vérifier que le remote est bien ajouté
git remote -v
```

### Étape 8 : Pousser le Code sur GitHub

```powershell
# Renommer la branche principale en 'main' (si nécessaire)
git branch -M main

# Pousser le code sur GitHub
git push -u origin main
```

Si vous êtes invité à vous authentifier :
- Utilisez un **Personal Access Token** (PAT) au lieu de votre mot de passe
- Pour créer un PAT : GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic)

## 📝 Fichiers Importants à Vérifier Avant le Push

### ✅ Vérifier que ces fichiers sont bien exclus (dans .gitignore) :
- `.env` (contient vos clés secrètes)
- `/vendor` (dépendances PHP)
- `/node_modules` (dépendances JavaScript)
- `/storage/*.key` (clés de chiffrement)
- Fichiers de logs sensibles

### ✅ Fichiers à inclure :
- `composer.json` et `composer.lock`
- `package.json` et `package-lock.json`
- Tous les fichiers de code source
- Les migrations de base de données
- Les fichiers de configuration (sans `.env`)

## 🔒 Sécurité - Points Importants

1. **NE JAMAIS** commiter le fichier `.env`
2. **Créer** un fichier `.env.example` avec les variables sans valeurs sensibles
3. **Vérifier** qu'aucune clé API, mot de passe ou token n'est dans le code
4. Si vous avez accidentellement commité des données sensibles, utilisez `git filter-branch` ou `git filter-repo`

## 📦 Commandes Utiles Après le Déploiement

### Pour les Collaborateurs qui Clonent le Projet :

```powershell
# Cloner le dépôt
git clone https://github.com/USERNAME/actupolitique.git
cd actupolitique

# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install

# Copier le fichier .env.example vers .env
copy .env.example .env

# Générer la clé d'application
php artisan key:generate

# Créer le lien symbolique pour le stockage
php artisan storage:link

# Exécuter les migrations
php artisan migrate

# Compiler les assets
npm run build
```

## 🎯 Prochaines Étapes Recommandées

1. **Ajouter un README.md personnalisé** avec :
   - Description du projet
   - Instructions d'installation
   - Configuration requise
   - Guide d'utilisation

2. **Créer des branches** pour le développement :
   ```powershell
   git checkout -b develop
   git push -u origin develop
   ```

3. **Ajouter des badges** dans le README (statut de build, version, etc.)

4. **Configurer GitHub Actions** pour CI/CD (optionnel)

## ❓ Problèmes Courants

### Erreur : "remote origin already exists"
```powershell
git remote remove origin
git remote add origin https://github.com/USERNAME/actupolitique.git
```

### Erreur : "failed to push some refs"
```powershell
git pull origin main --allow-unrelated-histories
git push -u origin main
```

### Oublier d'exclure un fichier sensible
```powershell
# Retirer un fichier du cache Git
git rm --cached .env
git commit -m "Remove .env from repository"
git push
```

---

**Bon déploiement ! 🚀**


