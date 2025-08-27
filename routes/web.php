<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome-new');
});

Route::get('/dashboard', function () {
    // Get the user role from session (set during login)
    $user = Auth::user();
    $userRole = session('user_role', $user ? $user->role : 'pegawai');
    
    // Pass the role to the dashboard view
    return view('pages.dashboard.index', ['userRole' => $userRole]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
