<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleCategoryController;

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

Route::get('/', [
    \App\Http\Controllers\HomeController::class,
    'index'
])->name('home')
;
Route::controller(\App\Http\Controllers\ArticleController::class)->middleware(
    'auth'
)->group(function () {
    Route::get('/articles', 'list')->name('article.list');
    Route::match(
        ['get', 'post'],
        '/articles/create',
        'create'
    )->name('article.create');
    Route::get('/articles/{slug}', 'single')->name('article.single');
    Route::match(
        ['get', 'post'],
        '/articles/{id}/edit',
        'edit'
    )->name('article.edit');
    Route::post('/articles/{id}/delete', 'delete')->name('article.delete');
    Route::post('/articles/{id}/comment', 'comment')->name('article.comment');


});
Route::controller(\App\Http\Controllers\ArticleCategoryController::class)->middleware('auth')->group(function () {
    Route::get('/article_categories', 'list')->name('article_category.list');
    Route::match(
        ['get', 'post'],
        '/article_categories/create',
        'create'
    )->name('article_category.create');
    Route::match(
        ['get', 'post'],
        '/article_categories/{id}/edit',
        'edit'
    )->name('article_category.edit');
    Route::post(
        '/article_categories/{id}/delete',
        'delete'
    )->name('article_category.delete');
});

//  // Route for listing article categories
//  Route::get('/article_categories', [ArticleCategoryController::class, 'index'])
//  ->name('article_category.list');

// // Route for displaying the form to create a new article category
// Route::get('/article_categories/create', [ArticleCategoryController::class, 'create'])
//  ->name('article_category.create');

// // Route for handling the submission of the form to create a new article category
// Route::post('/article_categories/create', [ArticleCategoryController::class, 'store']);

// // Route for displaying the form to edit an existing article category
// Route::get('/article_categories/{id}/edit', [ArticleCategoryController::class, 'edit'])
//  ->name('article_category.edit');

// // Route for handling the submission of the form to edit an existing article category
// Route::post('/article_categories/{id}/edit', [ArticleCategoryController::class, 'update']);

// // Route for handling the deletion of an article category
// Route::post('/article_categories/{id}/delete', [ArticleCategoryController::class, 'destroy'])
//  ->name('article_category.delete');


Route::controller(\App\Http\Controllers\UserController::class)->middleware('auth')->group(function () {
    Route::get('/users', 'list')->name('user.list');
    Route::match(['get', 'post'], '/users/create', 'create')->name('user.create');
    Route::match(['get', 'post'], '/users/{id}/edit', 'edit')->name('user.edit');
    Route::post('/users/{id}/delete', 'delete')->name('user.delete');
});

Route::match(
    ['get', 'post'],
    '/login',
    [\App\Http\Controllers\LoginController::class, 'form']
)->name('login')->middleware('guest');

Route::post('/logout', [
    \App\Http\Controllers\LoginController::class,
    'logout'
])->name('logout')->middleware('auth');