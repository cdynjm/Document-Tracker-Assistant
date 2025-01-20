<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="token" content="{{ Session::get('token') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('Province-Logo.png') }}">
    <title>
        Document Tracking System
    </title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/tracker.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}" data-navigate-once>

    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/instascan.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/axios.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/qrcode.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/iconify-icon.min.js') }}"></script>
    <script src="{{ asset('assets/js/qrcode.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/datatable.css') }}">

    @if(Auth::check())
    @can('accessAdmin', Auth::user())
    <script src="{{ asset('assets/js/admin.js?01202025') }}" data-navigate-once></script>
    @endcan
    @can('accessOffice', Auth::user())
    <script src="{{ asset('assets/js/office.js?01202025') }}" data-navigate-once></script>
    @endcan
    @can('accessUser', Auth::user())
    <script src="{{ asset('assets/js/user.js?01202025') }}" data-navigate-once></script>
    @endcan
    <script src="{{ asset('assets/js/signout.js?01202025') }}" data-navigate-once></script>
    @else
    <script src="{{ asset('assets/js/signin.js?01202025') }}" data-navigate-once></script>
    @endif

    <link href="{{ asset('assets/css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/datatables.min.js?01162025') }}"></script>

    <script>
        window.onpopstate = function(event) {
            window.location.reload(true);
        };
    </script>
    @livewireStyles
</head>

<body class="{{ $class ?? '' }}">

    <style>
        ::-webkit-scrollbar{width:8px;height:5px}::-webkit-scrollbar-track{background:#f1f1f1;border-radius:10px}::-webkit-scrollbar-thumb{background:#aaa7a7;border-radius:10px}::-webkit-scrollbar-thumb:hover{background:#a6a3a3}
    
        .page-blur {
            pointer-events: none; 
            user-select: none;
        }
    
    </style>
    
    @php
      $maintenance = 0;
    @endphp

@if($maintenance == 1)
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Server is under maintenance',
          html: '<span class="text-danger">You are not authorized to access this page.</span> <br><br> <span class="text-sm">To ensure the continued stability and security of our systems, we have scheduled routine maintenance on our servers. During this maintenance window, there will be a temporary interruption of services. <br><br>We appreciate your understanding and cooperation as we work to enhance the reliability and security of this system.</span>',
          allowOutsideClick: false,
          showCancelButton: false,
          showConfirmButton: false
      }).then(function(){ 
            location.reload();
        });
  </script>
@endif

    @php
        $folderPath = base_path('vendor/livewire/livewire');
        $linkPath = public_path('storage');
    @endphp
    
    @if(!File::exists($folderPath))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Please install laravel livewire framework to proceed',
                html: '<span class="text-danger">You are not authorized to access this page.</span> <br><br> <span class="text-sm">1. `composer require livewire/livewire` <br> 2. `php artisan livewire:publish --config`</span>',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false
            }).then(function(){ 
                    location.reload();
                });
        </script>
    @endif

    @if(!File::exists($linkPath))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Storage link not found',
                html: '<span class="text-danger">You are not authorized to access this page.</span> <br><br> <span class="text-sm">Please run `php artisan storage:link` or `localhost:8000/storage`</span>',
                allowOutsideClick: false,
                showCancelButton: false,
                showConfirmButton: false
            }).then(function(){ 
                    location.reload();
                });
        </script>
    @endif

    <script data-navigate-once>
        window.addEventListener('offline', function(e) {
            SweetAlert.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'No internet connection!',
            });
        });
        
        window.addEventListener('online', function(e) {
            SweetAlert.fire({
                icon: 'success',
                title: 'Great News!',
                text: 'Internet connection restored!',
            });
        });
    </script>

    @guest
        @yield('content')
    @endguest

    @auth
        @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register', 'recover-password', 'rtl', 'virtual-reality']))
            @yield('content')
        @else
            @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
                
            @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
                <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                    <span class="mask bg-primary opacity-6"></span>
                </div>
            @endif
            @include('layouts.navbars.auth.sidenav')
                <main class="main-content border-radius-lg">
                    @yield('content')
                </main>
        @endif
    @endauth

    <script src="{{ asset('assets/js/core/popper.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}" data-navigate-once></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script async defer src="{{ asset('assets/js/buttons.js') }}"></script>
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>

    <style> #nprogress .bar { background: rgb(9, 0, 83) !important; } </style>

    @stack('js')
    @livewireScripts
</body>

</html>