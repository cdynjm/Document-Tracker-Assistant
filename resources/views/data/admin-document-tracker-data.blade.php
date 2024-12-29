<table class="table align-items-center mb-0" id="admin-document-tracker-data-result">
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
        </tr>
    </thead>
    <tbody>
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
                    <div class="me-2" id="print-qrcode">
                        {!! QrCode::size(35)->generate($doc->qrcode) !!}
                    </div>
                    
                        <a wire:navigate title="View Tracker" href="{{ route('admin-document-tracker', ['id' => $aes->encrypt($doc->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip">
                            <h6 class="mb-0 text-sm">{{ $doc->qrcode }}</h6>
                        </a>
                    
                </div>
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
                                        <h6 class="mb-0 text-sm">{{ $doc->Office->office }}</h6>
                                        <p class="text-sm mb-0">Source Office</p>
                                    </div>
                                </div>
                            </div>
                            @else
                            <span class="text-xs fw-bold text-danger">
                                <span class="me-2"><i class="fas fa-minus-circle"></i></span>Currently at their Office
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
            </tr>
            @endforeach
        @endforeach
    </tbody>
</table>