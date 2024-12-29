@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Batched Documents'])
    <div class="container-fluid py-4">
        

            <div class="col-md-12 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">Update Batched Documents</h5>
                            </div>
                            <div>
                                <a href="javascript:;" data-id="{{ $aes->encrypt( $batchName->id) }}" id="saveBatchDocuments" class="text-secondary text-sm fw-bold d-flex">
                                    <iconify-icon icon="material-symbols:cell-merge-rounded" width="24" height="24" class="text-secondary me-1"></iconify-icon>
                                    Save
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <hr class="mx-4 mb-0">
                        <div class="table-responsive p-4">
                            @include('data.edit-batched-documents')
                        </div>
                    </div>
                </div>
            </div>

           
           
            
       
        @include('layouts.footers.auth.footer')
    </div>
@endsection

