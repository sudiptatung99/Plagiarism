<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\FolderController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FaqApiController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReportController;

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

Route::post('user/login', [UserController::class, 'login']);
Route::post('user/register', [UserController::class, 'register']);
Route::post('user/register/otp', [UserController::class, 'checkRegisterOtp']);

Route::post('user/forget-password', [UserController::class, 'emailVerify']);
Route::post('user/otp', [UserController::class, 'checkOtp']);
Route::post('user/resend-otp', [UserController::class, 'resendOtp']);
Route::post('user/reset-password', [UserController::class, 'Resetpassword']);



Route::group(['middleware' => ['jwt.verify']], function() {

    Route::post('user/details', [UserController::class, 'details']);
    Route::post('user/folder-list', [UserController::class, 'folderList']);
    Route::post('user/all-folder',[UserController::class, 'getAllFolder']);
    Route::post('user/plan-list', [UserController::class, 'planList']);
    Route::post('user/document-list', [UserController::class, 'documentList']);
    Route::post('user/delete-document-list', [UserController::class, 'deleteDocumentList']);
    Route::post('user/folder-document-list', [UserController::class, 'folderDocumentList']);

    Route::post('user/change-password', [UserController::class, 'changePassword']);
    // Route::post('user/folder-document-list', [UserController::class, 'folderDocumentList']);

    Route::post('user/profile',[ProfileController::class,'profileInfo']);
    Route::post('user/profile-edit',[ProfileController::class,'profileEdit']);

    Route::post('user/dashboard',[DashboardController::class,'index']);

    Route::get('plan/list', [PlanController::class, 'list']);
    Route::post('plan/add', [PlanController::class, 'addPlan']);
    Route::post('plan/count', [PlanController::class, 'planCount']);

    Route::post('folder/create', [FolderController::class, 'create']);
    Route::post('folder/delete', [FolderController::class, 'delete']);
    Route::post('folder/details', [FolderController::class, 'details']);
    Route::post('folder/update', [FolderController::class, 'update']);
    Route::post('folder/move', [FolderController::class, 'moveFolder']);

    Route::post('document/upload', [DocumentController::class, 'upload']);
    Route::post('document/upload-document', [DocumentController::class, 'uploadDocument']);
    Route::post('document/delete', [DocumentController::class, 'delete']);
    Route::post('document/add-to-index', [DocumentController::class, 'addToIndex']);
    Route::post('document/move', [DocumentController::class, 'moveDocument']);

    Route::post('document/show', [DocumentController::class, 'documentCount']);

    Route::post('document/text', [DocumentController::class, 'UploadText']);
    Route::post('document/deleted-from-index', [DocumentController::class, 'deletedFromIndex']);

    Route::post('document/report', [DocumentController::class, 'report']);
    Route::post('document/count', [DocumentController::class, 'countDocument']);

    Route::get('/faq',[FaqApiController::class,'index']);

    Route::post('payment', [PaymentController::class, 'requesthandaler'])->name('payment');
});
Route::post('/payment/status',[PaymentController::class,'ResponseHendaler'])->name('payment.status');
