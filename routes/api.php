<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ListController;
use App\Http\Controllers\Api\v1\StoryController;

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

Route::prefix('v1/auth')->name('auth.')->group(
    function() {
        Route::post('/check', [AuthController::class, 'check'])->name('check');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
    }
);

Route::prefix('v1/list')->name('list.')->group(
    function() {
        Route::get('/categories', [ListController::class, 'categories'])->name('categories');
        Route::get('/avatars', [ListController::class, 'avatars'])->name('avatars');
        Route::get('/themes', [ListController::class, 'themes'])->name('themes');
        Route::get('/languages', [ListController::class, 'languages'])->name('languages');
        Route::get('/icons', [ListController::class, 'icons'])->name('icons');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/stories')->name('stories.')->group(
    function() {
        Route::get('/', [StoryController::class, 'index'])->name('index');
    }
);
