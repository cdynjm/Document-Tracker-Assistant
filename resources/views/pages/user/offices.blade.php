@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('modals.office.search-scanner-modal')
@extends('modals.user.return-document-modal')
@extends('modals.user.return-selected-document-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Office'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn bg-gradient-danger text-white fw-normal mt-2 mt-lg-4 me-2" id="startScanBtn">
                            <i class="fas fa-camera-retro text-sm me-1"></i> Scan to Receive
                        </button>
                        <button class="btn bg-dark text-white fw-normal mt-2 mt-lg-4" id="startScanBtnSearch">
                            <i class="fas fa-camera-retro text-sm me-1"></i> Scan to Search
                        </button>
                    </div>
                    <div class="col-md-6 text-lg-end text-sm-start">
                        <div id="clock" class="clock fs-2 fw-bold ms-auto ">
                            <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span> <span id="ampm" class="ms-2">AM</span>
                        </div>
                        <div id="date" class="date text-sm fw-normal ms-auto mb-3"></div>
                    </div>
                                    
                </div>
                <script>
                    function updateClock() {
                        const now = new Date();
                        let hours = now.getHours();
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        const seconds = String(now.getSeconds()).padStart(2, '0');
                        const ampm = hours >= 12 ? 'PM' : 'AM';
                
                        hours = hours % 12;
                        hours = hours ? hours : 12;
                        hours = String(hours).padStart(2, '0');
                
                        document.getElementById('hours').textContent = hours;
                        document.getElementById('minutes').textContent = minutes;
                        document.getElementById('seconds').textContent = seconds;
                        document.getElementById('ampm').textContent = ampm;
                    }
                
                    function updateDate() {
                        const now = new Date();
                        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        const formattedDate = now.toLocaleDateString(undefined, options);
                        document.getElementById('date').textContent = formattedDate;
                    }
                
                    updateClock();
                    updateDate();
                    setInterval(updateClock, 1000);
                    setInterval(updateDate, 60000);  // Update date every minute
                </script>
                
            </div>
            <div class="col-md-12">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">

                      <!--  <div class="mb-4">
                            <small class="mb-2"><strong>New Feature: </strong></small>
                            <small class="mb-4 text-dark fw-normal">
                                You can now <strong>SCAN QR CODES TO SEARCH</strong> documents for faster transaction processing. This feature is especially useful when managing a large number of documents that need to be processed. By simply scanning the QR code, you can instantly locate the document with ease.
                            </small>
                           </div> -->

                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h6 class="text-danger">Pending Documents</h6>
                                <h4 class="mb-2 text-sm text-dark fw-bolder">{{ $offices->name }} | <small class="text-uppercase fw-bold">{{ $offices->Office->office }}</small></h4>
                            </div>
                        </div>
                        <div class="mt-2">
                          <!--  <label for="" class="text-secondary fw-normal">Select All</label>
                            <input type="checkbox" class="me-2" id="masterCheckbox">
                            <a href="javascript:;" id="forward-selected-document" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                                data-toggle="tooltip">
                                <i class="fas fa-paper-plane text-sm me-1"></i> Forward
                            </a> -->
                          <!--  <a href="javascript:;" id="reject-selected-document" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                                data-toggle="tooltip">
                                <i class="fa-regular fa-circle-left text-sm me-1"></i> Return
                            </a> -->
                            <input type="hidden" class="form-control" id="officeID" value="{{ $aes->encrypt($offices->id) }}" readonly>
                            <input type="hidden" class="form-control" id="dataID" value="{{ $aes->encrypt($offices->id) }}" readonly>
                        </div>

                        <input type="text" class="form-control mt-2 d-none d-sm-block" placeholder="Search..." id="search-office-document">
                        <input type="text" class="form-control mt-2 d-sm-none d-block" placeholder="Search..." id="search-office-document-mobile">

                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                       
                        <div class="table-responsive p-4">
                            @include('data.document-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

