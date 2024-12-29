<?php

namespace App\Livewire;

use Session;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

//CIPHER:
use App\Http\Controllers\AESCipher;

//MODELS:
use App\Models\User;
use App\Models\Offices;
use App\Models\Tracker;
use App\Models\Documents;
use App\Models\Sections;
use App\Models\Logs;
use App\Models\ReturnedLogs;
use App\Models\TrackerCompleted;

class DocumentTrackerAdmin extends Component
{

    public $docID;
    public $docType;

    public $id;
    public $logs;
    public $tracker;
    public $offices;
    public $sections;
    public $documents;
    public $returnedlogs;

    /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function mount() {
        $this->fetchTracker();
    }
    
    /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function fetchTracker() {
        $aes = new AESCipher();
        $qrcodeID = $aes->decrypt($this->docID);
        $docType = $aes->decrypt($this->docType);

        $this->documents = Documents::where(['id' => $qrcodeID])->get();
        
        if($this->documents->first()->status == 1) {
            $this->tracker = Tracker::where(['docType' => $docType])->get();
        }
        else {
            $this->tracker = TrackerCompleted::where(['documentID' => $qrcodeID])->get();
        }

        $this->offices = Offices::get();
        $this->sections = Sections::get();
        $this->logs = Logs::where('userID', $this->documents->first()->userID)->where('documentID', $qrcodeID)->get();
        $this->returnedlogs = ReturnedLogs::where(['userID' => $this->documents->first()->userID])->where('documentID', $qrcodeID)->get();
    }
    /**
     * Handle an incoming real time updates.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function render() {
        $logs = $this->logs;
        $tracker = $this->tracker;
        $offices = $this->offices;
        $sections = $this->sections;
        $documents = $this->documents;
        $returnedlogs = $this->returnedlogs;

        return view('livewire.document-tracker-admin', compact('logs','tracker','offices', 'sections', 'documents', 'returnedlogs'));
    }
}
