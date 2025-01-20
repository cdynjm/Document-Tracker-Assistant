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
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interfaces\UserInterface;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\TrackerCompleted;
use App\Models\Documents;
use App\Models\Sections;
use App\Models\Logs;
use App\Models\ReturnedLogs;
use App\Models\ReceivedLogs;
use App\Models\DataAnalytics;

class UserRepository implements UserInterface {
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
    public function getOffices($request) {
        $userID = $this->aes->decrypt($request->id);
        return User::where(['id' => $userID])->first();
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
    public function getTracker($request) {
        return Tracker::get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getDocuments($request) {
        $userID = $this->aes->decrypt($request->id);
        return Documents::with('type')->where(['userID' => $userID])
                    ->where(['status' => 1])
                    ->where('pending', 0)
                    ->where('download', null)
                    ->orderBy('created_at', 'DESC')->get()
                    ->groupBy('type.name');
     }

     public function getAllDocuments($request) {
        return Documents::with(['type', 'User'])
                    ->where(['status' => 1])
                    ->where('pending', 0)
                    ->where('download', null)
                    ->orderBy('created_at', 'DESC')->get()
                    ->groupBy('type.name');
     }

     public function getDocumentsDownload() {
       
        return Documents::with('type')
                    ->where(['status' => 1])
                    ->where('pending', 0)
                    ->where('download', null)
                    ->orderBy('created_at', 'DESC')->get()
                    ->groupBy('type.name');
     }

     public function getBatchedDocuments() {
       
        return Documents::with('type')->where(['status' => 1])
                    ->where('pending', 0)
                    ->where('merged', 1)
                    ->where('download', 1)
                    ->orderBy('created_at', 'DESC')->get()
                    ->groupBy('type.name');
     }

     public function editBatchedDocuments($request) {
       
        return Documents::with('type')->where('batchID', $this->aes->decrypt($request->id))
                  
        ->orderByDesc('created_at')
        ->get()
        ->groupBy('type.name');
    
     }

     public function getDocumentCount($request) {
        $userID = $this->aes->decrypt($request->id);
        return Documents::where(['userID' => $userID])
                    ->where(['status' => 1])
                    ->where('pending', 0)
                    ->where('download', null)
                    ->orderBy('created_at', 'DESC')->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getReceivedLogs() {
        return ReceivedLogs::where(['sectionID' => Auth::user()->Section->id])
            ->where('created_at', 'like', '%'.date('Y-m-d').'%')
            ->where('pending', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getReceivedLogsByDate($request) {
        return ReceivedLogs::where(['sectionID' => Auth::user()->Section->id])
            ->where('created_at', 'like', '%'.$request->date.'%')
            ->where('pending', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->documentID);
        $userID = $this->aes->decrypt($request->id);
        $get = Documents::where(['id' => $qrcodeID])->first();
        $tracker = Tracker::where(['docType' => $get->docType])
                ->orderBy('trackerID', 'DESC')
                ->first();

        if($tracker->trackerID != $get->trackerID) {
            Documents::where(['id' => $qrcodeID])->update([
                'trackerID' => $get->trackerID + 1,
                'pending' => 1,
                'remarks' => null
            ]);
        }
        else {
            Documents::where(['id' => $qrcodeID])->update([
                'trackerID' => $get->trackerID + 1,
                'status' => 0,
                'remarks' => 'Done'
            ]);

            $trackerCompleted = Tracker::where(['docType' => $get->docType])
                    ->orderBy('trackerID', 'ASC')
                    ->get();
                
                foreach($trackerCompleted as $tc) {
                    TrackerCompleted::create([
                        'documentID' => $qrcodeID,
                        'trackerID' => $tc->trackerID,
                        'sectionID' => $tc->sectionID,
                        'officeID' => $tc->officeID,
                        'userID' => $tc->userID,
                        'docType' => $tc->docType
                    ]);
                }

            
        }

        
        $logs = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID + 1])
                ->count();

        $logsDataAnalytics = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID])
                ->first();

        DataAnalytics::where('logID', $logsDataAnalytics->id)->orderBy('created_at', 'desc')->first()
        ?->update(['forward_return' => Carbon::now()]);

        $section = Tracker::where('docType', $get->docType)
            ->where('trackerID', $get->trackerID + 1)
            ->first();

        if($logs != 0) {

            if($tracker->trackerID != $get->trackerID) {
                Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->update([
                        'documentID' => $qrcodeID,
                        'created_at' => Carbon::now(),
                        'updated_at' => null
                    ]);

                
                $latestLogReceivedCreated = Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 2])->first();
    
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
                Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID + 1])
                ->update([
                    'documentID' => $qrcodeID,
                ]);   
            }
            
        }
        else {
            if($tracker->trackerID != $get->trackerID) {
                Logs::create([
                    'documentID' => $qrcodeID,
                    'trackerID' => $get->trackerID + 1,
                    'officeID' => $get->officeID,
                    'userID' => $get->userID,
                    'sectionID' => $section->sectionID,
                    'updated_at' => null
                ]);
            }
            else {
                Logs::create([
                    'documentID' => $qrcodeID,
                    'trackerID' => $get->trackerID + 1,
                    'officeID' => $get->officeID,
                    'userID' => $get->userID,
                ]);
            }
        }

        if($section != null ) {
            ReceivedLogs::create([
                'documentID' => $qrcodeID,
                'officeID' => Auth::user()->Section->id,
                'sectionID' => $section->sectionID,
                'userID' => $userID,
                'username' => Auth::user()->name,
                'usernameID' => Auth::user()->id,
                'pending' => 1
            ]);
        } 
        
    }


    public function forwardBatchDocument($request) {

        $qrcodeID = $this->aes->decrypt($request->documentID);

        
        Documents::where(['id' => $qrcodeID])->update([
            'trackerID' => Documents::where(['id' => $qrcodeID])->first()->trackerID + 1,
            'pending' => 1
        ]);

        foreach(Documents::where(['batchID' => $qrcodeID])->get() as $get) {

            $tracker = Tracker::where(['docType' => $get->docType])
                    ->orderBy('trackerID', 'DESC')
                    ->first();

            if($tracker->trackerID != $get->trackerID) {
                Documents::where(['id' => $get->id])->update([
                    'trackerID' => $get->trackerID + 1,
                    'pending' => 1,
                    'remarks' => null
                ]);
            }
            else {
                Documents::where(['id' => $get->id])->update([
                    'trackerID' => $get->trackerID + 1,
                    'status' => 0,
                    'remarks' => 'Done'
                ]);

                Documents::where(['id' => $qrcodeID])->update([
                    'status' => 0,
                    'pending' => 0,
                    'remarks' => 'Done'
                ]);

                $trackerCompleted = Tracker::where(['docType' => $get->docType])
                    ->orderBy('trackerID', 'ASC')
                    ->get();
                
                foreach($trackerCompleted as $tc) {
                    TrackerCompleted::create([
                        'documentID' => $get->id,
                        'trackerID' => $tc->trackerID,
                        'sectionID' => $tc->sectionID,
                        'officeID' => $tc->officeID,
                        'userID' => $tc->userID,
                        'docType' => $tc->docType
                    ]);
                }

            }

            $logs = Logs::where(['documentID' => $get->id])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->count();

            $logsDataAnalytics = Logs::where(['documentID' => $get->id])
            ->where(['trackerID' => $get->trackerID])
            ->first();
    
            DataAnalytics::where('logID', $logsDataAnalytics->id)->orderBy('created_at', 'desc')->first()
            ?->update(['forward_return' => Carbon::now()]);

            if($logs != 0) {

                if($tracker->trackerID != $get->trackerID) {
                    Logs::where(['documentID' => $get->id])
                        ->where(['trackerID' => $get->trackerID + 1])
                        ->update([
                            'documentID' => $get->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => null
                        ]);

                    
                    $latestLogReceivedCreated = Logs::where(['documentID' => $get->id])
                        ->where(['trackerID' => $get->trackerID + 2])->first();
        
                    if ($latestLogReceivedCreated) {
                        $latestLogReceivedCreated->timestamps = false;
                        $latestLogReceivedCreated->update([
                                'documentID' => $get->id,
                                'created_at' => null
                            ]);
                        $latestLogReceivedCreated->timestamps = true;
                    }
                }
                else {
                    Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->update([
                        'documentID' => $get->id,
                    ]);   
                }
                
            }
            else {
                if($tracker->trackerID != $get->trackerID) {
                    Logs::create([
                        'documentID' => $get->id,
                        'trackerID' => $get->trackerID + 1,
                        'officeID' => $get->officeID,
                        'userID' => $get->userID,
                        'updated_at' => null
                    ]);
                }
                else {
                    Logs::create([
                        'documentID' => $get->id,
                        'trackerID' => $get->trackerID + 1,
                        'officeID' => $get->officeID,
                        'userID' => $get->userID,
                    ]);
                }
            }

            $section = Tracker::where('docType', $get->docType)
                ->where('trackerID', $get->trackerID + 1)
                ->first();

            if($section != null ) {
                ReceivedLogs::create([
                    'documentID' => $get->id,
                    'officeID' => Auth::user()->Section->id,
                    'sectionID' => $section->sectionID,
                    'userID' => $get->userID,
                    'username' => Auth::user()->name,
                    'usernameID' => Auth::user()->id,
                    'pending' => 1
                ]);
            } 
        }

    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function forwardSelectedDocument($request) {
        foreach($request->documentID as $key => $value) {
            $qrcodeID = $this->aes->decrypt($value);
            $userID = $this->aes->decrypt($request->id);
            $get = Documents::where(['id' => $qrcodeID])->first();
            $tracker = Tracker::where(['docType' => $get->docType])
                    ->orderBy('trackerID', 'DESC')
                    ->first();
    
            if($tracker->trackerID != $get->trackerID) {
                Documents::where(['id' => $qrcodeID])->update([
                    'trackerID' => $get->trackerID + 1,
                    'pending' => 1,
                    'remarks' => null
                ]);
            }
            else {
                Documents::where(['id' => $qrcodeID])->update([
                    'trackerID' => $get->trackerID + 1,
                    'status' => 0,
                    'remarks' => 'Done'
                ]);
            }
            $logs = Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->count();
    
            if($logs != 0) {
                if($tracker->trackerID != $get->trackerID) {
                    Logs::where(['documentID' => $qrcodeID])
                        ->where(['trackerID' => $get->trackerID + 1])
                        ->update([
                            'documentID' => $qrcodeID,
                            'created_at' => Carbon::now(),
                            'updated_at' => null
                        ]);

                $latestLogReceivedCreated = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID + 2])->first();
    
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
                    Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID + 1])
                    ->update([
                        'documentID' => $qrcodeID,
                    ]);   
                }
            }
            else {
                if($tracker->trackerID != $get->trackerID) {
                    Logs::create([
                        'documentID' => $qrcodeID,
                        'trackerID' => $get->trackerID + 1,
                        'officeID' => $get->officeID,
                        'userID' => $get->userID,
                        'updated_at' => null
                    ]);
                }
                else {
                    Logs::create([
                        'documentID' => $qrcodeID,
                        'trackerID' => $get->trackerID + 1,
                        'officeID' => $get->officeID,
                        'userID' => $get->userID,
                    ]);
                }
            }

            $section = Tracker::where('docType', $get->docType)
                ->where('trackerID', $get->trackerID + 1)
                ->first();

            if($section != null ) {
                ReceivedLogs::create([
                    'documentID' => $qrcodeID,
                    'officeID' => Auth::user()->Section->id,
                    'sectionID' => $section->sectionID,
                    'userID' => $userID,
                    'username' => Auth::user()->name,
                    'usernameID' => Auth::user()->id,
                    'pending' => 1
                ]);
                }
        }
        
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnDocument($request) {
        $qrcodeID = $this->aes->decrypt($request->documentID);
        $userID = $this->aes->decrypt($request->id);
        
        $get = Documents::where(['id' => $qrcodeID])->first();

        $logsDataAnalytics = Logs::where(['documentID' => $qrcodeID])
        ->where(['trackerID' => $get->trackerID])
        ->first();

        DataAnalytics::where('logID', $logsDataAnalytics->id)->orderBy('created_at', 'desc')->first()
            ?->update(['forward_return' => Carbon::now()]);

        $tracker = Tracker::where(['docType' => $get->docType])->orderBy('trackerID', 'DESC')->first();
        Documents::where(['id' => $qrcodeID])->update(['trackerID' => $request->office]);
        
        $reason = "
            <div class='mt-2'>
                Returned by: 
            </div>
            <div class='mt-0 text-dark'>
                ".Auth::user()->Section->Office->office."
            </div>
            <div class='mt-0 text-dark'>
                ".Auth::user()->Section->section."
            </div>
            <div>
                Reason: ".$request->reason."
            </div>";
        
        $remarks = $get->remarks . $reason;
        Documents::where(['id' => $qrcodeID])->update([
            'remarks' => $remarks,
            'pending' => 1
        ]);


        $logs = Logs::where(['documentID' => $qrcodeID])
            ->where(['trackerID' => $request->office])
            ->count();

        if($logs != 0) {
            Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $request->office])
                ->update([
                    'documentID' => $qrcodeID,
                    'updated_at' => null
                ]);
        }
        else {
            $lo = Logs::create([
                'documentID' => $qrcodeID,
                'trackerID' => $request->office,
                'officeID' => $get->officeID,
                'userID' => $get->userID,
                'updated_at' => null
            ]);
        }

        $ret = ReturnedLogs::create([
            'documentID' => $qrcodeID,
            'trackerID' => $request->office,
            'officeID' => $get->officeID,
            'userID' => $get->userID,
            'remarks' => $reason,
            'updated_at' => null
        ]);
        
        $section = Tracker::where('docType', $get->docType)
                ->where('trackerID', $request->office)
                ->first();
                
        if($section != null ) {
            ReceivedLogs::create([
                'documentID' => $qrcodeID,
                'officeID' => Auth::user()->Section->id,
                'sectionID' => $section->sectionID,
                'userID' => $userID,
                'username' => Auth::user()->name
            ]);
        }
    }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function returnSelectedDocument($request) {

        foreach($request->documentID as $key => $value) {
            $qrcodeID = $this->aes->decrypt($value);
            $userID = $this->aes->decrypt($request->id);
            
            $get = Documents::where(['id' => $qrcodeID])->first();
            $tracker = Tracker::where(['docType' => $get->docType])->orderBy('trackerID', 'DESC')->first();
            Documents::where(['id' => $qrcodeID])->update(['trackerID' => $get->trackerID - 1]);
            
            $reason = "
                <div class='mt-2'>
                    Returned by: 
                </div>
                <div class='mt-0 text-dark'>
                    ".Auth::user()->Section->Office->office."
                </div>
                <div class='mt-0 text-dark'>
                    ".Auth::user()->Section->section."
                </div>
                <div>
                    Reason: ".$request->reason."
                </div>";
            
            $remarks = $get->remarks . $reason;
            Documents::where(['id' => $qrcodeID])->update([
                'remarks' => $remarks
            ]);

            $logs = Logs::where(['documentID' => $qrcodeID])
                ->where(['trackerID' => $get->trackerID - 1])
                ->count();

            if($logs != 0) {
                Logs::where(['documentID' => $qrcodeID])
                    ->where(['trackerID' => $get->trackerID - 1])
                    ->update([
                        'documentID' => $qrcodeID,
                    ]);
            }
            else {
                Logs::create([
                    'documentID' => $qrcodeID,
                    'trackerID' => $get->trackerID + 1,
                    'officeID' => $get->officeID,
                    'userID' => $get->userID
                ]);
            }

            ReturnedLogs::create([
                'documentID' => $qrcodeID,
                'trackerID' => $get->trackerID - 1,
                'officeID' => $get->officeID,
                'userID' => $get->userID,
                'remarks' => $reason
            ]);

            $section = Tracker::where('docType', $get->docType)
                ->where('trackerID', $get->trackerID - 1)
                ->first();

            if($section != null ) {
                ReceivedLogs::create([
                    'documentID' => $qrcodeID,
                    'officeID' => Auth::user()->Section->id,
                    'sectionID' => $section->sectionID,
                    'userID' => $userID,
                    'username' => Auth::user()->name
                ]);
            }
        }
        
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

     public function scanDocument($request) {

        $verify = Documents::where('qrcode', $request->documentID)->first();
        $tracker = Tracker::where(['docType' => $verify->docType])->orderBy('trackerID', 'ASC')->get();
        $scan = false;


        if($verify->merged == 1) {

            foreach($tracker as $tr) {

                if($tr->sectionID != null) {
                    if($verify->trackerID == $tr->trackerID && $tr->sectionID == Auth::user()->Section->id) {
                        $scan = true;
                        break;
                    }
                }
                else {
                    if($verify->trackerID == $tr->trackerID && $verify->officeID == Auth::user()->Section->Office->id && 
                        collect(['receiving', 'receive', 'receiver', 'recieving', 'reciever', 'recieve'])
                            ->contains(fn($word) => \Str::contains(strtolower(Auth::user()->Section->section), $word)) 
                    ) {
                        $scan = false;
                        break; 
                    }
                }
            }

            if($scan == true && $verify->status == 1) {

                if($verify->pending == 1) {
                    Documents::where('qrcode', $request->documentID)->update([
                        'pending' => 0
                    ]);
                }
                else {
                    return 201;
                }

                $selectedDocuments = Documents::where('batchID', $verify->id)->get();

                foreach($selectedDocuments as $doc) {

                    Documents::where('id', $doc->id)->update([
                        'pending' => 0
                    ]);

                  $latestLogReceived = Logs::where('documentID', $doc->id)
                        ->where('trackerID', $doc->trackerID)
                        ->first();
    
                    DataAnalytics::create([
                        'logID' => $latestLogReceived->id,
                        'sectionID' => $latestLogReceived->sectionID,
                        'received' => Carbon::now(),
                    ]);

                    if ($latestLogReceived) {
                        $latestLogReceived->update([
                        // 'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
        
                    $latestLogReceivedCreated = Logs::where('documentID', $doc->id)
                            ->where('trackerID', $doc->trackerID + 1)
                            ->first();
        
                    if ($latestLogReceivedCreated) {
                        $latestLogReceivedCreated->timestamps = false;
                        $latestLogReceivedCreated->update([
                        'created_at' => null,
                        ]);
                        $latestLogReceivedCreated->timestamps = true;
                    }
        
        
                    $latestLogReturned = ReturnedLogs::where('documentID', $doc->id)
                            ->where('trackerID', $doc->trackerID)
                            ->orderBy('created_at', 'DESC')
                            ->first();
        
                    if ($latestLogReturned) {
                        $latestLogReturned->update([
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
        
                    $latestLog = ReceivedLogs::where('documentID', $doc->id)
                        ->where('sectionID', Auth::user()->sectionID)
                        ->latest('updated_at')
                        ->first();
                    
                    if ($latestLog) {
                        $latestLog->update([
                            'pending' => 0,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
            
                    $latestLognull = ReceivedLogs::where('documentID', $doc->id)
                    ->where('sectionID', null)
                    ->latest('updated_at')
                    ->first();
                
                        if ($latestLognull) {
                            $latestLognull->update([
                                'sectionID' => Auth::user()->Section->id,
                                'pending' => 0,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                        } 

                }

                return 200;

            }

            else {
                return 500;
            }

        }

        else {

            foreach($tracker as $tr) {

                if($tr->sectionID != null) {
                    if($verify->trackerID == $tr->trackerID && $tr->sectionID == Auth::user()->Section->id) {
                        $scan = true;
                        break;
                    }
                }
                else {
                    if($verify->trackerID == $tr->trackerID && $verify->officeID == Auth::user()->Section->Office->id && 
                        collect(['receiving', 'receive', 'receiver', 'recieving', 'reciever', 'recieve'])
                            ->contains(fn($word) => \Str::contains(strtolower(Auth::user()->Section->section), $word)) 
                    ) {
                        $scan = false;
                        break; 
                    }
                }
            }
    
            if($scan == true && $verify->download == null && $verify->status == 1) {
    
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
    
                DataAnalytics::create([
                    'logID' => $latestLogReceived->id,
                    'sectionID' => $latestLogReceived->sectionID,
                    'received' => Carbon::now(),
                ]);

                
                if ($latestLogReceived) {
                    $latestLogReceived->update([
                       // 'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
    
                $latestLogReceivedCreated = Logs::where('documentID', $documents->id)
                        ->where('trackerID', $documents->trackerID + 1)
                        ->first();
    
                if ($latestLogReceivedCreated) {
                    $latestLogReceivedCreated->timestamps = false;
                    $latestLogReceivedCreated->update([
                       'created_at' => null,
                    ]);
                    $latestLogReceivedCreated->timestamps = true;
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
    
               $latestLog = ReceivedLogs::where('documentID', $documents->id)
                   ->where('sectionID', Auth::user()->sectionID)
                   ->latest('updated_at')
                   ->first();
               
               if ($latestLog) {
                   $latestLog->update([
                       'pending' => 0,
                       'created_at' => Carbon::now(),
                       'updated_at' => Carbon::now(),
                   ]);
               }
    
               $latestLognull = ReceivedLogs::where('documentID', $documents->id)
               ->where('sectionID', null)
               ->latest('updated_at')
               ->first();
           
                if ($latestLognull) {
                    $latestLognull->update([
                        'sectionID' => Auth::user()->Section->id,
                        'pending' => 0,
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

     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function userLogsHistory() {
        
        return ReceivedLogs::where(['usernameID' => Auth::user()->id])
            ->where('created_at', 'like', '%'.date('Y-m-d').'%')
            ->orderBy('created_at', 'DESC')
            ->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function userLogsHistoryByDate($request) {
        return ReceivedLogs::where(['usernameID' => Auth::user()->id])
            ->where('created_at', 'like', '%'.$request->date.'%')
            ->orderBy('created_at', 'DESC')
            ->get();
     }

     public function getOffice($request) {

      $documents = Documents::where('id', $this->aes->decrypt($request->documentID))->first();

      return Tracker::with('sectionstrack') // Eager load the 'sectionstrack' relationship
      ->where('docType', $this->aes->decrypt($request->docType)) // Decrypt docType
      ->where('officeID', Auth::user()->Section->officeID) // Filter by officeID
      ->whereHas('Section', function ($query) {
          $query->where('section', 'like', '%releaser%')
                ->orWhere('section', 'like', '%release%')
                ->orWhere('section', 'like', '%releasing%')
                ->orWhere('section', 'like', '%relaeser%')
                ->orWhere('section', 'like', '%relaese%')
                ->orWhere('section', 'like', '%relaesing%'); // Add conditions for the Section
      })
      ->whereIn('trackerID', function ($query) {
          $query->selectRaw('MAX(trackerID)') // Get the smallest (first) trackerID for each sectionID
                ->from('tracker') // Reference the 'trackers' table
                ->where('docType', $this->aes->decrypt(request('docType'))) // Match docType in subquery
                ->where('officeID', Auth::user()->Section->officeID) // Match officeID in subquery
                ->groupBy('sectionID'); // Group by sectionID to ensure unique trackerID per sectionID
      })
      ->orderBy('trackerID', 'ASC') // Sort by trackerID in ascending order
      ->get();
     }

     public function batchSelectedDocuments($request) {

        $document = 0;
        foreach($request->documents as $key => $value) {
            $document = Documents::where('id', $this->aes->decrypt($value))->first();
            break;
        }

        $batch = Documents::create([
            'qrcode' => \Str::slug(Carbon::now()."-".$request->additionalInfo),
            'docType' => $document->docType,
            'trackerID' => $document->trackerID,
            'remarks' => null,
            'status' => 1,
            'merged' => 1,
            'download' => 1,
            'pending' => 0
        ]);

        foreach($request->documents as $key => $value) {
            Documents::where('id', $this->aes->decrypt($value))->update(['download' => 1, 'batchID' => $batch->id]);
        }
     }

     public function insertToExistingBatch($request) {
        Documents::where('id', $this->aes->decrypt($request->id))->update(['download' => 1, 'batchID' => $this->aes->decrypt($request->batch)]);
     }

     public function updateBatchSelectedDocuments($request) {

        $existingDocument = Documents::where('qrcode', \Str::slug($request->additionalInfo))->where('id', '!=', $this->aes->decrypt($request->id))->exists();

        if ($existingDocument) {
            // If the code exists for another document, return 500
            return 500;
        }

        Documents::where('id', $this->aes->decrypt($request->id))->update(['qrcode' => \Str::slug($request->additionalInfo)]);

        $batchId = $this->aes->decrypt($request->id); // Decrypt batch ID

        // Step 1: Get all document IDs in the current batch
        $allDocumentsInBatch = Documents::where('batchID', $batchId)->pluck('id')->toArray();

        // Step 2: Decrypt the checked document IDs from the request
        $checkedDocuments = array_map(function ($value) {
            return $this->aes->decrypt($value);
        }, $request->documents ?? []);

        // Step 3: Identify unchecked documents
        $uncheckedDocuments = array_diff($allDocumentsInBatch, $checkedDocuments);

        // Step 4: Update checked documents
        foreach ($checkedDocuments as $docId) {
            Documents::where('id', $docId)->update(['download' => 1, 'batchID' => $batchId]);
        }

        // Step 5: Update unchecked documents to null
        if (!empty($uncheckedDocuments)) {
            Documents::whereIn('id', $uncheckedDocuments)->update(['download' => null, 'batchID' => null]);
        }

        return 200;
     }
}

?>