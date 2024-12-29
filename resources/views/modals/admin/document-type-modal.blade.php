<!-- The Modal -->
<div class="modal fade" id="createDocumentTypeModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">New Document Type</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="create-document-type" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="">Document Name</label>
                                <input type="text" class="form-control mb-2" name="name" required>
                            </div>

                            <div class="col-md-12 mb-2">

                                <h6 class="mb-1">Document Tracking Process</h6>

                                <div class="mb-3">
                                    <small class="text-danger">You can hold and drag the number to interchange the steps of the tracking process whenever necessary</small>
                                </div>
                               
                              <!--  <button class="btn btn-xs bg-gradient-danger text-white" id="delete-tracker" type="button"><i class="fas fa-trash"></i></button> -->

                                <div id="tracker-container">
                                    <div class="tracker-wrapper d-flex align-items-center mb-2">
                                        <a href="javascript:;" class=" text-danger delete-tracker me-2 mt-1" title="Remove">
                                            <iconify-icon icon="lets-icons:remove-duotone" width="24" height="24"></iconify-icon>
                                        </a>
                                        <span class="tracker-number me-2 fw-bolder text-sm"  title="Hold and drag to reorder">1. </span>
                                        <select name="tracker[]" class="form-control fw-bold border-white cursor-pointer" required>
                                            <option value="">Select...</option>
                                            <option value="{{ $aes->encrypt('0') }}">Source Office</option>
                                            @foreach ($offices as $of)
                                                <optgroup label="{{ $of->office }}">
                                                    @foreach ($sections as $sec)
                                                        @if($sec->officeID == $of->id)
                                                            <option value="{{ $aes->encrypt($sec->id) }}">{{ $sec->section }}</option>
                                                        @endif
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <button class="btn btn-xs bg-dark text-white" id="add-tracker" type="button"><i class="fas fa-plus"></i></button>

                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 


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