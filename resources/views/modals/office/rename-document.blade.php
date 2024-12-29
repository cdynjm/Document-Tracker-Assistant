<!-- The Modal -->
<div class="modal fade" id="renameDocumentModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Rename QR Code</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class=" mb-4" role="alert">
                    <strong>Important Notice:</strong>
                    <ul class="mt-2">
                        <li><small>Renaming QR codes is not recommended unless absolutely necessary.</small></li>
                        <li><small>Do NOT modify the timestamp in the QR code name.</small></li>
                        <li><small>Only rename when the document is:</small>
                            <ul>
                                <li><small>At your office (Whenever necessary)</small></li>
                                <li><small>Returned from circulation (Whenever necessary)</small></li>
                            </ul>
                        </li>
                        <li><small>Changing the QR code name will require reprinting the QR code.</small></li>
                    </ul>
                </div>
                
                <form action="" id="rename-document-code" enctype="multipart/form-data">
                    <div class="row">
                       
                         <input type="hidden" class="form-control" name="id" id="code-id" required>        
                        
                        <div class="col-md-12">
                            <label for="code-name">Code Name</label>
                            <textarea name="code" id="code-name" cols="30" rows="5" class="form-control" required></textarea>     
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-sm bg-dark text-white">Rename</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>