@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('modals.office.generate-qrcode-modal')
@extends('modals.office.print-selected-qrcode-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Office Documents'])
    <div class="container-fluid py-4" >
        <div class="row">
            <div class="col-md-12">                
                


                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="fw-bolder">{{ $office->office }}</h5>
                                <h6 class="text-danger text-sm">Pending Documents</h6>
                            </div>
                            
                            <!-- <a href="javascript:;" id="print-qrcode" class="text-sm text-danger"><i class="fas fa-print me-1"></i> Print QR Code</a> -->
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
                        <input type="text" class="form-control mt-2" placeholder="Search..." id="search-office-document">
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        
                        <div class="table-responsive p-4">
                            @include('data.admin-document-tracker-data')
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