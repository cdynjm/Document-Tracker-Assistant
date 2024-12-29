@extends('layouts.app', ['class' => 'bg-gray-100'])

@section('content')
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card mb-4 border-radius-md shadow-md">
                    <div class="card-header pb-0 m-auto">
                    <a class="align-items-center d-flex" href="">
                    <img style="width: 55px; height: 55px;" src="{{ asset('Province-Logo.png') }}" class="ms-2 mb-3" alt="...">
                    <span class="sidebar-text fw-bolder fs-4 ms-2">
                        DoTA
                        <p style="font-size: 10px;">Document Tracking Assistant</p>
                    </span>
                    </a>
                    </div>
                        <hr class="horizontal dark mt-0">
                </div>
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card mb-4 border-radius-md shadow-md">
                    <div class="card-header pb-0">
                        <div class="align-items-center">
                            <h5 class="fw-bolder"><img src="{{ asset('assets/profile.png') }}" class="avatar avatar-sm img-fluid" alt="user1">  Log In</h5> 
                            <p class="text-sm">Sign In with your account credentials to proceed</p>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4 mt-0">
                        <form role="form" id="sign-in">
                            @csrf
                            @method('post')
                            <div class="flex flex-col mb-3">
                                <div class="mb-1">
                                    <small class="fw-bolder text-dark" for="" style="font-size: 13px">EMAIL</small>
                                </div>
                                <input type="email" name="email" class="form-control" value="{{ old('email')}}" placeholder="example@gmail.com" aria-label="Email" required>
                                @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                            </div>
                            <div class="flex flex-col mb-2">
                                <div class="mb-1">
                                    <small class="fw-bolder text-dark" for="" style="font-size: 13px">PASSWORD</small>
                                </div>
                                    
                                    <input type="password" name="password" class="form-control d-inline" aria-label="Password" id="password" placeholder="Password" required>

                                    <div id="toggle-password" class="mt-2 bg-transparent ms-1 cursor-pointer text-sm mb-4">
                                        <i class="fa fa-eye me-1" id="eye-icon"></i> <small><span id="text">Show</span> Password</small>
                                    </div>  
                              
                                @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-md text-white w-100 mt-0 mb-0 bg-dark" >Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        @include('layouts.footers.guest.footer')
    </div>
@endsection
