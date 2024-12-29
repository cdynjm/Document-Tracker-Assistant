<?php

namespace App\Repositories\Implementation;

use Hash;
use Session;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interfaces\OfficeInterface;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\Documents;
use App\Models\Sections;
use App\Models\Logs;
use App\Models\ReturnedLogs;
use App\Models\ReceivedLogs;
use App\Models\DocumentType;

class OfficeRepository implements OfficeInterface { 
    protected $aes;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function __construct(AESCipher $aes) {
        $this->aes = $aes;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getOffices() {
        return Offices::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getSections() {
        return Sections::get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getTracker() {
        return Tracker::get();
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getLogs() {
        return Logs::where(['userID' => Auth::user()->id])->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getReturnedLogs() {
        return ReturnedLogs::where(['userID' => Auth::user()->id])->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocuments() {
        return Documents::with('type')->where(['userID' => Auth::user()->id])
                    ->where(['status' => 1])
                    ->orderBy('updated_at', 'DESC')->get()
                    ->groupBy('type.name');
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        return Documents::where(['id' => $qrcodeID])->first();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocType() {
        return DocumentType::get();
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getArchives() {
        return Documents::with('type')->where(['userID' => Auth::user()->id])
                    ->where(['status' => 0])
                    ->orderBy('created_at', 'DESC')->get()
                    ->groupBy('type.name');
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createQRCode($request) {

        $type = DocumentType::where('id', $this->aes->decrypt($request->docType))->first();

        for($count = 0; $count < $request->quantity; $count++) {
            $document = Documents::create([
                'qrcode' => \Str::slug(Carbon::now()->addSeconds($count)."-".Auth::user()->name."-".$type->name.'-'.$request->extension),
                'trackerID' => 0,
                'officeID' => Auth::user()->officeID,
                'userID' => Auth::user()->id,
                'remarks' => null,
                'docType' => $this->aes->decrypt($request->docType),
                'status' => 1
            ]);

            Logs::create([
                'documentID' => $document->id,
                'trackerID' => $document->trackerID,
                'officeID' => Auth::user()->officeID,
                'userID' => Auth::user()->id
            ]);
        }
    }
    
    public function renameQRCode($request) {
        // Decrypt the document ID
        $documentId = $this->aes->decrypt($request->id);
        
        // Find the current document to get its existing QR code name
        $currentDocument = Documents::findOrFail($documentId);
        
        // Check if the new code already exists for other documents
        $existingDocument = Documents::where('qrcode', \Str::slug($request->code))
            ->where('id', '!=', $documentId)
            ->exists();
        
        if ($existingDocument) {
            // If the code exists for another document, return 500
            return 500;
        }
        
        $currentDocument->timestamps = false;
        $currentDocument->update([
            'qrcode' => \Str::slug($request->code)
        ]);
        $currentDocument->timestamps = true;
        
        // Return success response
        return 200;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        $get = Documents::where(['id' => $qrcodeID])->first();
        Documents::where(['id' => $qrcodeID])->update([
            'trackerID' => $get->trackerID + 1,
            'pending' => 1,
            'remarks' => null
        ]);

        $logs = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID + 1])
                ->count();

        if($logs != 0) {
            Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID + 1])
                ->update([
                    'documentID' => $qrcodeID,
                   
                ]);
        }
        else {
            Logs::create([
                'documentID' => $qrcodeID,
                'trackerID' => $get->trackerID + 1,
                'officeID' => $get->officeID,
                'userID' => Auth::user()->id,
                'updated_at' => null
            ]);
        }

        $section = Tracker::where('docType', $get->docType)
                ->where('trackerID', $get->trackerID + 1)
                ->first();

      ReceivedLogs::create([
            'documentID' => $qrcodeID,
            'sectionID' => $section->sectionID,
            'userID' => Auth::user()->id,
            'username' => Auth::user()->name,
            'pending' => 1
        ]); 
       
    }

    public function forwardDocumentAgain($request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        $get = Documents::where(['id' => $qrcodeID])->first();
        Documents::where(['id' => $qrcodeID])->update([
            'trackerID' => $request->trackerID,
            'pending' => 1,
            'remarks' => null
        ]);

        $logs = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $request->trackerID])
                ->count();

        if($logs != 0) {
            
            Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $request->trackerID])
                ->update([
                    'documentID' => $qrcodeID,
                    'updated_at' => null,
                ]);

            $latestLogReceivedCreated = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $request->trackerID + 1])->first();

            if ($latestLogReceivedCreated) {
                $latestLogReceivedCreated->timestamps = false;
                $latestLogReceivedCreated->update([
                        'documentID' => $qrcodeID,
                        'created_at' => null
                    ]);
                $latestLogReceivedCreated->timestamps = true;
            }

        }
        else {
            Logs::create([
                'documentID' => $qrcodeID,
                'trackerID' => $get->trackerID + 1,
                'officeID' => $get->officeID,
                'userID' => Auth::user()->id,
                'updated_at' => null
            ]);
        }

        $section = Tracker::where('docType', $get->docType)
                ->where('trackerID', $request->trackerID)
                ->first();

      ReceivedLogs::create([
            'documentID' => $qrcodeID,
            'sectionID' => $section->sectionID,
            'userID' => Auth::user()->id,
            'username' => Auth::user()->name,
            'pending' => 1
        ]); 
       
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardSelectedDocument($request) {

        foreach($request->id as $key => $value) {
            $qrcodeID = $this->aes->decrypt($value);
            $get = Documents::where(['id' => $qrcodeID])->first();
            Documents::where(['id' => $qrcodeID])->update([
                'trackerID' => $get->trackerID + 1,
                'remarks' => null
            ]);
    
            $logs = Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->count();
    
            if($logs != 0) {
                Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->update([
                        'documentID' => $qrcodeID,
                    ]);
            }
            else {
                Logs::create([
                    'documentID' => $qrcodeID,
                    'trackerID' => $get->trackerID + 1,
                    'officeID' => $get->officeID,
                    'userID' => Auth::user()->id,
                    'updated_at' => null
                ]);
            }

            $section = Tracker::where('docType', $get->docType)
            ->where('trackerID', $get->trackerID + 1)
            ->first();

         ReceivedLogs::create([
                'documentID' => $qrcodeID,
                'sectionID' => $section->sectionID,
                'userID' => Auth::user()->id,
                'username' => Auth::user()->name,
                'pending' => 1
            ]); 
        }
       
    }
    /**
    * Handle an incoming request.
    *
    * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    */
    public function deleteQRCode($request) {
        $qrcodeID = $this->aes->decrypt($request->id);
        Documents::where(['id' => $qrcodeID])->delete();
    } 
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateAccountInformation($request) {
       
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')->ignore(Auth::user()->id)
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        User::where(['id' => Auth::user()->id])->update([
            'name' => $request->name,
            'email' => $request->email
        ]);
        
        if(!empty($request->password))
            User::where(['id' => Auth::user()->id])->update(['password' => Hash::make($request->password)]);

        return Response::HTTP_OK;
     }

     public function getOffice($request) {

        $documents = Documents::where('id', $this->aes->decrypt($request->documentID))->first();
  
        $latest = Logs::where('documentID', $this->aes->decrypt($request->documentID))
        ->orderBy('trackerID', 'DESC')
        ->first();

        return Tracker::with('sectionstrack') // Eager load the 'sectionstrack' relationship
        ->where('docType', $this->aes->decrypt($request->docType)) // Decrypt docType
        ->where('trackerID', '<=', $latest->trackerID) // Filter by trackerID less than or equal to the latest
        ->whereHas('Section', function ($query) {
            $query->where('section', 'like', '%receiver%')
                  ->orWhere('section', 'like', '%receive%')
                  ->orWhere('section', 'like', '%receiving%')
                  ->orWhere('section', 'like', '%reciever%')
                  ->orWhere('section', 'like', '%recieve%')
                  ->orWhere('section', 'like', '%recieving%'); // Add conditions for the Section
        })
       /* ->whereIn('trackerID', function ($query) use ($latest) {
            $query->selectRaw('MIN(trackerID)') // Select the first trackerID for each sectionID
                  ->from('tracker') // Use the 'trackers' table
                  ->where('trackerID', '<=', $latest->trackerID) // Apply the trackerID constraint in the subquery
                  ->groupBy('sectionID'); // Group by sectionID
        }) */
        ->orderBy('trackerID', 'ASC') // Order the results by trackerID in ascending order
        ->get();
       }

       public function scanDocument($request) {

        $verify = Documents::where('qrcode', $request->documentID)->first();
        $tracker = Tracker::where(['docType' => $verify->docType])->orderBy('trackerID', 'ASC')->get();

        $sourceOffice = ReceivedLogs::where('documentID', $verify->id)
            ->where('pending', 1)
            ->where('sectionID', null)
            ->latest('updated_at')
            ->first();

        $scan = false;
       
        if($verify->trackerID == 0 && $verify->officeID == Auth::user()->officeID) {
            $scan = true;
        }


        if($sourceOffice) {
            if($verify->pending == 1) {
                Documents::where('qrcode', $request->documentID)->update([
                    'pending' => 0
                ]);
            }
            else {
                return 201;
            }

            $latestLogReceived = Logs::where('documentID', $verify->id)
                    ->where('trackerID', $verify->trackerID)
                    ->first();

            if ($latestLogReceived) {
                $latestLogReceived->update([
                   // 'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            $latestLognull = ReceivedLogs::where('documentID', $verify->id)
            ->where('sectionID', null)
            ->latest('updated_at')
            ->first();
        
             if ($latestLognull) {
                 $latestLognull->update([
                     'pending' => 0,
                     'created_at' => Carbon::now(),
                     'updated_at' => Carbon::now(),
                 ]);
             }

             return 200;

        }

        if($scan == true) {

            if($verify->pending == 1) {
                Documents::where('qrcode', $request->documentID)->update([
                    'pending' => 0
                ]);
            }
            else {
                return 201;
            }
    
           $documents =  Documents::where('qrcode', $request->documentID)->first();

           $latestLogReceived = Logs::where('documentID', $documents->id)
                    ->where('trackerID', $documents->trackerID)
                    ->first();

            if ($latestLogReceived) {
                $latestLogReceived->update([
                   // 'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            $latestLogReturned = ReturnedLogs::where('documentID', $documents->id)
                    ->where('trackerID', $documents->trackerID)
                    ->orderBy('created_at', 'DESC')
                    ->first();

            if ($latestLogReturned) {
                $latestLogReturned->update([
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
           
            return 200;
        }
        else {
            return 500;
        }
     }
}

?>