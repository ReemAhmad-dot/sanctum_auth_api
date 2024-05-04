<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\StudentController;

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

route::post('/register',[StudentController::class,'register']);
route::post('/login',[StudentController::class,'login']);

route::group(["middleware"=>["auth:sanctum"]],function(){
    route::get('/profile',[StudentController::class,'profile']);
    route::get('/logout',[StudentController::class,'logout']);
    //Project module routes
    route::post('/add-Project',[ProjectController::class,'addProject']);
    route::get('/list-project',[ProjectController::class,'getProjectList']);
    route::get('/single-project/{id}',[ProjectController::class,'getSingleProject']);
    route::delete('/delete-project/{id}',[ProjectController::class,'deleteProject']);
    route::delete('/delete-all-projects',[ProjectController::class,'deleteMyProjects']);
});



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
