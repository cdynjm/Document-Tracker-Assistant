<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACES:
use App\Repositories\Interfaces\AdminInterface;  

class AdminController extends Controller
{
    protected $aes;
    protected $AdminInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes, AdminInterface $AdminInterface) {
        $this->aes = $aes;
        $this->AdminInterface = $AdminInterface;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        return view('pages.admin.admin-dashboard');
    }
    public function adminDocumentTracker(Request $request) {
        $documents = $this->AdminInterface->getDocument($request);
       // $request->session()->put('id', $request->id);
       // $request->session()->put('docType', $this->aes->encrypt($documents->docType));
        $docID = $request->id;
        $docType = $this->aes->encrypt($documents->docType);
        return view('pages.admin.admin-document-tracker', compact('documents', 'docID', 'docType'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function profile() {
        return view('pages.admin.profile');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAccountInformation(Request $request) {
        $status = $this->AdminInterface->updateAccountInformation($request);
        return response()->json(['Message' => 'Account information updated successfully'], $status);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function offices() {
        $offices = $this->AdminInterface->getOffices();
        return view('pages.admin.offices', compact('offices'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function officeSections() {
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        return view('pages.admin.office-sections', compact('offices', 'sections'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function officeAccounts() {
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $officeAccounts = $this->AdminInterface->getOfficeAccounts();
        return view('pages.admin.office-accounts', compact('offices', 'sections', 'officeAccounts'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function userAccounts() {
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $userAccounts = $this->AdminInterface->getUserAccounts();
        return view('pages.admin.user-accounts', compact('offices', 'sections', 'userAccounts'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function documentType() {
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $docType = $this->AdminInterface->getDocType();
        return view('pages.admin.document-type', compact('offices', 'sections', 'docType'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function editDocumentType(Request $request) {
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $docType = $this->AdminInterface->editDocumentType($request);
        $tracker = $this->AdminInterface->getTracker($request);
        return view('modals.admin.edit.edit-document-type', compact('tracker', 'offices', 'sections', 'docType'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function userLogsHistory(Request $request) {
        $user = $this->AdminInterface->userLogsHistory($request);
        $employee = $this->AdminInterface->employeeName($request);
        return view('pages.admin.user-logs-history', compact('employee', 'user'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function userLogsHistoryByDate(Request $request) {
        $user = $this->AdminInterface->userLogsHistoryByDate($request);
        $aes = $this->aes;
        return response()->json([
            'Logs' => view('data.user-logs-history-data', compact('user', 'aes'))->render()
        ], Response::HTTP_OK);
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createOffice(Request $request) {
        $this->AdminInterface->createOffice($request);
        $offices = $this->AdminInterface->getOffices();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Office created successfully',
            'Office' => view('data.office-data', compact('offices', 'aes'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateOffice(Request $request) {
        $this->AdminInterface->updateOffice($request);
        $offices = $this->AdminInterface->getOffices();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Office updated successfully',
            'Office' => view('data.office-data', compact('offices', 'aes'))->render()
        ], Response::HTTP_OK);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteOffice(Request $request) {
        $this->AdminInterface->deleteOffice($request);
        $offices = $this->AdminInterface->getOffices();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Office deleted successfully',
            'Office' => view('data.office-data', compact('offices', 'aes'))->render()
        ], Response::HTTP_OK);
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSection(Request $request) {
        $this->AdminInterface->createSection($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Section created successfully',
            'Section' => view('data.office-section-data', compact('offices', 'sections', 'aes'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateSection(Request $request) {
        $this->AdminInterface->updateSection($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Section updated successfully',
            'Section' => view('data.office-section-data', compact('offices', 'sections', 'aes'))->render()
        ], Response::HTTP_OK);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteSection(Request $request) {
        $this->AdminInterface->deleteSection($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Section deleted successfully',
            'Section' => view('data.office-section-data', compact('offices', 'sections', 'aes'))->render()
        ], Response::HTTP_OK);
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createOfficeAccount(Request $request) {
        $status = $this->AdminInterface->createOfficeAccount($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $officeAccounts = $this->AdminInterface->getOfficeAccounts();
        $aes = $this->aes;
        return response()->json([
            'OfficeAccount' => view('data.office-account-data', compact('offices', 'sections', 'aes', 'officeAccounts'))->render()
        ], $status);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function editOfficeAccount(Request $request) {
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $officeAccount = $this->AdminInterface->getOfficeAccount($request);
        return view('modals.admin.edit.edit-office-account-modal', compact('offices', 'sections', 'officeAccount'));
       
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateOfficeAccount(Request $request) {
        $this->AdminInterface->updateOfficeAccount($request);
        return response()->json([
            'Message' => 'Office Account updated successfully',
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteOfficeAccount(Request $request) {
        $this->AdminInterface->deleteOfficeAccount($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $officeAccounts = $this->AdminInterface->getOfficeAccounts();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Office Account deleted successfully',
            'OfficeAccount' => view('data.office-account-data', compact('offices', 'sections', 'aes', 'officeAccounts'))->render()
        ], Response::HTTP_OK);
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createUserAccount(Request $request) {
        $status = $this->AdminInterface->createUserAccount($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $userAccounts = $this->AdminInterface->getUserAccounts();
        $aes = $this->aes;
        return response()->json([
            'UserAccount' => view('data.user-account-data', compact('offices', 'sections', 'aes', 'userAccounts'))->render()
        ], $status);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateUserAccount(Request $request) {
        $status = $this->AdminInterface->updateUserAccount($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $userAccounts = $this->AdminInterface->getUserAccounts();
        $aes = $this->aes;
        return response()->json([
            'UserAccount' => view('data.user-account-data', compact('offices', 'sections', 'aes', 'userAccounts'))->render()
        ], $status);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteUserAccount(Request $request) {
        $this->AdminInterface->deleteUserAccount($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $userAccounts = $this->AdminInterface->getUserAccounts();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'User Account deleted successfully',
            'UserAccount' => view('data.user-account-data', compact('offices', 'sections', 'aes', 'userAccounts'))->render()
        ], Response::HTTP_OK);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createDocumentType(Request $request) {
        $this->AdminInterface->createDocumentType($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $docType = $this->AdminInterface->getDocType();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document Type created sucessfully',
            'DocumentType' => view('data.document-type-data', compact('offices', 'sections', 'aes', 'docType'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateDocumentType(Request $request) {
        $this->AdminInterface->updateDocumentType($request);
        return response()->json([
            'Message' => 'Document Type updated sucessfully',
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteDocumentType(Request $request) {
        $this->AdminInterface->deleteDocumentType($request);
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $docType = $this->AdminInterface->getDocType();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document Type deleted sucessfully',
            'DocumentType' => view('data.document-type-data', compact('offices', 'sections', 'aes', 'docType'))->render()
        ], Response::HTTP_OK);
    }

    public function viewOfficeDocument(Request $request) {
        $documents = $this->AdminInterface->getDocuments($request);
        $tracker = $this->AdminInterface->getDocumentTracker();
        $offices = $this->AdminInterface->getOffices();
        $sections = $this->AdminInterface->getSections();
        $docType = $this->AdminInterface->getDocType();
        $office = $this->AdminInterface->office($request);
        return view('pages.admin.office-documents', compact('docType', 'tracker','offices', 'sections', 'documents', 'office'));
    }
}
