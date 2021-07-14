<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 
use App\Http\Controllers\EmpController; 
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PrivateController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\TestController;
use App\mail;

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

Route::resource('dayofs',CongeController::class)->middleware('auth'); // Page /conge, qui permet de gérer les congés
Route::resource('privates',PrivateController::class)->middleware('auth'); // page /privates, qui liste les tickets de chaque utilisateurs
Route::get('/privates/edit','PrivateController@edit')->middleware('ticketV');
Route::get('privates/create/{ticket}',[PrivateController::class,'create'])->name('privates.create'); // créer un ticket
Route::resource('tickets', TicketController::class)->middleware('admin'); // Formulaire des tickets + création des tickets
Route::resource('employees', EmployeeController::class)->middleware('admin'); // lister et créer des utilisateurs 
Route::get('/', function () {
    return view('auth.login');
});



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); // page register,login, nv mot de passe, jetstream 
