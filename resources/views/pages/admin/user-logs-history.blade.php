@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Accounts'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-2 text-sm text-dark"><strong style="font-size: 20px">{{ $employee->name }}</strong> | {{ $employee->Section->section }}</h5>
                            </div>
                            <div class="col-md-4">
                                <input type="date" id="select-date" value="{{ date('Y-m-d') }}" class="form-control">
                                <input type="hidden" id="employeeID" value="{{ $aes->encrypt($employee->id) }}" class="form-control">
                            </div>
                           <!-- <button class="btn btn-sm bg-dark text-white" id="add-user-account">+ Add</button> -->
                        </div>
                        <hr class="mb-0">
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                          @include('data.user-logs-history-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

