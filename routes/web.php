<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\FrontcategoryController;
use App\Http\Controllers\FrontcontactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\KioskIssueController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//page d'accueil 
Route::get('/', [HomeController::class, 'index'])->name('home');

// page details pour les articles 

Route::get('/details/{slug}', [DetailsController::class, 'index'])->name('article.details');

//partie des commenataire sur un article

Route::post('/comment/{id}',[DetailsController::class,'comment'])->name('comment');

// partie des affichage des category dans le front
Route::get('/categorie/{slug}',[FrontcategoryController::class,'index'])->name('category.article');

// partie contact pour frontend

Route::get('/contact/front', [FrontcontactController::class, 'index'])->name('contact.front');
Route::post('/contact/envoyer', [FrontcontactController::class, 'contact'])->name('contact.envoyer');

// partie recherche
Route::match(['get', 'post'], '/recherche', [SearchController::class, 'index'])->name('search');
Route::get('/tag/{tag}', [TagController::class, 'index'])->name('tag.articles');
Route::get('/kiosque', [KioskIssueController::class, 'publicIndex'])->name('kiosk.public');
Route::get('/kiosque/{kiosk}', [KioskIssueController::class, 'show'])->name('kiosk.show');

Route::get('/dashboard', [DashboardController::class , 'index'])->middleware(['auth', 'auth.session', 'verified','checkRole:admin,author'])->name('dashboard');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// partie category

Route::resource('/category', CategoryController::class)->middleware(['auth', 'auth.session', 'Admin']);
// partie article
Route::resource('/article', ArticleController::class)->middleware(['auth', 'auth.session']);
Route::resource('/gestion/kiosque', KioskIssueController::class)->except(['show'])->parameters(['kiosque' => 'kiosk'])->names('kiosk')->middleware(['auth', 'auth.session', 'Admin']);

// partie user
Route::resource('/author', UserController::class)->middleware(['auth', 'auth.session', 'Admin']);

// partie reseaux sociaux
Route::resource('/social', App\Http\Controllers\SocialMediaController::class)->middleware(['auth', 'auth.session', 'Admin']);

// partie commentaire

Route::resource('/comment', CommentController::class)->middleware(['auth', 'auth.session']);
Route::put('comment/unlock/{id}',[CommentController::class, 'unlock'])->middleware(['auth', 'auth.session'])->name('comment.unlock');

// partie gestion des contact cote admin

Route::resource('/contact', ContactController::class)->middleware(['auth', 'auth.session', 'Admin']);


// partie parametre

Route::get('/parametre',[SettingsController::class ,'index'])->name('setting.index')->middleware(['auth', 'auth.session', 'Admin']);

Route::put('/modifier/parametre',[SettingsController::class ,'update'])->name('setting.update')->middleware(['auth', 'auth.session', 'Admin']);


require __DIR__.'/auth.php';
