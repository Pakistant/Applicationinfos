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
use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\SettingsController;


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
Route::post('/recherche',[SearchController::class,'index'])->name('search');

Route::get('/dashboard', [DashboardController::class , 'index'])->middleware(['auth', 'verified','checkRole:admin,author'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// partie category

Route::resource('/category', CategoryController::class)->middleware('Admin');
// partie article
Route::resource('/article', ArticleController::class);

// partie user
Route::resource('/author', UserController::class)->middleware('Admin');

// partie reseaux sociaux
Route::resource('/social', App\Http\Controllers\SocialMediaController::class)->middleware('Admin');

// partie commentaire

Route::resource('/comment', CommentController::class);
Route::put('comment/unlock/{id}',[CommentController::class, 'unlock'])->name('comment.unlock');

// partie gestion des contact cote admin

Route::resource('/contact', ContactController::class);


// partie parametre

Route::get('/parametre',[SettingsController::class ,'index'])->name('setting.index')->middleware('Admin');

Route::put('/modifier/parametre',[SettingsController::class ,'update'])->name('setting.update')->middleware('Admin');


require __DIR__.'/auth.php';
