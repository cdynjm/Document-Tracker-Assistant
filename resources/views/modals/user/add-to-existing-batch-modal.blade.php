<!-- The Modal -->
<div class="modal fade" id="addToExistingBatchModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Select Available Batch</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="insert-to-existing-batch" enctype="multipart/form-data">

                    <input type="hidden" class="form-control" id="documentID" name="id">
                    <input type="hidden" class="form-control" id="documentType">

                    <label for="">Batch</label>
                    <select name="batch" class="form-select" id="" required>
                        <option value="">Select...</option>
                        @foreach ($batchDocuments as $docType => $document)
                            @php
                                // Filter documents that match the tracker condition
                                $filteredDocs = $document->filter(function ($doc) use ($tracker) {
                                    return $tracker
                                        ->where('docType', $doc->docType)
                                        ->where('trackerID', $doc->trackerID)
                                        ->where('sectionID', auth()->user()->sectionID)
                                        ->isNotEmpty();
                                });
                            @endphp

                            @if ($filteredDocs->isNotEmpty())
                                <optgroup label="{{ $docType }}">
                                    @foreach ($document as $doc)
                                        @foreach ($tracker->where('docType', $doc->docType)->where('trackerID', $doc->trackerID)->where('sectionID', auth()->user()->sectionID) as $tr)
                                            <option value="{{ $aes->encrypt($doc->id) }}"
                                                data-group="{{ $doc->docType }}">
                                                {{ $doc->qrcode }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </optgroup>
                            @endif
                        @endforeach
                    </select>


                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-sm bg-dark text-white">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
