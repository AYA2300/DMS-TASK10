<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DocumentController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CommentController::class)->group(function () {
    Route::get('/comments', 'index');
    Route::post('Addcomments', 'store');
    Route::get('/comments/{comment}', 'show');
    Route::put('/comments/{comment}', 'update');
    Route::delete('/comments/{comment}', 'destroy');
});

Route::controller(DocumentController::class)->group(function () {
    Route::get('/documents', 'index');
    Route::post('Adddocuments', 'store');
    Route::get('show/{document}', 'show');
    Route::put('/documents/{document}', 'update');
    Route::delete('/documents/{document}', 'destroy');
});


Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
    Route::post('Addcategories', 'store');
    Route::get('/showcategories/{category}', 'show');
    Route::put('/updatecategories/{category}', 'update');

});
