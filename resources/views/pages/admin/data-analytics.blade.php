@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Data Analytics'])
<div class="container-fluid py-4">
    <div class="row">
        
    </div>


    @include('layouts.footers.auth.footer')
</div>
@endsection

