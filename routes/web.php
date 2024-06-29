<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CategoryController;

// Route::get('/', function () {
// 	return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Auth::routes();

Route::middleware(['auth'])->group(function () {

	Route::controller(ImageController::class)->group(function () {
		Route::get('/images', 'images');
		Route::post('/add-images', 'addImages')->name('addImages');
		Route::post('/update-images', 'updateImages')->name('updateImages');
		Route::post('/delete-images/{id}', 'deleteImages')->name('deleteImages');
	});

	Route::controller(CategoryController::class)->group(function () {

		Route::get('/categories', 'categories');
		Route::get('/sub-categories', 'subCategories');
		Route::post('/add-category', 'addCategory')->name('addCategory');
		Route::get('/edit-category/{id}', 'editCategory')->name('editCategory');
		Route::post('/update-category', 'updateCategory')->name('updateCategory');
		Route::post('/delete-category/{id}', 'deleteCategory')->name('deleteCategory');
		Route::get('/get-category', 'getCategory')->name('getCategory');

		Route::get('/get-cat-select', 'getCatSelect')->name('getCatSelect');

		Route::get('/forms', 'forms');
		Route::post('/form-submit', 'formSubmit')->name('formSubmit');
		Route::post('/delete-form/{id}', 'deleteForm')->name('deleteForm');

	});

});