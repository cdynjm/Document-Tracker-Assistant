<!-- The Modal -->
<div class="modal fade" id="returnDocumentModal" aria-hidden="true" style="display: none;" >
    <div class="modal-dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Return Document</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="return-document" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="documentID" class="form-control" readonly>
                        <input type="hidden" id="data-id" name="dataID" class="form-control" readonly>
                        <input type="hidden" id="office-id" name="id" class="form-control" readonly>
                        
                        <label for="">Return to Office</label>
                        <select name="office" id="return-to-office" class="form-select" required>
                            <option value="">Select Office...</option>
                        </select>
                        
                        <label for="">Reason</label>
                        <textarea name="reason" id="" class="form-control mb-2" cols="30" rows="10"></textarea>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Return</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
