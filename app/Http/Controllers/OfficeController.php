<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACES:
use App\Repositories\Interfaces\OfficeInterface;  

use App\Models\Documents;
use App\Models\Tracker;

class OfficeController extends Controller
{
    protected $aes;
    protected $OfficeInterface;


    public function trackDocument(Request $request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        $doc = Documents::where(['id' => $qrcodeID])->first();
        $tracker = Tracker::where('docType', $doc->docType)->get();
        return view('pages.track-document', ['doc' => $doc, 'tracker' => $tracker]);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes, OfficeInterface $OfficeInterface) {
        $this->aes = $aes;
        $this->OfficeInterface = $OfficeInterface;
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function dashboard() {
        $documents = $this->OfficeInterface->getDocuments();
        $tracker = $this->OfficeInterface->getTracker();
        $offices = $this->OfficeInterface->getOffices();
        $sections = $this->OfficeInterface->getSections();
        $docType = $this->OfficeInterface->getDocType();
        return view('pages.office.office-dashboard', compact('docType', 'tracker','offices', 'sections', 'documents'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function profile() {
        return view('pages.office.profile');
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAccountInformation(Request $request) {
        $status = $this->OfficeInterface->updateAccountInformation($request);
        return response()->json(['Message' => 'Account information updated successfully'], $status);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function officeDocumentTracker(Request $request) {
        $documents = $this->OfficeInterface->getDocument($request);
       // $request->session()->put('id', $request->id);
       // $request->session()->put('docType', $this->aes->encrypt($documents->docType));
        $docID = $request->id;
        $docType = $this->aes->encrypt($documents->docType);
        return view('pages.office.office-document-tracker', compact('documents', 'docID', 'docType'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function archives() {
        $documents = $this->OfficeInterface->getArchives();
        $tracker = $this->OfficeInterface->getTracker();
        $offices = $this->OfficeInterface->getOffices();
        $sections = $this->OfficeInterface->getSections();
        return view('pages.office.archives', compact('tracker','offices', 'sections', 'documents'));
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createQRCode(Request $request) {
        $this->OfficeInterface->createQRCode($request);
        $documents = $this->OfficeInterface->getDocuments();
        $tracker = $this->OfficeInterface->getTracker();
        $offices = $this->OfficeInterface->getOffices();
        $sections = $this->OfficeInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'QR Code generated successfully',
            'documentTracker' => view('data.document-tracker-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function renameQRCode(Request $request) {
        $status = $this->OfficeInterface->renameQRCode($request);
        $documents = $this->OfficeInterface->getDocuments();
        $tracker = $this->OfficeInterface->getTracker();
        $offices = $this->OfficeInterface->getOffices();
        $sections = $this->OfficeInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'QR Code renamed successfully',
            'documentTracker' => view('data.document-tracker-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], $status);
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardDocument(Request $request) {
        $this->OfficeInterface->forwardDocument($request);
        $documents = $this->OfficeInterface->getDocuments();
        $tracker = $this->OfficeInterface->getTracker();
        $offices = $this->OfficeInterface->getOffices();
        $sections = $this->OfficeInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Document forwarded successfully',
            'documentTracker' => view('data.document-tracker-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }
    /* Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
   public function forwardDocumentAgain(Request $request) {
       $this->OfficeInterface->forwardDocumentAgain($request);
       $documents = $this->OfficeInterface->getDocuments();
       $tracker = $this->OfficeInterface->getTracker();
       $offices = $this->OfficeInterface->getOffices();
       $sections = $this->OfficeInterface->getSections();
       $aes = $this->aes;
       return response()->json([
           'Message' => 'Document forwarded successfully',
           'documentTracker' => view('data.document-tracker-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render()
       ], Response::HTTP_OK);
   }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardSelectedDocument(Request $request) {
        $this->OfficeInterface->forwardSelectedDocument($request);
        $documents = $this->OfficeInterface->getDocuments();
        $tracker = $this->OfficeInterface->getTracker();
        $offices = $this->OfficeInterface->getOffices();
        $sections = $this->OfficeInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'Documents forwarded successfully',
            'documentTracker' => view('data.document-tracker-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteQRCode(Request $request) {
        $this->OfficeInterface->deleteQRCode($request);
        $documents = $this->OfficeInterface->getDocuments();
        $tracker = $this->OfficeInterface->getTracker();
        $offices = $this->OfficeInterface->getOffices();
        $sections = $this->OfficeInterface->getSections();
        $aes = $this->aes;
        return response()->json([
            'Message' => 'QR Code deleted successfully',
            'documentTracker' => view('data.document-tracker-data', compact('tracker','offices', 'sections', 'aes', 'documents'))->render()
        ], Response::HTTP_OK);
    }

    public function getOffice(Request $request) {
        $office = $this->OfficeInterface->getOffice($request);
        return response()->json([
            'Office' => $office
        ], Response::HTTP_OK);
    }

    public function scanDocument(Request $request) {
        $response = $this->OfficeInterface->scanDocument($request);
        return response()->json([
            'res' => $response,
            'Message' => 'Document Received Successfully! The site will reload to retrieve the new data.'
        ], $response);
    }

}
