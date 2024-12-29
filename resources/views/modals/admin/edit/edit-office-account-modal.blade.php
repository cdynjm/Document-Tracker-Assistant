@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Edit Office Account'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-4 text-sm text-dark">Edit Office Account</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-4 mx-4">
                        @include('data.edit-office-account-data')
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

