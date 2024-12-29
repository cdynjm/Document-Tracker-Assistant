
<div id="document-data-result">
<table class="table align-items-center mb-0 d-none d-sm-table">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                #</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="40%">
                Code</th>
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
    <tbody>
        @php
            $count = 1;
        @endphp
        @foreach ($documents as $docType => $document)

        @php
        // Filter documents that match the tracker condition
        $filteredDocs = $document->filter(function ($doc) use ($tracker) {
            return $tracker->where('docType', $doc->docType)
                ->where('trackerID', $doc->trackerID)
                ->where('sectionID', auth()->user()->sectionID)
                    ->isNotEmpty();
            });
        @endphp

       @if ($filteredDocs->isNotEmpty())
        <tr>
            <td colspan="10" class="text-start font-weight-bolder">
                <div class="d-flex align-items-center">
                    <iconify-icon icon="solar:document-text-bold-duotone" width="24" height="24" class="me-1"></iconify-icon> {{ $docType }}
                </div>
            </td>
        </tr>
        @endif

        @foreach ($document as $doc)
            @foreach ($tracker->where('docType', $doc->docType)->where('trackerID', $doc->trackerID)->where('sectionID', auth()->user()->sectionID) as $tr)
                
                    <tr>
                        <td class="text-center text-sm"
                        id="{{ $aes->encrypt($doc->id) }}"
                        officeID="{{ $aes->encrypt($offices->id) }}"
                        dataID="{{ $aes->encrypt($offices->id) }}"
                        docType="{{ $aes->encrypt($doc->docType) }}"
                        
                        >
                       <!-- <input type="checkbox" class="childCheckbox me-2" value="{{ $aes->encrypt($doc->id) }}"> -->
                        {{ $count }}</td>
                        <td>
                            <div class="d-flex px-2 text-wrap py-1 align-items-center">
                                <div class="me-2">
                                    {!! QrCode::size(35)->generate($doc->qrcode) !!}
                                </div>
                                
                                    <a>
                                        <h6 class="mb-0 text-sm">{{ $doc->qrcode }}</h6>
                                    </a>
                               
                            </div>
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
                        <td class="text-center">
                            <a href="javascript:;" id="reject-document" title="Reject/Return" class="text-secondary font-weight-bold text-xs me-2 mb-2 d-flex align-items-center"
                                data-toggle="tooltip"
                                
                                data-id="{{ $aes->encrypt($doc->id) }}"
                                data-officeid="{{ $aes->encrypt($offices->id) }}"
                                data-dataid="{{ $aes->encrypt($offices->id) }}"
                                data-doctype="{{ $aes->encrypt($doc->docType) }}"
                                data-office="{{ $offices->name }}"
                                
                                >
                                <iconify-icon icon="streamline:return-2-solid" height="18" class="me-1"></iconify-icon>
                                <small>Return</small>
                            </a>
                            @if($tracker->where('docType', $doc->docType)->sortByDesc('trackerID')->first()->trackerID != $doc->trackerID)
                            <a href="javascript:;" id="forward-document" 
                            
                            data-text="This will forward the document to the next section." 
                            data-id="{{ $aes->encrypt($doc->id) }}"
                            data-officeid="{{ $aes->encrypt($offices->id) }}"
                            data-dataid="{{ $aes->encrypt($offices->id) }}"
                            data-doctype="{{ $aes->encrypt($doc->docType) }}"

                            class="text-secondary fw-bold text-xs me-2 d-flex align-items-center"
                                title="Forward" data-toggle="tooltip">
                                <iconify-icon icon="bxs:paper-plane" height="18" class="me-1"></iconify-icon>
                                <small>Forward</small>
                            </a>
                            @else
                            <a href="javascript:;" id="forward-document" 
                            
                            data-text="This transaction will be mark as done." 
                            data-id="{{ $aes->encrypt($doc->id) }}"
                            data-officeid="{{ $aes->encrypt($offices->id) }}"
                            data-dataid="{{ $aes->encrypt($offices->id) }}"
                            data-doctype="{{ $aes->encrypt($doc->docType) }}"

                            class="text-secondary fw-bold text-xs me-2 d-flex align-items-center"
                                title="Forward" data-toggle="tooltip">
                                <iconify-icon icon="icon-park-twotone:check-one" height="20" class="me-1"></iconify-icon>
                                <small>Complete Transaction</small>
                            </a>
                            @endif
                        </td>
                        
                    </tr>
                    @php
                        $count += 1;
                    @endphp
               
             @endforeach

             
             
             @endforeach
        @endforeach
    </tbody>
</table>

<div class="list-container d-sm-none d-block">
    @foreach ($documents as $docType => $document)

        @php
        // Filter documents that match the tracker condition
        $filteredDocs = $document->filter(function ($doc) use ($tracker) {
            return $tracker->where('docType', $doc->docType)
                ->where('trackerID', $doc->trackerID)
                ->where('sectionID', auth()->user()->sectionID)
                    ->isNotEmpty();
            });
        @endphp

       @if ($filteredDocs->isNotEmpty())
       <div class="d-flex align-items-center fw-bolder mb-3">
            <iconify-icon icon="solar:document-text-bold-duotone" width="24" height="24" class="me-1"></iconify-icon> {{ $docType }}
        </div>
        @endif

        @foreach ($document as $doc)
            @foreach ($tracker->where('docType', $doc->docType)->where('trackerID', $doc->trackerID)->where('sectionID', auth()->user()->sectionID) as $tr)
                <div class="list-item mb-1">
                    
                       
                      <!--  <input type="checkbox" class="childCheckbox me-2" value="{{ $aes->encrypt($doc->id) }}"> -->
                        

                        <div class="d-flex align-items-center">
                            <div class="me-2" id="print-qrcode" data-code="{{ $doc->qrcode }}">
                                {!! QrCode::size(35)->generate($doc->qrcode) !!}
                            </div>
                            <h6 class="mb-0 text-xs">{{ $doc->qrcode }}</h6>
                        </div>


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
                        
                        
                       
                        <div class="text-start">
                            <a href="javascript:;" id="reject-document" title="Reject/Return" class="text-secondary font-weight-bold text-xs me-2 mb-2 "
                                data-toggle="tooltip"
                                
                                data-id="{{ $aes->encrypt($doc->id) }}"
                                data-officeid="{{ $aes->encrypt($offices->id) }}"
                                data-dataid="{{ $aes->encrypt($offices->id) }}"
                                data-doctype="{{ $aes->encrypt($doc->docType) }}"
                                data-office="{{ $offices->name }}"
                                
                                >
                                <iconify-icon icon="streamline:return-2-solid" height="18" class="me-1"></iconify-icon>
                                <small>Return</small>
                            </a>
                            @if($tracker->where('docType', $doc->docType)->sortByDesc('trackerID')->first()->trackerID != $doc->trackerID)
                            <a href="javascript:;" id="forward-document" 
                            
                            data-text="This will forward the document to the next section." 
                            data-id="{{ $aes->encrypt($doc->id) }}"
                            data-officeid="{{ $aes->encrypt($offices->id) }}"
                            data-dataid="{{ $aes->encrypt($offices->id) }}"
                            data-doctype="{{ $aes->encrypt($doc->docType) }}"

                            class="text-secondary fw-bold text-xs me-2 "
                                title="Forward" data-toggle="tooltip">
                                <iconify-icon icon="bxs:paper-plane" height="18" class="me-1"></iconify-icon>
                                <small>Forward</small>
                            </a>
                            @else
                            <a href="javascript:;" id="forward-document" 
                            
                            data-text="This transaction will be mark as done." 
                            data-id="{{ $aes->encrypt($doc->id) }}"
                            data-officeid="{{ $aes->encrypt($offices->id) }}"
                            data-dataid="{{ $aes->encrypt($offices->id) }}"
                            data-doctype="{{ $aes->encrypt($doc->docType) }}"

                            class="text-secondary fw-bold text-xs me-2 "
                                title="Forward" data-toggle="tooltip">
                                <iconify-icon icon="icon-park-twotone:check-one" height="20" class="me-1"></iconify-icon>
                                <small>Complete Transaction</small>
                            </a>
                            @endif
                        </div>
                       
                </div>
                <hr>
             @endforeach
             @endforeach
        @endforeach
    </div>
</div> 