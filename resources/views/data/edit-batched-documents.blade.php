
<div id="edit-batch-document-data-result">

    <label for="">Batch Name</label>
    <input type="text" class="form-control mb-2" id="additional-information" value="{{ $batchName->qrcode }}">

    <table class="table align-items-center mb-0">
        <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    #</th>
                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="40%">
                    Code</th>
                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Type</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Source Office</th>
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
                $count = 1;
            @endphp
            @foreach ($toBeBatch as $docType => $document)
        
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
                            <input type="checkbox" class="groupCheckbox me-2" data-group="{{ $docType }}">
                            <iconify-icon icon="solar:document-text-bold-duotone" width="24" height="24" class="me-1"></iconify-icon>
                            {{ $docType }}
                        </div>
                    </td>
                </tr>
            @endif
        
            @foreach ($document as $doc)
                @foreach ($tracker->where('docType', $doc->docType)->where('trackerID', $doc->trackerID)->where('sectionID', auth()->user()->sectionID) as $tr)
                    <tr>
                        <td class="text-center text-sm" id="{{ $aes->encrypt($doc->id) }}" docType="{{ $aes->encrypt($doc->docType) }}">
                            <input type="checkbox" class="childCheckbox me-2" data-group="{{ $docType }}" value="{{ $aes->encrypt($doc->id) }}" name="document" @checked($doc->download == 1)>
                            {{ $count }}
                        </td>
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
                            <span class="text-sm fw-bold">{{ $doc->type->name }}</span>
                        </td>
                        <td class="text-wrap text-center">
                            <span class="text-sm fw-bold">{{ $doc->Office->office }}</span>
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