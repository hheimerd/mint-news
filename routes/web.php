<?php

use App\Http\Controllers\PostController;
use App\Http\Livewire\Index;
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



Route::any('/test',function (\Illuminate\Http\Request $request) {
    dd($request->input('post_data'));
})->name('test');

Route::resource('posts', PostController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/{type?}', Index::class)->name('index');

