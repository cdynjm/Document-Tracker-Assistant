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
                            <h6 style="background: #F8FAFC" class="p-2 rounded d-flex align-items-center"> <!-- <i class="fa-solid fa-location-crosshairs text-lg text-danger"></i> --> <iconify-icon icon="line-md:my-location-loop" width="22" height="22" class="me-1"></iconify-icon> Document Tracker</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2 m-4 mt-0">
                        <hr class="mt-1">
                        <div class="d-flex px-2 py-1">
                            <div class="me-2" id="print-qrcode">
                                {!! QrCode::size(35)->generate($doc->qrcode) !!}
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a title="View" href="javascript:;" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip">
                                    <h6 class="mb-0 text-sm">{{ $doc->qrcode }}</h6>
                                </a>
                            </div>
                        </div>

                        <p class="mb-2 ms-2 mt-2">
                            <small>Started: <strong>{{ date('M. d, Y | h:i A', strtotime($doc->created_at)) }}</strong></small>
                        </p>

                        <hr>
                        @if($doc->trackerID != 0)
                        @foreach($tracker->where('docType', $doc->docType) as $tr)
                            @if($tr->trackerID == $doc->trackerID)
                                @if($tr->sectionID != null)
                                    @if($doc->pending == 1)
                                    
                                    <div>
                                        <small class="text-danger fw-bold">
                                            En Route to Next Station:
                                        </small>
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                                        <!-- <i class="fas fa-paper-plane text-info text-lg me-3"></i> -->
                                            <div>
                                                <h6 class="mb-0 text-sm">{{ $tr->Section->Office->office }}</h6>
                                                <p class="text-sm mb-0">{{ $tr->Section->section }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mt-2">
                                        <i class="fas fa-map-marker-alt text-success text-lg me-3"></i>
                                        <div>
                                            <h6 class="mb-0 text-sm">{{ $tr->Section->Office->office }}</h6>
                                            <p class="text-sm mb-0">{{ $tr->Section->section }}</p>
                                        </div>
                                    </div>                                
                                    @endif
                                @else
                                    @if($doc->pending == 1)
                                        
                                    <div>
                                        <small class="text-danger fw-bold">
                                            En Route to Next Station:
                                        </small>
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                                        <!-- <i class="fas fa-paper-plane text-info text-lg me-3"></i> -->
                                            <div>
                                                <h6 class="mb-0 text-sm">{{ $doc->Office->office }}</h6>
                                                <p class="text-sm mb-0">{{ 'Source Office Receiver' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="d-flex align-items-center mt-2">
                                        <i class="fas fa-map-marker-alt text-success text-lg me-3"></i>
                                        <div>
                                            <h6 class="mb-0 text-sm">{{ $doc->Office->office }}</h6>
                                            <p class="text-sm mb-0">{{ 'Source Office Receiver' }}</p>
                                        </div>
                                    </div>                                
                                    @endif
                                @endif
                            @endif
                        @endforeach
                    @else
                    @if($doc->pending == 1)
                    <div>
                        <small class="text-danger fw-bold">
                            En Route to Next Station:
                        </small>
                        <div class="d-flex align-items-center mt-2">
                          <!--  <i class="fas fa-paper-plane text-info text-lg me-3"></i> -->
                          <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                            <div>
                                <h6 class="mb-0 text-sm">Source Office</h6>
                            </div>
                        </div>
                    </div>
                    @else
                    <span class="text-sm fw-bold text-danger">
                        <span class="me-2"><i class="fas fa-minus-circle"></i></span>Currently at the source Office
                    </span>
                    @endif
                @endif
                @if($doc->status == 0)
                    <p class="text-success text-sm mt-3"> <i class="fa-solid fa-circle-check text-success me-1"></i> Trasaction Done

                        <span class="text-normal">| {{ date('M. d, Y - h:i A', strtotime($doc->first()->updated_at)) }}</span>
                    </p>
                @endif

                @if($doc->status == 1)
                @php
                    $minutes = 0;
                
                    // Get the first document and its trackerID
                    $firstDocument = $doc;
                
                    if ($firstDocument) {
                        $documentUpdatedAt = strtotime($firstDocument->updated_at); // Convert updated_at to timestamp
                        $currentTime = time(); // Current time in timestamp
                
                    
                        foreach ($tracker->where('trackerID', '>=', $firstDocument->trackerID) as $tr) {
                            $minutes += 60;
                        }
                
                        // Calculate the total time difference in minutes
                        $timeDifference = ($currentTime - $documentUpdatedAt) / 60;
                        $minutes += $timeDifference;
                        
                    }
                
                    // Convert total minutes to days, hours, and remaining minutes
                    $days = floor($minutes / (24 * 60)); // Full days
                    $hours = floor(($minutes % (24 * 60)) / 60); // Remaining hours after extracting days
                    $remainingMinutes = $minutes % 60; // Remaining minutes after extracting hours
                @endphp
                <hr class="mt-4">
                <div class="document-estimates mt-0 mb-3">
                    <div class="estimated-time">
                        <small class="me-1" style="font-size: 13px">Transaction is expected to be completed within:</small>
                        
                        <h6 class="text-muted fw-bolder mt-2 d-flex">
                            <iconify-icon icon="uim:clock" width="24" height="24" class="me-1"></iconify-icon>
                            {{ $days > 0 ? $days . ' ' . ($days == 1 ? 'day' : 'days') . ', ' : '' }}
                            {{ $hours }} {{ $hours == 1 ? 'hour' : 'hours' }} & 
                            {{ $remainingMinutes }} {{ $remainingMinutes == 1 ? 'minute' : 'minutes' }}
                        </h6>
                    </div>
                </div>
                @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
        @include('layouts.footers.guest.footer')
    </div>
@endsection
