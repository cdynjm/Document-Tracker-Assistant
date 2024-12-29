@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('modals.office.search-scanner-modal')
@extends('modals.user.return-document-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
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
                    <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span> <span id="ampm">AM</span>
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

        @if(Auth::user()->special == null)
            <div class="col-md-12 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h6 class="text-danger">All Pending Documents</h6>
                                <h4 class="mb-2 text-sm text-dark">You can now scan, forward or return the document here instantly.</h4>
                            </div>
                        </div>
                        <input type="text" class="form-control mt-2 d-none d-sm-block" placeholder="Search..." id="search-office-document">
                        <input type="text" class="form-control mt-2 d-sm-none d-block" placeholder="Search..." id="search-office-document-mobile">
                    </div>
                    <div class="card-body px-0 pt-0 pb-3">
                        <div class="table-responsive p-4">
                        @include('data.all-pending-documents-data')
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-5">
            @endif
            <div class="col-md-12 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">Logs of Received Documents</h5>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="select-date" value="{{ date('Y-m-d') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <hr class="mx-4 mb-0">
                        <div class="table-responsive p-4">
                            @include('data.received-logs-data')
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">Logs of Forwarded Documents</h5>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="select-date-forwarded" value="{{ date('Y-m-d') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <hr class="mx-4 mb-0">
                        <div class="table-responsive p-4">
                            @include('data.forwarded-logs-data')
                        </div>
                    </div>
                </div>
            </div>
            
       
        @include('layouts.footers.auth.footer')
    </div>
@endsection

