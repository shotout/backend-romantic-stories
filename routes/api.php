<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ListController;
use App\Http\Controllers\Api\v1\AdmobController;
use App\Http\Controllers\Api\v1\AvatarController;
use App\Http\Controllers\Api\v1\StoryController;
use App\Http\Controllers\Api\v1\SettingController;
use App\Http\Controllers\Api\v1\PurchaselyController;
use App\Http\Controllers\Api\v1\UserRatingController;
use App\Http\Controllers\Api\v1\UserProfileController;
use App\Http\Controllers\api\v1\SubscriptionsController;
use App\Http\Controllers\Api\v1\UserPastStoryController;
use App\Http\Controllers\Api\v1\UserCollectionController;

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
        Route::get('/links', [ListController::class, 'links'])->name('links');
        Route::get('/levels', [ListController::class, 'levels'])->name('levels');
        Route::get('/versions', [ListController::class, 'versions'])->name('versions');
    }
);

Route::prefix('v1/admob')->name('admob.')->group(
    function() {
        Route::get('/', [AdmobController::class, 'callback'])->name('callback');
    }
);

Route::prefix('v1/purchasely')->name('purchasely.')->group(
    function() {
        Route::post('/', [PurchaselyController::class, 'index'])->name('purchasely');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/stories')->name('stories.')->group(
    function() {
        Route::get('/', [StoryController::class, 'index'])->name('index');
        Route::get('/all', [StoryController::class, 'all'])->name('all');
        Route::get('/{id}', [StoryController::class, 'show'])->name('show');
        Route::post('/share/{id}', [StoryController::class, 'share'])->name('share');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/collection')->name('collection.')->group(
    function() {
        Route::get('/', [UserCollectionController::class, 'index'])->name('index');
        Route::get('/{id}', [UserCollectionController::class, 'show'])->name('show');
        Route::post('/', [UserCollectionController::class, 'store'])->name('store');
        Route::patch('/{id}', [UserCollectionController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserCollectionController::class, 'destroy'])->name('destroy');

        Route::post('/story/{story}', [UserCollectionController::class, 'storeStoryOutside'])->name('story.store.outside');
        Route::delete('/story/{story}', [UserCollectionController::class, 'destroyStoryOutside'])->name('story.destroy.outside');

        Route::post('/story/{collection}/{story}', [UserCollectionController::class, 'storeStory'])->name('story.store');
        Route::delete('/story/{collection}/{story}', [UserCollectionController::class, 'destroyStory'])->name('story.destroy');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/past-story')->name('past-story.')->group(
    function() {
        Route::get('/', [UserPastStoryController::class, 'index'])->name('index');
        Route::post('/{id}', [UserPastStoryController::class, 'store'])->name('store');
        Route::delete('/{id}', [UserPastStoryController::class, 'destroy'])->name('destroy');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/user')->name('user.')->group(
    function() {
        Route::get('/', [UserProfileController::class, 'show'])->name('show');
        Route::patch('/', [UserProfileController::class, 'update'])->name('update');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/rating')->name('rating.')->group(
    function() {
        Route::get('/', [UserRatingController::class, 'show'])->name('show');
        Route::post('/', [UserRatingController::class, 'store'])->name('store');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/setting')->name('setting.')->group(
    function() {
        Route::get('/paywall', [SettingController::class, 'paywall'])->name('paywall');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/subscription')->name('subscription.')->group(
    function() {
        Route::get('/', [SubscriptionsController::class, 'index'])->name('index');
        Route::post('/update', [SubscriptionsController::class, 'subscribe'])->name('subscribe');
    }
);

Route::middleware('auth:sanctum')->prefix('v1/avatar')->name('avatar.')->group(
    function() {
        Route::get('/', [AvatarController::class, 'show'])->name('show');
    }
);
