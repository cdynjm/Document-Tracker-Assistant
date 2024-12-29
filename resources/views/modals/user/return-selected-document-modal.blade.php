<!-- The Modal -->
<div class="modal fade" id="returnSelectedDocumentModal" aria-hidden="true" style="display: none;" >
    <div class="modal-dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Return Selected Document/s</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="return-selected-document" enctype="multipart/form-data">
                        <div id="hiddenInputsContainer"></div>
                        <input type="" id="selected-data-id" name="dataID" class="form-control" readonly>
                        <input type="" id="selected-office-id" name="id" class="form-control" readonly>
                        
                        <label for="">Return to Office</label>
                        <select name="office" id="return-to-selected-office" class="form-select" required>
                            <option value="">Select Office...</option>
                        </select>

                        <label for="">Reason</label>
                        <textarea name="reason" id="" class="form-control" cols="30" rows="10"></textarea>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Return</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
