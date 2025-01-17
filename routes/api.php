<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::group(['middleware' => 'admin'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/office', [AdminController::class, 'createOffice']);
            Route::post('/section', [AdminController::class, 'createSection']);
            Route::post('/office-account', [AdminController::class, 'createOfficeAccount']);
            Route::post('/user-account', [AdminController::class, 'createUserAccount']);
            Route::post('/admin-select-date', [AdminController::class, 'userLogsHistoryByDate']);
            Route::post('/document-type', [AdminController::class, 'createDocumentType']);
        }); 
        
        Route::group(['prefix' => 'update'], function () {
            Route::patch('/office', [AdminController::class, 'updateOffice']);
            Route::patch('/section', [AdminController::class, 'updateSection']);
            Route::patch('/office-account', [AdminController::class, 'updateOfficeAccount']);
            Route::patch('/user-account', [AdminController::class, 'updateUserAccount']);
            Route::patch('/admin-account-information', [AdminController::class, 'updateAccountInformation']);
            Route::patch('/document-type', [AdminController::class, 'updateDocumentType']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/office', [AdminController::class, 'deleteOffice']);
            Route::delete('/section', [AdminController::class, 'deleteSection']);
            Route::delete('/office-account', [AdminController::class, 'deleteOfficeAccount']);
            Route::delete('/user-account', [AdminController::class, 'deleteUserAccount']);
            Route::delete('/document-type', [AdminController::class, 'deleteDocumentType']);
        });

        Route::group(['prefix' => 'search'], function () {
            Route::post('/data-analytics', [AdminController::class, 'serarchDataAnalytics']);
        });

    });

    Route::group(['middleware' => 'office'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/qrcode', [OfficeController::class, 'createQRCode']);
            Route::get('/get-next-office', [OfficeController::class, 'getOffice']);
        }); 
        
        Route::group(['prefix' => 'update'], function () {
            Route::patch('/office-forward-document', [OfficeController::class, 'forwardDocument']);
            Route::patch('/office-forward-document-again', [OfficeController::class, 'forwardDocumentAgain']);
            Route::patch('/office-forward-selected-document', [OfficeController::class, 'forwardSelectedDocument']);
            Route::patch('/office-account-information', [OfficeController::class, 'updateAccountInformation']);
            Route::patch('/scan-document-office', [OfficeController::class, 'scanDocument']);
            Route::patch('/qrcode', [OfficeController::class, 'renameQRCode']);
        });
        
        Route::group(['prefix' => 'delete'], function () {
            Route::delete('/qrcode', [OfficeController::class, 'deleteQRCode']);
        });

    });

    Route::group(['middleware' => 'user'], function () {

        Route::group(['prefix' => 'create'], function () {
            Route::post('/user-select-date', [UserController::class, 'getReceivedLogsByDate']);
            Route::post('/user-select-date-forwarded', [UserController::class, 'userLogsHistoryByDate']);
            Route::get('/get-office', [UserController::class, 'getOffice']);
            Route::post('/batch-documents', [UserController::class, 'batchSelectedDocuments']);
        }); 
        
        Route::group(['prefix' => 'update'], function () {
            Route::patch('/scan-document', [UserController::class, 'scanDocument']);
            Route::patch('/user-forward-document', [UserController::class, 'forwardDocument']);
            Route::patch('/user-forward-selected-document', [UserController::class, 'forwardSelectedDocument']);
            Route::patch('/user-return-document', [UserController::class, 'returnDocument']);
            Route::patch('/user-return-selected-document', [UserController::class, 'returnSelectedDocument']);
            Route::patch('/user-account-information', [UserController::class, 'updateAccountInformation']);
            Route::patch('/insert-to-existing-batch', [UserController::class, 'insertToExistingBatch']);
            Route::patch('/batch-documents', [UserController::class, 'updateBatchSelectedDocuments']);
            Route::patch('/user-forward-batch-document', [UserController::class, 'forwardBatchDocument']);
        });
        
        Route::group(['prefix' => 'delete'], function () {

        });

    });

});
