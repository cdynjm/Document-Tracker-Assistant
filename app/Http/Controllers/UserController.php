<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

use App\Models\Documents;
//INTERFACES:
use App\Repositories\Interfaces\UserInterface; 

class UserController extends Controller
{
    protected $aes;
    protected $UserInterface;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes, UserInterface $UserInterface) {
        $this->aes = $aes;
        $this->UserInterface = $UserInterface;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard(Request $request) {
        $receivedLogs = $this->UserInterface->getReceivedLogs();
        $user = $this->UserInterface->userLogsHistory();

        $allDocuments = $this->UserInterface->getAllDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $sections = $this->UserInterface->getSections();

        return view('pages.user.user-dashboard', compact('receivedLogs', 'user', 'tracker', 'sections', 'allDocuments'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getReceivedLogsByDate(Request $request) {
        $receivedLogs = $this->UserInterface->getReceivedLogsByDate($request);
        $aes = $this->aes;
        return response()->json([
            'Logs' => view('data.received-logs-data', compact('receivedLogs', 'aes'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function profile() {
        return view('pages.user.profile');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAccountInformation(Request $request) {
        $status = $this->UserInterface->updateAccountInformation($request);
        return response()->json(['Message' => 'Account information updated successfully'], $status);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function offices(Request $request) {

        if(Auth::user()->special == null) {

            $documents = $this->UserInterface->getDocuments($request);
            $tracker = $this->UserInterface->getTracker($request);
            $offices = $this->UserInterface->getOffices($request);
            $sections = $this->UserInterface->getSections();
            return view('pages.user.offices', compact('tracker','offices', 'sections', 'documents'));

        }
        else {
            return abort(404);
        }
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardDocument(Request $request) {
        $this->UserInterface->forwardDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $allDocuments = $this->UserInterface->getAllDocuments($request);
        $toBeBatch = $this->UserInterface->getDocumentsDownload();
        $documentCount = $this->UserInterface->getDocumentCount($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document forwarded/completed successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'allDocuments' => view('data.all-pending-documents-data', compact('tracker', 'sections', 'aes', 'allDocuments'))->render(),
            'batchDocuments' => view('data.to-be-batched-documents', compact('tracker', 'toBeBatch'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documentCount'))->render()
        ], Response::HTTP_OK);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardSelectedDocument(Request $request) {
        $this->UserInterface->forwardSelectedDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Documents forwarded/completed successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnDocument(Request $request) {
        $this->UserInterface->returnDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $allDocuments = $this->UserInterface->getAllDocuments($request);
        $documentCount = $this->UserInterface->getDocumentCount($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document returned successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'allDocuments' => view('data.all-pending-documents-data', compact('tracker', 'sections', 'aes', 'allDocuments'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documents', 'documentCount'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnSelectedDocument(Request $request) {
        $this->UserInterface->returnSelectedDocument($request);
        $documents = $this->UserInterface->getDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $offices = $this->UserInterface->getOffices($request);
        $sections = $this->UserInterface->getSections();
        $dataID = $request->dataID;
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document returned successfully',
            'documentTracker' => view('data.document-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render(),
            'count' => view('data.count-data', compact('dataID', 'tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }

    public function scanDocument(Request $request) {
        $response = $this->UserInterface->scanDocument($request);
        return response()->json([
            'res' => $response,
            'Message' => 'Document Received Successfully! The site will reload to retrieve the new data.'
        ], $response);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function userLogsHistoryByDate(Request $request) {
        $user = $this->UserInterface->userLogsHistoryByDate($request);
        $aes = $this->aes;
        return response()->json([
            'Logs' => view('data.forwarded-logs-data', compact('user', 'aes'))->render()
        ], Response::HTTP_OK);
    }

    public function getOffice(Request $request) {
        $office = $this->UserInterface->getOffice($request);
        return response()->json([
            'Office' => $office
        ], Response::HTTP_OK);
    }

    public function batchDocuments(Request $request) {
        $toBeBatch = $this->UserInterface->getDocumentsDownload();
        $batchDocuments = $this->UserInterface->getBatchedDocuments();
        $tracker = $this->UserInterface->getTracker($request);
        return view('pages.user.batch-documents', compact('tracker', 'toBeBatch', 'batchDocuments'));
    }

    public function editBatchDocuments(Request $request) {
        $toBeBatch = $this->UserInterface->editBatchedDocuments($request);
        $tracker = $this->UserInterface->getTracker($request);
        $batchName = Documents::where('id', $this->aes->decrypt($request->id))->first();
        
        return view('pages.user.edit-batch-documents', compact('tracker', 'toBeBatch', 'batchName'));
    }

    public function batchSelectedDocuments(Request $request) {
        $this->UserInterface->batchSelectedDocuments($request);
        return response()->json([
            'Message' => 'Documents batched successfully!'
        ], 200);
    }

    public function insertToExistingBatch(Request $request) {
        $this->UserInterface->insertToExistingBatch($request);
        return response()->json(['Message' => 'Document inserted successfully'], 200);
    }

    public function updateBatchSelectedDocuments(Request $request) {
        $status = $this->UserInterface->updateBatchSelectedDocuments($request);
        return response()->json([
            'Message' => 'Documents batched updated successfully!'
        ], $status);
    }

    public function forwardBatchDocument(Request $request) {
        $this->UserInterface->forwardBatchDocument($request);
        return response()->json([
            'Message' => 'Batch Document forwarded successfully!'
        ], 200);
    }
}
