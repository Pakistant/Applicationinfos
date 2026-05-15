# Script de déploiement sur GitHub pour Actupolitique
# Usage: .\deploy-github.ps1 -GitHubUsername "votre-username" -RepoName "actupolitique"

param(
    [Parameter(Mandatory=$true)]
    [string]$GitHubUsername,
    
    [Parameter(Mandatory=$false)]
    [string]$RepoName = "actupolitique"
)

Write-Host "🚀 Déploiement sur GitHub - Actupolitique" -ForegroundColor Cyan
Write-Host ""

# Vérifier si Git est installé
try {
    $gitVersion = git --version
    Write-Host "✓ Git détecté: $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ Git n'est pas installé. Veuillez l'installer d'abord." -ForegroundColor Red
    exit 1
}

# Vérifier si le dépôt Git existe déjà
if (Test-Path .git) {
    Write-Host "⚠ Dépôt Git déjà initialisé" -ForegroundColor Yellow
    $continue = Read-Host "Voulez-vous continuer? (O/N)"
    if ($continue -ne "O" -and $continue -ne "o") {
        exit 0
    }
} else {
    Write-Host "📦 Initialisation du dépôt Git..." -ForegroundColor Cyan
    git init
    if ($LASTEXITCODE -ne 0) {
        Write-Host "✗ Erreur lors de l'initialisation Git" -ForegroundColor Red
        exit 1
    }
    Write-Host "✓ Dépôt Git initialisé" -ForegroundColor Green
}

# Vérifier le statut
Write-Host ""
Write-Host "📋 Vérification des fichiers..." -ForegroundColor Cyan
git status --short

# Demander confirmation avant d'ajouter les fichiers
Write-Host ""
$addFiles = Read-Host "Voulez-vous ajouter tous les fichiers? (O/N)"
if ($addFiles -eq "O" -or $addFiles -eq "o") {
    Write-Host "📥 Ajout des fichiers..." -ForegroundColor Cyan
    git add .
    Write-Host "✓ Fichiers ajoutés" -ForegroundColor Green
} else {
    Write-Host "⚠ Ajout des fichiers annulé" -ForegroundColor Yellow
    exit 0
}

# Créer le commit
Write-Host ""
$commitMessage = Read-Host "Message de commit (ou appuyez sur Entrée pour 'Initial commit')"
if ([string]::IsNullOrWhiteSpace($commitMessage)) {
    $commitMessage = "Initial commit - Application Actupolitique Laravel 10"
}

Write-Host "💾 Création du commit..." -ForegroundColor Cyan
git commit -m $commitMessage
if ($LASTEXITCODE -ne 0) {
    Write-Host "✗ Erreur lors de la création du commit" -ForegroundColor Red
    Write-Host "  Vérifiez que vous avez des fichiers à commiter" -ForegroundColor Yellow
    exit 1
}
Write-Host "✓ Commit créé: $commitMessage" -ForegroundColor Green

# Vérifier si le remote existe déjà
Write-Host ""
$remoteExists = git remote get-url origin 2>$null
if ($remoteExists) {
    Write-Host "⚠ Remote 'origin' existe déjà: $remoteExists" -ForegroundColor Yellow
    $changeRemote = Read-Host "Voulez-vous le remplacer? (O/N)"
    if ($changeRemote -eq "O" -or $changeRemote -eq "o") {
        git remote remove origin
        git remote add origin "https://github.com/$GitHubUsername/$RepoName.git"
        Write-Host "✓ Remote mis à jour" -ForegroundColor Green
    }
} else {
    Write-Host "🔗 Ajout du remote GitHub..." -ForegroundColor Cyan
    git remote add origin "https://github.com/$GitHubUsername/$RepoName.git"
    Write-Host "✓ Remote ajouté: https://github.com/$GitHubUsername/$RepoName.git" -ForegroundColor Green
}

# Renommer la branche en main
Write-Host ""
Write-Host "🌿 Configuration de la branche principale..." -ForegroundColor Cyan
git branch -M main
Write-Host "✓ Branche renommée en 'main'" -ForegroundColor Green

# Instructions finales
Write-Host ""
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host "📝 PROCHAINES ÉTAPES:" -ForegroundColor Yellow
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host ""
Write-Host "1. Créez le dépôt sur GitHub:" -ForegroundColor White
Write-Host "   https://github.com/new" -ForegroundColor Cyan
Write-Host "   Nom: $RepoName" -ForegroundColor White
Write-Host "   ⚠ Ne cochez PAS 'Initialize with README'" -ForegroundColor Yellow
Write-Host ""
Write-Host "2. Une fois le dépôt créé, exécutez:" -ForegroundColor White
Write-Host "   git push -u origin main" -ForegroundColor Cyan
Write-Host ""
Write-Host "3. Si demandé, utilisez un Personal Access Token:" -ForegroundColor White
Write-Host "   https://github.com/settings/tokens" -ForegroundColor Cyan
Write-Host ""
Write-Host "=" * 60 -ForegroundColor Cyan
Write-Host ""


