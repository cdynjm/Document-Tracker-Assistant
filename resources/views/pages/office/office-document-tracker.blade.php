@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Document Tracker'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">
                                    <div class="d-flex px-2 py-1 align-items-center">
                                        <div class="me-2">
                                            {!! QrCode::size(40)->generate($documents->qrcode) !!}
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <a>
                                                <h6 class="mb-0 text-sm">{{ $documents->qrcode }}</h6>
                                                <small>Document Type: <span class="text-secondary text-uppercase">{{ $documents->type->name }}</span></small>
                                            </a>
                                        </div>
                                    </div>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @livewire('document-tracker', ['docID' => $docID, 'docType' => $docType])
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection