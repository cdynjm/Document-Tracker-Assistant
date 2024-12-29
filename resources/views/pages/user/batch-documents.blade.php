@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('modals.user.add-to-existing-batch-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Batch Documents'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-6">
                <button class="btn bg-gradient-danger text-white fw-normal mt-2 mt-lg-4 me-2" id="startScanBtn">
                    <i class="fas fa-camera-retro text-sm me-1"></i> Scan to Receive
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

            <div class="col-md-12 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">Batched</h5>
                            </div>
                        </div>
                        <small>In printing the QR Code, click the QR code itself to trigger a pop up modal</small>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <hr class="mx-4 mb-0">
                        <div class="table-responsive p-4">
                            
                            @include('data.batched-documents')
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->special == 1)
            <div class="col-md-12 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">To be Batched</h5>
                            </div>
                            <div>
                                <a href="javascript:;" id="batchDocuments" class="text-secondary text-sm fw-bold d-flex">
                                    <iconify-icon icon="material-symbols:cell-merge-rounded" width="24" height="24" class="text-secondary me-1"></iconify-icon>
                                    Batch Documents
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <hr class="mx-4 mb-0">
                        <div class="table-responsive p-4">
                            @include('data.to-be-batched-documents')
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
       
        @include('layouts.footers.auth.footer')
    </div>
@endsection

