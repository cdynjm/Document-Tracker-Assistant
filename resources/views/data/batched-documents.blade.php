
<div id="batch-document-data-result">
    <table class="table align-items-center mb-0">
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
            @foreach ($batchDocuments as $docType => $document)

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
                            <iconify-icon icon="solar:document-text-bold-duotone" width="24" height="24" class="me-1"></iconify-icon>
                            {{ $docType }}
                        </div>
                    </td>
                </tr>
            @endif

            @foreach ($document as $doc)
                @foreach ($tracker->where('docType', $doc->docType)->where('trackerID', $doc->trackerID)->where('sectionID', auth()->user()->sectionID) as $tr)
                    @include('modals.user.print-qrcode-modal')
                    <tr>
                        <td class="text-center text-sm" id="{{ $aes->encrypt($doc->id) }}" docType="{{ $aes->encrypt($doc->docType) }}">
                           
                            {{ $count }}
                        </td>
                        <td>
                            <div class="d-flex px-2 text-wrap py-1 align-items-center">
                                <div class="me-2" @if(Auth::user()->special == 1) id="print-qrcode" @endif data-code="{{ $doc->qrcode }}">
                                    {!! QrCode::size(35)->generate($doc->qrcode) !!}
                                </div>
                                <a>
                                    <h6 class="mb-0 text-sm">{{ $doc->qrcode }}</h6>
                                </a>
                            </div>
                        </td>
                        <td class="">
                            <span class="text-sm fw-bold">{{ $doc->type->name }}</span>
                        </td>
                        <td class="text-center">
                            <span class="text-xs fw-bold">{{ date('M. d, Y | h:i A', strtotime($doc->updated_at)) }}</span>
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
                        <td>
                            @if($tracker->where('docType', $doc->docType)->sortByDesc('trackerID')->first()->trackerID != $doc->trackerID)
                            <a href="javascript:;" id="forward-batch-document" 
                            
                            data-text="This will forward the document to the next section. @if(Auth::user()->special == 1) Note: Please ensure that you have already printed the main QR code, as forwarding the batch document cannot be undone. @endif" 
                            data-id="{{ $aes->encrypt($doc->id) }}"
                            data-officeid="{{ $aes->encrypt($doc->userID) }}"
                            data-dataid="{{ $aes->encrypt($doc->userID) }}"
                            data-doctype="{{ $aes->encrypt($doc->docType) }}"

                            class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2"
                                title="Forward" data-toggle="tooltip">
                                <iconify-icon icon="bxs:paper-plane" height="18" class="me-1"></iconify-icon>
                                <small>Forward</small>
                            </a>
                             @else
            
                             <a href="javascript:;" id="forward-batch-document" 
                            
                            data-text="This transaction will be mark as done." 
                            data-id="{{ $aes->encrypt($doc->id) }}"
                            data-officeid="{{ $aes->encrypt($doc->userID) }}"
                            data-dataid="{{ $aes->encrypt($doc->userID) }}"
                            data-doctype="{{ $aes->encrypt($doc->docType) }}"

                            class="text-secondary fw-bold text-xs me-2 d-flex align-items-center mb-2"
                                title="Forward" data-toggle="tooltip">
                                <iconify-icon icon="icon-park-twotone:check-one" height="20" class="me-1"></iconify-icon>
                                <small>Complete Transaction</small>
                            </a>

                           @endif

                           @if(Auth::user()->special == 1)
                           <a wire:navigate href="{{ route('edit-batch-documents', ['id' => $aes->encrypt($doc->id)]) }}" id="edit-batch-document"

                            class="text-secondary fw-bold text-xs me-2 d-flex align-items-center"
                                title="Edit/Update" data-toggle="tooltip">
                                <iconify-icon icon="lets-icons:edit-duotone" height="22" class="me-1"></iconify-icon>
                                <small>Edit/Update</small>
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

</div>