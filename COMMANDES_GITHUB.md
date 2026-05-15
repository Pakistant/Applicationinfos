# Commandes Rapides pour Déployer sur GitHub

## 📋 Commandes à Exécuter (dans l'ordre)

### 1. Initialiser Git
```powershell
git init
```

### 2. Vérifier les fichiers à ajouter
```powershell
git status
```

### 3. Ajouter tous les fichiers
```powershell
git add .
```

### 4. Créer le premier commit
```powershell
git commit -m "Initial commit - Application Actupolitique Laravel 10"
```

### 5. Créer le dépôt sur GitHub
- Allez sur https://github.com/new
- Nom : `actupolitique` (ou votre choix)
- Ne cochez PAS "Initialize with README"
- Cliquez sur "Create repository"

### 6. Connecter au dépôt GitHub
```powershell
# Remplacez USERNAME par votre nom d'utilisateur GitHub
git remote add origin https://github.com/USERNAME/actupolitique.git
```

### 7. Pousser le code
```powershell
git branch -M main
git push -u origin main
```

## ⚠️ Important
- Si demandé, utilisez un **Personal Access Token** (pas votre mot de passe)
- Créez un token ici : https://github.com/settings/tokens


