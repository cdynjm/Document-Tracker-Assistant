@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
             <!-- Online Card for Small Screens -->
             <div class="col-md-12 mb-4 d-md-none">
                <div class="card border-radius-md">
                    <div class="card-header pb-0 pt-2">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-dark d-flex align-items-center">
                                    <iconify-icon icon="ic:sharp-online-prediction" width="24" height="24" class="me-2"></iconify-icon> Online
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-0" style="max-height: 400px; overflow-y: auto;">
                        <hr class="mb-0 mt-0 mx-4">
                        <div class="table-responsive p-4">
                            @livewire('online')
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Pending Documents -->
            <div class="col-md-4 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-danger d-flex align-items-center">
                                    <iconify-icon icon="ic:twotone-pending" width="24" height="24" class="me-1"></iconify-icon> Pending Transactions
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            sample code
                            @livewire('pending-documents')
                        </div>
                    </div>
                </div>
            </div>
      
    

            <!-- Recent Logs -->
            <div class="col-md-8 mb-4">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-dark">
                                    <i class="fa-solid fa-map-pin me-1 text-sm"></i> Recent Logs
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            @livewire('system-logs')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Online Card for Medium and Larger Screens -->
<div class="d-none d-md-block position-fixed" style="bottom: 0px; right: 20px; width: 300px; z-index: 1050;">
    <div class="card border-radius-md shadow-lg">
        <div class="card-header pb-0 pt-2">
            <div class="d-flex flex-row justify-content-between">
                <div>
                    <h5 class="mb-2 text-sm text-dark d-flex align-items-center">
                        <iconify-icon icon="ic:sharp-online-prediction" width="24" height="24" class="me-2"></iconify-icon> Online
                    </h5>
                </div>
                <a href="javascript:;" id="hide-card" class="text-xs d-flex align-items-center mb-2">
                    <iconify-icon icon="teenyicons:down-solid" width="15" height="15" class="me-1"></iconify-icon> 
                    Hide
                </a>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-0" style="max-height: 300px; overflow-y: auto;" id="card-body">
            <hr class="mb-0 mt-0 mx-4">
            <div class="table-responsive p-4">
                @livewire('online')
            </div>
        </div>
    </div>
</div>


        @include('layouts.footers.auth.footer')
    </div>
@endsection
