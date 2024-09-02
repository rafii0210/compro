<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EksController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('latihan', [CountController::class, 'index']);
Route::get('penjumlahan', [CountController::class, 'jumlah'])->name('penjumlahan');
Route::get('pengurangan', [CountController::class, 'kurang'])->name('pengurangan');
Route::get('perkalian', [CountController::class, 'kali'])->name('perkalian');
Route::get('pembagian', [CountController::class, 'bagi'])->name('pembagian');

Route::post('/storejumlah', [CountController::class, 'storejumlah'])->name('store_penjumlahan');
Route::post('/storekurang', [CountController::class, 'storekurang'])->name('store_pengurangan');
Route::post('/storekali', [CountController::class, 'storekali'])->name('store_perkalian');
Route::post('/storebagi', [CountController::class, 'storebagi'])->name('store_pembagian');

Route::get('/dashboard', function () {
    if (Auth::user()->id_level === 1) {
        return view('admin/dashboard');
    } elseif (Auth::user()->id_level === 2) {
        return view('user/dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);
route::get('admin/profiles', [ProfController::class, 'index'])->name('profiles.index')->middleware(['auth', 'admin']);
route::get('admin/profiles/create', [ProfController::class, 'create'])->name('profiles.create')->middleware(['auth', 'admin']);
route::post('admin/profiles/store', [ProfController::class, 'store'])->name('profiles.store')->middleware(['auth', 'admin']);
//Update dan softdelete
route::get('admin/profiles/edit/{id}', [ProfController::class, 'edit'])->name('profiles.edit')->middleware(['auth', 'admin']);
route::delete('admin/profiles/delete/{id}', [ProfController::class, 'softdelete'])->name('profiles.softDelete')->middleware(['auth', 'admin']);
route::put('admin/profiles/update/{id}', [ProfController::class, 'update'])->name('profiles.update')->middleware(['auth', 'admin']);
//End Update dan softdelete
route::post('/admin/profiles/update-status/{id}', [ProfController::class, 'updateStatus'])->name('profiles.update-status');
// recycle dan restore
route::get('/admin/recycle', [ProfController::class, 'recycle'])->name('profiles.recycle');
route::get('admin/restore/{id}', [ProfController::class, 'restore'])->name('profiles.restore');
route::delete('admin/destroy/{id}', [ProfController::class, 'destroy'])->name('profiles.destroy');
Route::get('profile/generate-pdf/{id}',[ProfController::class, 'show'])->name('generate-pdf');
// Eksperience
route::get('admin/eksperience', [EksController::class, 'index'])->name('eksperience.index')->middleware(['auth', 'admin']);
route::get('admin/eksperience/create', [EksController::class, 'create'])->name('eksperience.create')->middleware(['auth', 'admin']);
route::post('admin/eksperience/store', [EksController::class, 'store'])->name('eksperience.store')->middleware(['auth', 'admin']);
// Deskripsi
route::get('compro', [ContentController::class,'index']);


route::get('user/dashboard', [HomeController::class, 'userindex'])->middleware(['auth', 'user']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
route::get('admin/dashboard', [homeController::class, 'index'])->middleware(['auth', 'admin']);
route::get('user/dashboard', [homeController::class, 'indexuser'])->middleware(['auth', 'user']);
