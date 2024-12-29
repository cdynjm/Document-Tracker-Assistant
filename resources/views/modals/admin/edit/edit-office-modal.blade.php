<!-- The Modal -->
<div class="modal fade" id="editOfficeModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Edit Office</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="update-office" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" class="form-control" name="id" readonly>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Office Name</label>
                                <input type="text" id="office" class="form-control" name="office" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
