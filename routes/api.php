<?php

use App\Http\Controllers\FavouritesController;
use App\Http\Controllers\Jobs;
use App\Http\Controllers\StudyController;
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


Route::get('/jobs', [Jobs::class, 'fetchJobs']);
Route::get('/getJobDescriptionById', [Jobs::class, 'getJobDescriptionById']);

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
    Route::post('removeFromFavourites', [FavouritesController::class, 'removeFromFavourites']);
    Route::get('getFavouritesOfUser', [FavouritesController::class, 'getFavouritesOfUser']);
    Route::get('getUser', [UserController::class, 'getUser']);
    Route::get('getUserEducation', [UserController::class, 'getUserEducation']);
    Route::put('updateUserInfo', [UserController::class, 'updateUserInfo']);
    Route::post('addEducation', [StudyController::class, 'addEducation']);
    Route::post('deleteStudy', [StudyController::class, 'deleteStudy']);
    Route::put('updateEducation', [StudyController::class, 'updateEducation']);
});

