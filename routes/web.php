<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('home', HomeController::class);
Route::resource('educationTrips', EducationTripsController::class);
Route::resource('parentsAndChildren', App\Http\Controllers\ParentsAndChildrenController::class);
Route::resource("parentsHere", App\Http\Controllers\ParentsHereController::class);
Route::resource("contact", App\Http\Controllers\ContactController::class);
Route::resource("contact", App\Http\Controllers\ContactController::class);
Route::resource("hospital", App\Http\Controllers\HospitalController::class);
