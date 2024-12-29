<div id="document-tracker-data-result">
    <table class="table align-items-center mb-0 mt-0 d-none d-sm-table">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    #</th>
                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="30%">
                    Code</th>
                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Current Location</th>
                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                     Type</th>
                <th
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Updated On</th>
                <th
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Remarks</th>
                <th
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Actions</th>
            </tr>
        </thead>
        <tbody >
            @php
                $count = 0;
            @endphp
            @foreach ($documents as $docType => $document)
    
            <tr>
                <td colspan="10" class="text-start font-weight-bolder">
                    <div class="d-flex align-items-center">
                        <iconify-icon icon="solar:document-text-bold-duotone" width="24" height="24" class="me-1"></iconify-icon> {{ $docType }}
                    </div>
                </td>
            </tr>
    
            @foreach ($document as $doc)
            @include('modals.office.print-qrcode-modal')
    
            <tr>
                <td class="text-center text-sm"
                id="{{ $aes->encrypt($doc->id) }}"
                qrcode="{{ $doc->qrcode }}"
                docType="{{ $aes->encrypt($doc->docType) }}"
                >
                @if($doc->trackerID == 0)
                <!--    <input type="checkbox" class="childCheckbox me-2" value="{{ $aes->encrypt($doc->id) }}">
                    <input type="checkbox" class="childCheckboxHidden  me-2" data-name="{{ $doc->qrcode }}" value="{{ $doc->qrcode }}" hidden> -->
                @endif
                <span class="">{{ $count += 1 }}</span>
                </td>
                <td>
                    <div class="d-flex px-2 py-1 text-wrap align-items-center">
                        <div class="me-2" id="print-qrcode" data-code="{{ $doc->qrcode }}">
                            {!! QrCode::size(35)->generate($doc->qrcode) !!}
                        </div>
                        
                            <a wire:navigate title="View Tracker" href="{{ route('office-document-tracker', ['id' => $aes->encrypt($doc->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip">
                                <h6 class="mb-0 text-sm">{{ $doc->qrcode }}</h6>
                            </a>
                        
                    </div>

                    @if($doc->updated_at)
                    @php
                        $updatedAt = $doc->updated_at; // Get the 'updated_at' timestamp
                        $daysElapsed = now()->diffInDays($updatedAt); // Calculate the number of days since the document was updated
                    @endphp
                
                    @if($daysElapsed >= 3)
                        <div class="text-sm d-flex align-items-center my-2 rounded text-wrap text-justify" style="background: #FFF5CD; padding: 10px;">
                            <iconify-icon icon="gridicons:notice" width="24" height="24" class="text-warning me-1"></iconify-icon>
                            <span>
                                We noticed that your document has not been moved for <strong>{{ $daysElapsed }} days</strong>. 
                                Please visit the last office or station it was processed at to ensure your transaction is still ongoing.
                            </span>
                        </div>
                    @endif
                    @endif
                    
                </td>
                <td class="text-wrap">
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
                                        <h6 class="mb-0 text-sm">{{ Auth::user()->Office->office }}</h6>
                                        <p class="text-sm mb-0">Your Office</p>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-xs fw-bold text-danger">
                                <span class="me-2"><i class="fas fa-minus-circle"></i></span>Currently at your Office
                            </span>
                            @endif
                        @endif
                </td>
                <td class="">
                    <span class="text-sm fw-bold">
                        {{ $doc->type->name }}
                    </span>
                </td>
                <td class="text-center">
                    <span class="text-xs fw-bold">
                        {{ date('M. d, Y | h:i A', strtotime($doc->updated_at)) }}
                    </span>
                </td>
                <td class="text-wrap text-center">
                    <span class="text-xs fw-bold text-danger text-start">
                        @if($doc->remarks != null)
                            {!! $doc->remarks !!}
                        @else
                            <span class="text-secondary">-</span>
                        @endif
                    </span>
                </td>
                <td class="text-start">
                    <a wire:navigate title="View Tracker" href="{{ route('office-document-tracker', ['id' => $aes->encrypt($doc->id)]) }}?key={{ \Str::random(50) }}" 
                        class="text-secondary font-weight-bold text-xs me-2 d-flex align-items-center mb-2" 
                        >
                        <iconify-icon icon="carbon:view-filled" height="20" class="me-1"></iconify-icon>
                        <small>View Tracker</small>
                    </a>
    
                    @if($doc->trackerID == 0 && $doc->pending == 0)
                        <a data-remarks="{{ $doc->remarks }}" data-doctype="{{ $aes->encrypt($doc->docType) }}" data-id="{{ $aes->encrypt($doc->id) }}" href="javascript:;" id="forward-document" 
                            class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                            title="Forward" >
                            <iconify-icon icon="bxs:paper-plane" height="18" class="me-1"></iconify-icon>
                            <small>Forward</small>
                        </a>
                        <a data-id="{{ $aes->encrypt($doc->id) }}" data-code="{{ $doc->qrcode }}" href="javascript:;" id="rename-document" 
                            class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                            title="Forward" >
                            <iconify-icon icon="qlementine-icons:rename-16" height="18" class="me-1"></iconify-icon>
                            <small>Rename</small>
                        </a>
                    @endif
    
                    @if($doc->trackerID != 0)
                            @foreach($tracker->where('docType', $doc->docType)->where('trackerID', $doc->trackerID)->where('sectionID', null) as $tr)
                                
                                @if($doc->pending == 0)
                                <a data-remarks="{{ $doc->remarks }}" data-doctype="{{ $aes->encrypt($doc->docType) }}" data-id="{{ $aes->encrypt($doc->id) }}" href="javascript:;" id="forward-document" 
                                    class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                                    title="Forward" >
                                    <iconify-icon icon="bxs:paper-plane" height="18" class="me-1"></iconify-icon>
                                    <small>Forward</small>
                                </a>
    
                                <a data-id="{{ $aes->encrypt($doc->id) }}" data-code="{{ $doc->qrcode }}" href="javascript:;" id="rename-document" 
                                    class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                                    title="Forward" >
                                    <iconify-icon icon="qlementine-icons:rename-16" height="18" class="me-1"></iconify-icon>
                                    <small>Rename</small>
                                </a>
                                
                                <a href="javascript:;" id="delete-qrcode" title="Delete" data-id="{{ $aes->encrypt($doc->id) }}"
                                    class="text-secondary font-weight-bold text-xs d-flex align-items-center" 
                                    >
                                    <iconify-icon icon="ic:twotone-delete" height="22" class="me-1"></iconify-icon>
                                    <small>Delete</small>
                                </a>
                                @endif
                                    
                            @endforeach
                    @endif
                   
                    @if($doc->trackerID == 0 && $doc->pending == 0)
                        <a href="javascript:;" id="delete-qrcode" title="Delete" data-id="{{ $aes->encrypt($doc->id) }}"
                            class="text-secondary font-weight-bold text-xs d-flex align-items-center" 
                            >
                            <iconify-icon icon="ic:twotone-delete" height="22" class="me-1"></iconify-icon>
                            <small>Delete</small>
                        </a>
                    @endif
    
                   
                </td>
                
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    
    <div class="list-container d-sm-none d-block">
        @foreach ($documents as $docType => $document)
        <div class="d-flex align-items-center fw-bolder mb-3">
            <iconify-icon icon="solar:document-text-bold-duotone" width="24" height="24" class="me-1"></iconify-icon> {{ $docType }}
        </div>
        @foreach ($document as $doc)
            <div class="list-item mb-1">
                <!-- Code Section -->
                <div class="d-flex align-items-center">
                    <div class="me-2" id="print-qrcode" data-code="{{ $doc->qrcode }}">
                        {!! QrCode::size(35)->generate($doc->qrcode) !!}
                    </div>
                    <h6 class="mb-0 text-xs">{{ $doc->qrcode }}</h6>
                </div>
                
                <!-- Location and Status Section -->
                <div class="mt-2">
                    
                    <div>
                        @if($doc->trackerID != 0)
                            @foreach($tracker->where('docType', $doc->docType) as $tr)
                                @if($tr->trackerID == $doc->trackerID)
                                    @if($tr->sectionID != null)
                                        @if($doc->pending == 1)
                                            <div>
                                                <small class="text-danger text-xs fw-bold">
                                                    En Route to Next Station:
                                                </small>
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                                                    <div>
                                                        <h6 class="mb-0 text-xs">{{ $tr->Section->Office->office }}</h6>
                                                        <p class="text-xs mb-0">{{ $tr->Section->section }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center mt-2">
                                                <i class="fas fa-map-marker-alt text-success text-sm me-3"></i>
                                                <div>
                                                    <h6 class="mb-0 text-xs">{{ $tr->Section->Office->office }}</h6>
                                                    <p class="text-xs mb-0">{{ $tr->Section->section }}</p>
                                                </div>
                                            </div>                                 
                                        @endif
                                    @else
                                        @if($doc->pending == 1)
                                            <div>
                                                <small class="text-danger fw-bold text-xs">
                                                    En Route to Next Station:
                                                </small>
                                                <div class="d-flex align-items-center mt-2">
                                                    <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                                                    <div>
                                                        <h6 class="mb-0 text-xs">{{ $doc->Office->office }}</h6>
                                                        <p class="text-xs mb-0">{{ 'Source Office Receiver' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center mt-2">
                                                <i class="fas fa-map-marker-alt text-success text-sm me-3"></i>
                                                <div>
                                                    <h6 class="mb-0 text-xs">{{ $doc->Office->office }}</h6>
                                                    <p class="text-xs mb-0">{{ 'Source Office Receiver' }}</p>
                                                </div>
                                            </div>                                 
                                        @endif
                                    @endif
                                @endif
                            @endforeach
                        @else
                            @if($doc->pending == 1)
                                <div>
                                    <small class="text-danger text-xs fw-bold">
                                        En Route to Next Station:
                                    </small>
                                    <div class="d-flex align-items-center mt-2">
                                        <img src="{{ asset('storage/images/paper-plane.gif') }}" class="avatar avatar-sm me-2" alt="">
                                        <div>
                                            <h6 class="mb-0 text-xs">{{ $doc->Office->office }}</h6>
                                            <p class="text-xs mb-0">Source Office</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-xs fw-bold text-danger">
                                    <span class="me-2"><i class="fas fa-minus-circle"></i></span>Currently at their Office
                                </span>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Updated On Section -->
                <div class="mt-2">
                   
                    <div>
                        <span class="text-xs fw-bold">
                            {{ date('M. d, Y | h:i A', strtotime($doc->updated_at)) }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="text-xs fw-bold">
                            {{ $doc->type->name }}
                        </span>
                    </div>
                    <div class="mb-2">
                        <span class="text-xs fw-bold text-danger text-start">
                            @if($doc->remarks != null)
                                {!! $doc->remarks !!}
                            @endif
                        </span>
                    </div>
                </div>
                
                @if($doc->updated_at)
                    @php
                        $updatedAt = $doc->updated_at; // Get the 'updated_at' timestamp
                        $daysElapsed = now()->diffInDays($updatedAt); // Calculate the number of days since the document was updated
                    @endphp
                
                    @if($daysElapsed >= 3)
                        <div class="text-sm d-flex align-items-center my-3 rounded text-wrap" style="background: #FFF5CD; padding: 10px;">
                            <iconify-icon icon="gridicons:notice" width="24" height="24" class="text-warning me-1"></iconify-icon>
                            <small>
                                We noticed that your document has not been moved for <strong>{{ $daysElapsed }} days</strong>. 
                                Please visit the last office or station it was processed at to ensure your transaction is still ongoing.
                            </small>
                        </div>
                    @endif
                    @endif
                    
                <a wire:navigate title="View Tracker" href="{{ route('office-document-tracker', ['id' => $aes->encrypt($doc->id)]) }}?key={{ \Str::random(50) }}" 
                    class="text-secondary font-weight-bold text-xs me-2 d-flex align-items-center mb-2" 
                    >
                    <iconify-icon icon="carbon:view-filled" height="20" class="me-1"></iconify-icon>
                    <small>View Tracker</small>
                </a>

                @if($doc->trackerID == 0 && $doc->pending == 0)
                    <a data-remarks="{{ $doc->remarks }}" data-doctype="{{ $aes->encrypt($doc->docType) }}" data-id="{{ $aes->encrypt($doc->id) }}" href="javascript:;" id="forward-document" 
                        class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                        title="Forward" >
                        <iconify-icon icon="bxs:paper-plane" height="18" class="me-1"></iconify-icon>
                        <small>Forward</small>
                    </a>
                    <a data-id="{{ $aes->encrypt($doc->id) }}" data-code="{{ $doc->qrcode }}" href="javascript:;" id="rename-document" 
                        class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                        title="Forward" >
                        <iconify-icon icon="qlementine-icons:rename-16" height="18" class="me-1"></iconify-icon>
                        <small>Rename</small>
                    </a>
                @endif

                @if($doc->trackerID != 0)
                        @foreach($tracker->where('docType', $doc->docType)->where('trackerID', $doc->trackerID)->where('sectionID', null) as $tr)
                            
                            @if($doc->pending == 0)
                            <a data-remarks="{{ $doc->remarks }}" data-doctype="{{ $aes->encrypt($doc->docType) }}" data-id="{{ $aes->encrypt($doc->id) }}" href="javascript:;" id="forward-document" 
                                class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                                title="Forward" >
                                <iconify-icon icon="bxs:paper-plane" height="18" class="me-1"></iconify-icon>
                                <small>Forward</small>
                            </a>

                            <a data-id="{{ $aes->encrypt($doc->id) }}" data-code="{{ $doc->qrcode }}" href="javascript:;" id="rename-document" 
                                class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2" 
                                title="Forward" >
                                <iconify-icon icon="qlementine-icons:rename-16" height="18" class="me-1"></iconify-icon>
                                <small>Rename</small>
                            </a>
                            
                            <a href="javascript:;" id="delete-qrcode" title="Delete"  data-id="{{ $aes->encrypt($doc->id) }}"
                                class="text-secondary font-weight-bold text-xs d-flex align-items-center" 
                                >
                                <iconify-icon icon="ic:twotone-delete" height="22" class="me-1"></iconify-icon>
                                <small>Delete</small>
                            </a>
                            @endif
                                
                        @endforeach
                @endif
               
                @if($doc->trackerID == 0 && $doc->pending == 0)
                    <a href="javascript:;" id="delete-qrcode" title="Delete" data-id="{{ $aes->encrypt($doc->id) }}" 
                        class="text-secondary font-weight-bold text-xs d-flex align-items-center" 
                        >
                        <iconify-icon icon="ic:twotone-delete" height="22" class="me-1"></iconify-icon>
                        <small>Delete</small>
                    </a>
                @endif

            </div>
            <hr>
      
        @endforeach
        @endforeach
    </div>
</div>