<?php

use App\Http\Controllers\ZoomController;
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
    return view('welcome');
});

Route::resources(['/zoom' => ZoomController::class]);
Route::get('/delete', [ZoomController::class, 'delete'])->name('zoom.delete');
