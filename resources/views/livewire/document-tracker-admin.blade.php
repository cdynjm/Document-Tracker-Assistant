<div>
    <div wire:poll.visible.10s="fetchTracker">
        <div class="table-responsive p-4">

        @if($documents->first()->status == 1)
        @php
            $minutes = 0;
        
            // Get the first document and its trackerID
            $firstDocument = $documents->first();
        
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
        @endif
        

        <p class="mb-4 ms-2">
            <small>Started: <strong>{{ date('M. d, Y | h:i A', strtotime($documents->first()->created_at)) }}</strong></small>
        </p>
            <h6 style="background: #F8FAFC" class="p-2 rounded d-flex align-items-center"> <!-- <i class="fa-solid fa-location-crosshairs text-lg text-danger"></i> --> <iconify-icon icon="line-md:my-location-loop" width="22" height="22" class="me-1"></iconify-icon> Tracker</h6>
            <hr>

            @if($documents->first()->updated_at)
            @php
                $updatedAt = $documents->first()->updated_at; // Get the 'updated_at' timestamp
                $daysElapsed = now()->diffInDays($updatedAt); // Calculate the number of days since the document was updated
            @endphp
        
            @if($daysElapsed >= 3)
                <div class="text-sm d-flex align-items-center my-1 rounded" style="background: #FFF5CD; padding: 10px;">
                    <iconify-icon icon="gridicons:notice" width="24" height="24" class="text-warning me-1"></iconify-icon>
                    <span>
                        We noticed that this document has not been moved for <strong>{{ $daysElapsed }} days</strong>. 
                        Please visit the last office or station it was processed at to ensure your transaction is still ongoing.
                    </span>
                </div>
                <hr>
            @endif
            @endif

            @if($documents->first()->status == 1)

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
            <hr>
            @endif

            @php
                $office = collect();
            @endphp

            @php
                $currentDocument = $documents->where('pending', 0)->first();
                $currentDocumentPending = $documents->where('pending', 1)->first();
            @endphp

            @if (isset($currentDocumentPending->trackerID) && $currentDocumentPending->trackerID == 0) 
            <div class="mb-4 pb-3" style="border-bottom: 4px solid rgb(127, 167, 204)">
                <small class="text-danger fw-bold">
                    En Route to Your Office:
                </small>
                <div class="d-flex align-items-center mt-2">
                    <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                  <!--  <i class="fas fa-paper-plane text-info text-lg me-3"></i> -->
                    <div>
                        <h6 class="mb-0 text-sm">{{ $documents->first()->Office->office }}</h6>
                        <p class="text-sm mb-0">Source Office</p>
                    </div>
                </div>
            </div>
            @endif

            <p
            class="text-sm
            @if (isset($currentDocument->trackerID) && $currentDocument->trackerID == 0) fw-bolder current-tracker @endif">
            @if (isset($currentDocument->trackerID) && $currentDocument->trackerID == 0)
                <i class="fa-solid fa-location-dot text-success text-lg me-2"></i>
            @endif
            <i class="fa-solid fa-flag-checkered"></i> Department/Office
            @foreach ($logs->where('trackerID', 0) as $lg)
            @if(!empty($lg->updated_at))
            | <span class="text-xs">
                {{ date('M. d, Y - h:i A', strtotime($lg->updated_at)) }}
            </span>
            @endif
            @endforeach
            </p>

            @foreach ($returnedlogs->where('trackerID', 0) as $rlg)
            <div class="text-xs text-normal text-danger">
                {!! $rlg->remarks !!} <div class="text-secondary fw-bold mt-2">
                    @if($rlg->updated_at != null)
                    {{ \Carbon\Carbon::parse($rlg->updated_at)->isToday() ? 'Today - ' . date('h:i A', strtotime($rlg->updated_at)) : date('M. d, Y - h:i A', strtotime($rlg->updated_at)) }}
                    @endif
                </div>
                <hr>
            </div>
            @endforeach

            <hr>
            <div class="tracker-progress">

                @php
                    $currentOfficeID = null; // Track the current office to avoid premature grouping.
                @endphp

                @foreach ($tracker as $tr)
                    @if ($currentOfficeID !== $tr->officeID)
                        @php
                            $currentOfficeID = $tr->officeID;
                        @endphp
                        @if($tr->officeID != null)
                        {{-- Display the Office Name --}}
                        <div class="office-item">
                            <p class="office-name text-sm">
                                <span 
                                @if($tr->trackerID > $documents->first()->trackerID)
                                   style="opacity: 0.4"
                                @endif
                                >
                                   {{ $tr->Office->office }}
                               </span>
                            </p>
                            <ul class="section-list">
                        @else
                        <div class="office-item">
                            <p class="office-name text-sm">
                                <span 
                                @if($tr->trackerID > $documents->first()->trackerID)
                                   style="opacity: 0.4"
                                @endif
                                >
                                   {{ $documents->first()->Office->office }}
                               </span>
                            </p>
                            <ul class="section-list">
                        @endif
                    @endif
                                
                    @if ($documents->where('pending', 1)->first()?->trackerID == $tr->trackerID) 
                    <div class="mb-4 pb-3" style="border-bottom: 4px solid rgb(127, 167, 204)">
                        <small class="text-danger fw-bold">
                            En Route to Next Station:
                        </small>
                            <div class="d-flex align-items-center mt-2">
                                <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                               <!-- <i class="fas fa-paper-plane text-info text-lg me-3"></i> -->
                               @if($tr->sectionID != null)
                                <div>
                                    <h6 class="mb-0 text-sm">{{ $tr->Section->Office->office  }}</h6>
                                    <p class="text-sm mb-0">{{ $tr->Section->section }}</p>
                                </div>
                                @else
                                <div>
                                    <h6 class="mb-0 text-sm">{{ $documents->first()->Office->office }}</h6>
                                    <p class="text-sm mb-0">{{ 'Office Receiver' }}</p>
                                </div>
                                @endif
                                
                            </div>
                        </div>
                    @endif

                                
                    @foreach ($logs->where('trackerID', $tr->trackerID) as $lg)
    @if(!empty($lg->updated_at))
    <div class="d-flex align-items-center mb-0">
        <span class="text-xs mb-2" style="margin-left: 8px">
            <span class="text-secondary fw-normal">Received: {{ \Carbon\Carbon::parse($lg->updated_at)->isToday() ? 'Today - ' . date('h:i A', strtotime($lg->updated_at)) : date('M. d, Y - h:i A', strtotime($lg->updated_at)) }}
            </span>
        </span>
    </div>
    @endif
@endforeach

@foreach ($logs->where('trackerID', $tr->trackerID + 1) as $lg)
    @if(!empty($lg->created_at))
    <div class="d-flex align-items-center mb-0">
        <span class="text-xs mb-2" style="margin-left: 8px">
            <span class="text-secondary fw-normal">Forwarded: {{ \Carbon\Carbon::parse($lg->created_at)->isToday() ? 'Today - ' . date('h:i A', strtotime($lg->created_at)) : date('M. d, Y - h:i A', strtotime($lg->created_at)) }}
            </span>
        </span>
    </div>
    @php
        $receivedAt = \Carbon\Carbon::parse($logs->where('trackerID', $tr->trackerID)->first()->updated_at);
        $forwardedAt = \Carbon\Carbon::parse($lg->created_at);
        $interval = $forwardedAt->diffInMinutes($receivedAt);
        $intervalInDays = floor($interval / 1440);
        $intervalInHours = floor(($interval % 1440) / 60);
        $intervalInMinutes = $interval % 60;
    @endphp
    <div class="d-flex align-items-center mb-0">
        <span class="text-sm mb-2" style="margin-left: 8px">
            <span class="text-dark fw-bolder"><small class="fw-normal text-secondary">INTERVAL: </small>
                @if($intervalInDays > 0)
                    {{ $intervalInDays }}d
                @endif
                @if($intervalInHours > 0 || $intervalInDays > 0)
                    {{ $intervalInHours }}h
                @endif
                {{ $intervalInMinutes }}m
            </span>
        </span>
    </div>
    @endif
@endforeach

                   

                                <li
                                    class="text-sm fw-bold
                                    @if ($documents->where('pending', 0)->first()?->trackerID == $tr->trackerID) current-tracker @endif
                                    ">
                                    
                                    <div class="d-flex align-items-center">
                                        @if ($documents->where('pending', 0)->first()?->trackerID == $tr->trackerID)
                                        <i class="fa-solid fa-location-dot text-success text-lg me-2"></i>
                                    @endif

                                    @if($tr->trackerID < $documents->first()->trackerID)
                                    <iconify-icon icon="icon-park-twotone:check-one" width="18" height="18" class="me-2 text-success"></iconify-icon>
                                    @else         
                                    <iconify-icon icon="ph:minus-circle-duotone" width="18" height="18" class="me-2"></iconify-icon>                           
                                    @endif

                                    @if($tr->sectionID != null)

                                    <span 
                                     @if($tr->trackerID > $documents->first()->trackerID)
                                        style="opacity: 0.4;"
                                     @endif
                                     >
                                        {{ $tr->Section->section }}
                                    </span>
                                    @else
                                    <span 
                                    @if($tr->trackerID > $documents->first()->trackerID)
                                       style="opacity: 0.4"
                                    @endif
                                    >
                                       {{ 'Office Receiver' }}
                                   </span>
                                    @endif
                                    </div>
                                    
                                   
                                    
                                    @foreach ($returnedlogs->where('trackerID', $tr->trackerID) as $rlg)
                                    <div class="text-xs text-normal text-danger">
                                        {!! $rlg->remarks !!} <div class="text-secondary fw-bold mt-2">
                                            @if($rlg->updated_at != null)
                                            {{ \Carbon\Carbon::parse($rlg->updated_at)->isToday() ? 'Today - ' . date('h:i A', strtotime($rlg->updated_at)) : date('M. d, Y - h:i A', strtotime($rlg->updated_at)) }}
                                            @endif
                                        </div>
                                        <hr>
                                    </div>
                                    @endforeach

                                    <hr @if ($documents->where('pending', 0)->first()?->trackerID == $tr->trackerID) style="padding: 2px;" @endif>
                                </li>

                    
                    @if ($loop->last || $tracker[$loop->index + 1]->officeID !== $tr->officeID)
                            </ul>
                        </div>
                    @endif
                @endforeach


                
            <p
                class="text-sm
                @if ($documents->first()->status == 0) fw-bolder text-success @endif
                ">
                @if ($documents->first()->status == 0)
                    <i class="fa-solid fa-circle-check text-success me-1"></i>
                @else
                    <i class="fa-solid fa-circle-minus text-danger me-1"></i>
                @endif
                
                Done
                @if ($documents->first()->status == 0)
                    <span class="text-normal">| {{ date('M. d, Y - h:i A', strtotime($documents->first()->updated_at)) }}</span>
                @endif
            </p>
        </div>
    </div>
</div>
</div>
