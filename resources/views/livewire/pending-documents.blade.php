<div wire:poll.visible.10s="fetchPendingDocuments">
    <div class="list-container">
        @foreach ($documents as $doc)
        <a wire:navigate title="View" href="{{ route('admin-document-tracker', ['id' => $aes->encrypt($doc->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2">
            
            <div class="list-item mb-1">
                <!-- Code Section -->
                <div class="d-flex align-items-center">
                    <div class="me-2" id="print-qrcode">
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
                                We noticed that that this document has not been moved for <strong>{{ $daysElapsed }} days</strong>. 
                                Please visit the last office or station it was processed at to ensure your transaction is still ongoing.
                            </small>
                        </div>
                    @endif
                    @endif
                <div class="d-flex align-items-center mt-2">
                    <iconify-icon icon="line-md:my-location-loop" width="22" height="22" class="me-1"></iconify-icon> View Tracker
                </div>
            </div>
            <hr>
        </a>
        @endforeach
    </div>
</div>
