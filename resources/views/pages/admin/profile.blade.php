@php
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Profile'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">Account Information</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <form action="" id="update-account-information">
                                @csrf
                                <label for="">Name</label>
                                <input type="text" class="form-control mb-2" value="{{ Auth::user()->name }}" name="name" required>
                                
                                <label for="">Email</label>
                                <input type="text" class="form-control mb-2" value="{{ Auth::user()->email }}" name="email" required>

                                <label for="">Change Password</label>
                                <input type="password" class="form-control mb-2 password" name="password">

                                <div id="toggle-password" class="mt-2 bg-transparent ms-1 cursor-pointer text-sm mb-4">
                                    <i class="fa fa-eye eye-icon"></i> <small><span class="text">Show</span> Password</small>
                                </div>   
                                <div class="d-flex justify-content-center mt-4">
                                    <button type="submit" class="btn btn-sm bg-dark text-white">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
