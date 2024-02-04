<?php

use App\Http\Controllers\ActiveLog;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserController;
use Faker\Provider\ar_EG\Payment;

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
    return redirect('/login');
});



Route::middleware('admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('password', [ProfileController::class, 'password'])->name('password.edit');
    Route::post('password', [ProfileController::class, 'updatePassword'])->name('password.edit');

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    //plan
    Route::get('plan', [PlanController::class, 'index'])->name('plan.index');
    Route::get('plan/create', [PlanController::class, 'create'])->name('plan.create');
    Route::post('plan/create', [PlanController::class, 'store'])->name('plan.create');
    Route::get('plan/edit/{id}', [PlanController::class, 'edit'])->name('plan.edit');
    Route::post('plan/edit/{id}', [PlanController::class, 'update'])->name('plan.edit');
    Route::get('plan/delete/{id}', [PlanController::class, 'destroy'])->name('plan.delete');

    //FAQ
    Route::get('faq', [FaqController::class, 'index'])->name('faq.index');
    Route::get('faq/create', [FaqController::class, 'create'])->name('faq.create');
    Route::post('faq/create', [FaqController::class, 'store'])->name('faq.create');
    Route::get('faq/edit/{id}', [FaqController::class, 'edit'])->name('faq.edit');
    Route::post('faq/edit/{id}', [FaqController::class, 'update'])->name('faq.edit');
    Route::get('faq/delete/{id}', [FaqController::class, 'destroy'])->name('faq.delete');

    //user
    Route::get('user/all',[UserController::class,'allUser'])->name('user.all');
    Route::get('user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
    Route::post('user/update/{id}',[UserController::class,'update'])->name('user.update');
    Route::get('user/delete/{id}',[UserController::class,'delete'])->name('user.delete');

    //plan User
    Route::get('plans/user', [PlanController::class, 'userPlan'])->name('plans.user');

    Route::get('active-log', [ActiveLog::class, 'showActive'])->name('active-log');




});



require __DIR__ . '/auth.php';
