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

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();


Route::group(['middleware' => ['auth:sanctum','verified']], function () {
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/people', [App\Http\Controllers\PeopleController::class, 'get_people'])->name('get.people');
Route::post('/person/add', [App\Http\Controllers\PeopleController::class, 'add_person'])->name('add.new.person');
Route::post('/person/detail', [App\Http\Controllers\PeopleController::class, 'get_person_detail'])->name('get.person.detail');
Route::post('/person/update', [App\Http\Controllers\PeopleController::class, 'update_person'])->name('update.person');
Route::post('/person/delete', [App\Http\Controllers\PeopleController::class, 'delete_person'])->name('delete.person');

});