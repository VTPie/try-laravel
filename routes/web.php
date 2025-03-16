<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$prefixTodo = config("todo.prefix_url");
$prefixPicture = config("picture.prefix_url");
$prefixUser = config("user.prefix_url");

// Landing page
Route::get('/', function () {
    return view('welcome');
});

//TD route group
Route::prefix($prefixTodo)->group(function () {
    Route::get('/', [App\Http\Controllers\TodoController::class, 'index'])
        ->name('todo.index');

    Route::get('/create', [App\Http\Controllers\TodoController::class, 'create'])
        ->name('todo.create');

    Route::post('/store', [App\Http\Controllers\TodoController::class, 'store'])
        ->name('todo.store');

    Route::get('/edit/{id}', [App\Http\Controllers\TodoController::class, 'edit'])->where('id', '[0-9]+')
        ->name('todo.edit');

    Route::put('/update/{id}', [App\Http\Controllers\TodoController::class, 'update'])
        ->name('todo.update');

    Route::delete('/destroy/{id}', [App\Http\Controllers\TodoController::class, 'destroy'])->where('id', '[0-9]+')
        ->name('todo.destroy');
});

//Picture route group
Route::prefix($prefixPicture)->group(function () {
    Route::get('/', [App\Http\Controllers\PictureController::class, 'index'])
        ->name('picture.index');

    Route::get('/create', [App\Http\Controllers\PictureController::class, 'create'])
        ->name('picture.create');

    Route::post('/store', [App\Http\Controllers\PictureController::class, 'store'])
        ->name('picture.store');

    Route::get('/edit/{id}', [App\Http\Controllers\PictureController::class, 'edit'])->where('id', '[0-9]+')
        ->name('picture.edit');

    Route::put('/update/{id}', [App\Http\Controllers\PictureController::class, 'update'])
        ->name('picture.update');

    Route::delete('/destroy/{id}', [App\Http\Controllers\PictureController::class, 'destroy'])->where('id', '[0-9]+')
        ->name('picture.destroy');
});

//User route group
Route::prefix($prefixUser)->group(function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'index'])
        ->name('user.index');

    Route::get('/create', [App\Http\Controllers\UserController::class, 'create'])
        ->name('user.create');

    Route::post('/store', [App\Http\Controllers\UserController::class, 'store'])
        ->name('user.store');

    Route::get('/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->where('id', '[0-9]+')
        ->name('user.edit');

    Route::put('/update/{id}', [App\Http\Controllers\UserController::class, 'update'])
        ->name('user.update');

    Route::delete('/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->where('id', '[0-9]+')
        ->name('user.destroy');
});
