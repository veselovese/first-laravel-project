<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [MainController::class, 'index']);

Route::get('/galery/{img}/{name}', function ($img, $name) {
    return view('main.galery', ['img' => $img, 'name' => $name]);
});

Route::get('/auth/signup', [AuthController::class, 'signup']);
Route::post('/auth/registr', [AuthController::class, 'registr']);
Route::get('/auth/signin', [AuthController::class, 'signin'])->name('login');
Route::post('/auth/authenticate', [AuthController::class, 'authenticate']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::resource('article', ArticleController::class)->middleware('auth:sanctum');

Route::controller(CommentController::class)->prefix('/comment')->middleware('auth:sanctum')->group(function () {
    Route::post('', [CommentController::class, 'store']);
    Route::get('/{id}/edit', [CommentController::class, 'edit']);
    Route::post('/{comment}/update', [CommentController::class, 'update']);
    Route::get('/{comment}/delete', [CommentController::class, 'destroy']);
});

Route::get('/about', function () {
    return view('main.about');
});

Route::get('/contacts', function () {
    $data = [
        'city' => 'Moscow',
        'street' => 'B. Semenovskaya St.',
        'building' => 38
    ];
    return view('main.contact', ['data' => $data]);
});
