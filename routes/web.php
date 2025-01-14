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

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController; 
use App\Http\Controllers\OfficeController; 
use App\Http\Controllers\UserController; 

Route::get('/storage', function () {
    Artisan::call('storage:link');
});

Route::get('/', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/track-document-using-qrcode/{id}', [OfficeController::class, 'trackDocument'])->middleware('guest')->name('track-document-using-qrcode');


Route::group(['middleware' => 'auth'], function () {

	Route::group(['middleware' => 'admin'], function () {
		Route::get('/admin-dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
		Route::get('/data-analytics', [AdminController::class, 'dataAnalytics'])->name('data-analytics');
		Route::get('/offices', [AdminController::class, 'offices'])->name('offices');
		Route::get('/office-sections', [AdminController::class, 'officeSections'])->name('office-sections');
		Route::get('/office-accounts', [AdminController::class, 'officeAccounts'])->name('office-accounts');
		Route::get('/user-accounts', [AdminController::class, 'userAccounts'])->name('user-accounts');
		Route::get('/document-type', [AdminController::class, 'documentType'])->name('document-type');
		Route::get('/edit-office-account/{id}', [AdminController::class, 'editOfficeAccount'])->name('edit-office-account');
		Route::get('/edit-document-type/{id}', [AdminController::class, 'editDocumentType'])->name('edit-document-type');
		Route::get('/admin-profile', [AdminController::class, 'profile'])->name('admin-profile');
		Route::get('/user-logs-history/{id}', [AdminController::class, 'userLogsHistory'])->name('user-logs-history');
		Route::get('/view-office-document/{id}/{officeID}', [AdminController::class, 'viewOfficeDocument'])->name('view-office-document');
		Route::get('/admin-document-tracker/{id}', [AdminController::class, 'adminDocumentTracker'])->name('admin-document-tracker');
	});

	Route::group(['middleware' => 'office'], function () {
		Route::get('/office-dashboard', [OfficeController::class, 'dashboard'])->name('office-dashboard');
		Route::get('/archives', [OfficeController::class, 'archives'])->name('archives');
		Route::get('/office-document-tracker/{id}', [OfficeController::class, 'officeDocumentTracker'])->name('office-document-tracker');
		Route::get('/office-profile', [OfficeController::class, 'profile'])->name('office-profile');
	});

	Route::group(['middleware' => 'user'], function () {
		Route::get('/user-dashboard', [UserController::class, 'dashboard'])->name('user-dashboard');
		Route::get('/directory-offices/{id}', [UserController::class, 'offices'])->name('directory-offices');
		Route::get('/batch-documents', [UserController::class, 'batchDocuments'])->name('batch-documents');
		Route::get('/edit-batch-documents/{id}', [UserController::class, 'editBatchDocuments'])->name('edit-batch-documents');
		Route::get('/user-profile', [UserController::class, 'profile'])->name('user-profile');
	});
	
	Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});