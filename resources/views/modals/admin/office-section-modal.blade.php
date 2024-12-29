<!-- The Modal -->
<div class="modal fade" id="createOfficeSectionModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">New Section</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="create-section" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Office Name</label>
                                <select name="office" class="form-select mb-2" id="" required>
                                    <option value="">Select...</option>
                                    @foreach ($offices as $of)
                                        <option value="{{ $aes->encrypt($of->id) }}">{{ $of->office }}</option>
                                    @endforeach
                                </select>
                                <label for="">Section Name</label>
                                <input type="text" class="form-control mb-2" name="section" required>
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
