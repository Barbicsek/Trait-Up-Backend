<?php

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

Route::group(['middleware' => 'auth:sanctum'], function(){
    //All secure URL's

});

Route::get('/jobs', function (){
    $jobsController = new \App\Http\Controllers\Jobs();
    return $jobsController->fetchJobs();
});

//Route::post('login',[UserController::class,'index']); // good

Route::post('/login', function(Request $request){ // good
    $userController = new UserController();
    return $userController->index($request);
});


