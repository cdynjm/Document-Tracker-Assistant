<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Documents;
use App\Models\Tracker;
use App\Models\Offices;
use App\Models\Sections;
use App\Models\DocumentType;
use App\Http\Controllers\AESCipher;

class PendingDocuments extends Component
{
    public $documents;
    public $tracker;
    public $offices;
    public $sections;
    public $docType;

    public function mount() {
        $this->fetchPendingDocuments();
    }

    public function fetchPendingDocuments() {
        $this->documents = Documents::where(['status' => 1])
        ->where('merged', null)
        ->orderBy('updated_at', 'DESC')->get();
        $this->tracker = Tracker::get();
        $this->offices = Offices::get();
        $this->sections = Sections::get();
        $this->docType = DocumentType::get();
    }

    public function render()
    {
        return view('livewire.pending-documents', [
            'documents' => $this->documents,
            'tracker' => $this->tracker,
            'offices' => $this->offices,
            'sections' => $this->sections,
            'docType' => $this->docType,
            'aes' => new AESCipher
        ]);
    }
}
