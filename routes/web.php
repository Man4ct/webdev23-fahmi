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
Route::controller(\App\Http\Controllers\ArticleController::class)->group(function () {
    Route::get('/articles', 'list')->name('article.list');
    Route::match(
        ['get', 'post'],
        '/articles/create',
        'create'
    )->name('article.create');
    Route::get('/articles/{slug}', 'single')->name('article.single');
    Route::match(['get', 'post'], '/articles/{id}/edit',
'edit')->name('article.edit');
Route::post('/articles/{id}/delete', 'delete')->name('article.delete');

// Route for listing article categories
Route::get('/article_categories', [ArticleCategoryController::class, 'index'])
    ->name('article_category.list');

// Route for displaying the form to create a new article category
Route::get('/article_categories/create', [ArticleCategoryController::class, 'create'])
    ->name('article_category.create');

// Route for handling the submission of the form to create a new article category
Route::post('/article_categories/create', [ArticleCategoryController::class, 'store']);

// Route for displaying the form to edit an existing article category
Route::get('/article_categories/{id}/edit', [ArticleCategoryController::class, 'edit'])
    ->name('article_category.edit');

// Route for handling the submission of the form to edit an existing article category
Route::post('/article_categories/{id}/edit', [ArticleCategoryController::class, 'update']);

// Route for handling the deletion of an article category
Route::post('/article_categories/{id}/delete', [ArticleCategoryController::class, 'destroy'])
    ->name('article_category.delete');
});
