@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.admin.user-account-modal')
@extends('modals.admin.edit.edit-user-account-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'User Accounts'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">List of User Accounts</h5>
                            </div>
                            <button class="btn btn-sm bg-dark text-white" id="add-user-account">+ Add</button>
                        </div>
                        <input type="text" class="form-control mb-3" placeholder="Search..." id="search-users">
                        <div>
                            <i><small>You can view the user logs by clicking their account name</small></i>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                           @include('data.user-account-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

