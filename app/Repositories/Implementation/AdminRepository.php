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
use Illuminate\Validation\Rule;
use Illuminate\Http\Response;

//CIPHER:
use App\Http\Controllers\AESCipher;

//INTERFACE:
use App\Repositories\Interfaces\AdminInterface;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\Documents;
use App\Models\Sections;
use App\Models\ReceivedLogs;
use App\Models\DocumentType;

class AdminRepository implements AdminInterface {
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
    public function getDocumentTracker() {
        return Tracker::get();
     }
     public function getDocuments($request) {
        return Documents::with('type')->where(['userID' => $this->aes->decrypt($request->id)])
        ->where(['status' => 1])
        ->orderBy('created_at', 'DESC')->get()
        ->groupBy('type.name');
     }
     public function office($request) {

        return Offices::where('id', $this->aes->decrypt($request->officeID))->first();
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
    public function createOffice($request) {
        Offices::create(['office' => $request->office]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateOffice($request) {
        $id = $this->aes->decrypt($request->id);
        Offices::where(['id' => $id])->update(['office' => $request->office]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteOffice($request) {
        $id = $this->aes->decrypt($request->id);
        Offices::where(['id' => $id])->delete();
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
    public function getSections() {
        return Sections::get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createSection($request) {
        $officeID = $this->aes->decrypt($request->office);
        Sections::create([
            'officeID' => $officeID,
            'section' => $request->section
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateSection($request) {
        $id = $this->aes->decrypt($request->id);
        $officeID = $this->aes->decrypt($request->office);
        Sections::where(['id' => $id])->update([
            'officeID' => $officeID,
            'section' => $request->section
        ]);
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteSection($request) {
        $id = $this->aes->decrypt($request->id);
        Sections::where(['id' => $id])->delete();
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getOfficeAccounts() {
       return User::where(['role' => 2])->get();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createOfficeAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $officeID = $this->aes->decrypt($request->office);
        $officeAccount = User::create([
            'name' => $request->name,
            'officeID' => $officeID,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 2
        ]);

        return Response::HTTP_OK;
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateOfficeAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $officeID = $this->aes->decrypt($request->office);
        $id = $this->aes->decrypt($request->id);
    
        User::where(['id' => $id])->update([
            'name' => $request->name,
            'officeID' => $officeID,
            'email' => $request->email,
        ]);

        if(!empty($request->password)) {
            User::where(['id' => $id])->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return Response::HTTP_OK;
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getOfficeAccount($request) {
        $id = $this->aes->decrypt($request->id);
        return User::where(['id' => $id])->first();
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getTracker($request) {
        $id = $this->aes->decrypt($request->id);
        return Tracker::where(['docType' => $id])->get();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteOfficeAccount($request) {
        $id = $this->aes->decrypt($request->id);
        User::where(['id' => $id])->delete();
     }


     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function getUserAccounts() {
        $userAccounts = User::where('role', 3)
        ->with(['Section']) // Eager load Section and Office
        ->get();

        return $userAccounts->groupBy(fn($user) => $user->Section->officeID ?? 'Unassigned');
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
    public function createDocumentType($request) {
        
        $type = DocumentType::create(['name' => $request->name]);

        $trackerID = 1;
        foreach($request->tracker as $key => $value) {
            $sectionID = $this->aes->decrypt($value);
            if($sectionID != 0) {
                Tracker::create([
                    'trackerID' => $trackerID,
                    'sectionID' => $sectionID,
                    'docType' => $type->id,
                    'officeID' => Sections::where('id', $sectionID)->first()->officeID
                ]);
            }
            else {
                Tracker::create([
                    'trackerID' => $trackerID,
                    'docType' => $type->id,
                    
                ]);
            }
            $trackerID += 1;
        }
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateDocumentType($request) {
        
        DocumentType::where('id', $this->aes->decrypt($request->id))->update(['name' => $request->name]);

        $trackerID = 1;
        Tracker::where('docType', $this->aes->decrypt($request->id))->delete();
        foreach($request->tracker as $key => $value) {
            $sectionID = $this->aes->decrypt($value);
            if($sectionID != 0) {
                Tracker::create([
                    'trackerID' => $trackerID,
                    'sectionID' => $sectionID,
                    'docType' => $this->aes->decrypt($request->id),
                    'officeID' => Sections::where('id', $sectionID)->first()->officeID
                ]);
            }
            else {
                Tracker::create([
                    'trackerID' => $trackerID,
                    'docType' => $this->aes->decrypt($request->id),
                ]);
            }
            $trackerID += 1;
        }
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteDocumentType($request) {
        
        DocumentType::where('id', $this->aes->decrypt($request->id))->delete();
        Tracker::where('docType', $this->aes->decrypt($request->id))->delete();
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function editDocumentType($request) {
        return DocumentType::where(['id' => $this->aes->decrypt($request->id)])->first();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function userLogsHistory($request) {
        $userID = $this->aes->decrypt($request->id);
        return ReceivedLogs::where(['usernameID' => $userID])
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
        $userID = $this->aes->decrypt($request->id);
        return ReceivedLogs::where(['usernameID' => $userID])
            ->where('created_at', 'like', '%'.$request->date.'%')
            ->orderBy('created_at', 'DESC')
            ->get();
     }
      /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function employeeName($request) {
        $userID = $this->aes->decrypt($request->id);
        return User::where(['id' => $userID])->first();
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function createUserAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $sectionID = $this->aes->decrypt($request->section);

        $user = User::create([
            'name' => $request->name,
            'sectionID' => $sectionID,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 3
        ]);

        if(!empty($request->special)) {
            User::where('id', $user->id)->update(['special' => 1]);
        }

        return Response::HTTP_OK;
     }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function updateUserAccount($request) {
        
        if(Validator::make($request->all(), [
            'email' => 'required|string|max:255|',
            Rule::unique('users', 'email')
        ])->fails()) { return Response::HTTP_INTERNAL_SERVER_ERROR; }

        $id = $this->aes->decrypt($request->id);
        $sectionID = $this->aes->decrypt($request->section);
        User::where(['id' => $id])->update([
            'name' => $request->name,
            'sectionID' => $sectionID,
            'email' => $request->email,
        ]);

        if(!empty($request->password)) {
            User::where(['id' => $id])->update([
                'password' => Hash::make($request->password),
            ]);
        }

        if(!empty($request->special)) {
            User::where('id', $id)->update(['special' => 1]);
        }
        else {
            User::where('id', $id)->update(['special' => null]);
        }

        return Response::HTTP_OK;
     }
     /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function deleteUserAccount($request) {
        $id = $this->aes->decrypt($request->id);
        User::where(['id' => $id])->delete();
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
}

?>