<?php

use App\Http\Controllers\FavouritesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/jobs', function (){
    $jobsController = new \App\Http\Controllers\Jobs();
    return $jobsController->fetchJobs();
});

Route::post('/login', function(Request $request){ // good
    $userController = new UserController();
    return $userController->index($request);
});

//Route::post('login', [UserController::class, 'index'])->name('auth.login');

Route::post('/registration', function (Request $request){
    $userController = new UserController();
    return $userController->register($request);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('addToFavourites', [FavouritesController::class, 'addToFavourites']);
    Route::post('getFavouritesOfUser', [FavouritesController::class, 'getFavouritesOfUser']);
});

