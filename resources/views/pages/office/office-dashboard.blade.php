@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('modals.office.generate-qrcode-modal')
@extends('modals.office.print-selected-qrcode-modal')
@extends('modals.office.rename-document')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4" >
        <div class="row">
            <div class="col-md-12">                
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn bg-dark text-white fw-normal me-2 mt-2 mt-lg-4" id="add-qrcode"><i class="fas fa-qrcode text-sm me-1"></i> Generate QR Code</button>
                        <button class="btn bg-gradient-danger text-white fw-normal mt-2 mt-lg-4" id="startScanBtn"><i class="fas fa-camera-retro text-sm me-1"></i> Scan to Receive</button>
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

                <div class="card border-radius-md">
                    <div class="card-header pb-0">

                       <!-- <div class="mb-4">
                            <small class="mb-2"><strong>New Feature: </strong></small>
                            <small class="mb-4 text-dark fw-normal">
                                You can now <strong>RENAME QR CODE NAMES</strong>. However, please read the instructions carefully before renaming the QR code to avoid potential conflicts. Only rename the QR code when absolutely necessary.
                            </small>
                        </div> -->

                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h6 class="text-danger">Pending Documents</h6>
                                <h4 class="mb-2 text-sm text-dark fw-bolder">{{ Auth::user()->name }} | <small class="text-uppercase fw-bold">{{ Auth::user()->Office->office }}</small></h4>
                            </div>
                        </div>
                        <div class="mt-2">
                         <!--   <label for="" class="text-secondary fw-normal">Select All</label>
                            <input type="checkbox" class="me-2" id="masterCheckbox">
                            <a href="javascript:;" id="forward-selected-document" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                                data-toggle="tooltip">
                                <i class="fas fa-paper-plane text-sm me-1"></i> Forward
                            </a>
                            <a href="javascript:;" id="print-selected-qrcode" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                                data-toggle="tooltip">
                                <i class="fas fa-print text-sm me-1"></i> Print QR
                            </a>  -->
                        </div>
                        <div class="mb-3"> <small>If you notice that the document/QR code is no longer visible here, it’s possible that the transaction for that document has been completed. You can check the archives in the sidebar for more details.</small> </div>

                        <input type="text" class="form-control mt-2 d-none d-sm-block" placeholder="Search..." id="search-office-document">
                        <input type="text" class="form-control mt-2 d-sm-none d-block" placeholder="Search..." id="search-office-document-mobile">
                
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        
                        <div class="table-responsive p-4">
                            @include('data.document-tracker-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('scripts')
    
@endpush