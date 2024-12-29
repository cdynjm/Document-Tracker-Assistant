<form action="" id="update-document-type" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $aes->encrypt($docType->id) }}" class="form-control" readonly>
    <div class="row">
        <div class="col-md-12 mb-2">
            <label for="">Document Name</label>
            <input type="text" class="form-control mb-2" value="{{ $docType->name }}" name="name" required>
        </div>

        <div class="col-md-12 mb-2">
            <h6 class="mb-1">Document Tracking Process</h6>

            <div class="mb-3">
                <small class="text-danger">You can hold and drag the number to interchange the steps of the tracking process whenever necessary</small>
            </div>
          <!--  <button class="btn btn-xs bg-gradient-danger text-white" id="delete-tracker" type="button"><i class="fas fa-trash"></i></button> -->

            <!-- Sortable Tracker Container -->
            <div id="tracker-container">
                @foreach ($tracker as $index => $tr)
                <div class="tracker-wrapper d-flex align-items-center mb-2" data-tracker-index="{{ $index }}">
                    <!-- Delete button -->
                    <a href="javascript:;" class=" text-danger delete-tracker me-2 mt-1" title="Remove">
                        <iconify-icon icon="lets-icons:remove-duotone" width="24" height="24"></iconify-icon>
                    </a>
                    <!-- Tracker number -->
                    <span class="tracker-number me-2 fw-bolder text-sm" title="Hold and drag to reorder">{{ $index + 1 }}. </span>
                    <!-- Select dropdown -->
                    <select data-mdb-select-init name="tracker[]" class="form-control fw-bold border-white cursor-pointer" required>
                        <option value="">Select Office Section...</option>
                        <option value="{{ $aes->encrypt('0') }}" @selected($tr->sectionID == null)>Source Office</option>
                        @foreach ($offices as $of)
                            <optgroup label="{{ $of->office }}">
                                @foreach ($sections as $sec)
                                    @if($sec->officeID == $of->id)
                                        <option value="{{ $aes->encrypt($sec->id) }}" @selected($tr->sectionID == $sec->id)>{{ $sec->section }}</option>
                                    @endif
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                @endforeach
            </div>

            <button class="btn btn-xs bg-dark text-white" id="add-tracker" type="button"><i class="fas fa-plus"></i></button>

            
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <button type="submit" class="btn btn-sm bg-dark text-white">Update</button>
    </div>
</form>

<script>
    $(document).ready(function () {
    // Initialize sortable for the tracker container
    $("#tracker-container").sortable({
        handle: ".tracker-number", // Drag handle
        update: function () {
            // Update step numbers after sorting
            updateStepNumbers();
        }
    });

    // Function to update the step numbers dynamically
    function updateStepNumbers() {
        $("#tracker-container .tracker-wrapper").each(function (index) {
            $(this).find(".tracker-number").text((index + 1) + ". ");
        });
    }

    // Activate Bootstrap tooltips if using Bootstrap
    $('[title]').tooltip();
});

</script>

<style>
    .tracker-number {
        cursor: grab; /* Hand cursor for dragging */
    }
    .tracker-number:active {
        cursor: grabbing; /* Grabbing cursor when clicked */
    }
</style>
