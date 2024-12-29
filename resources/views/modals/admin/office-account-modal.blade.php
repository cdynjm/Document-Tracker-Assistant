<!-- The Modal -->
<div class="modal fade" id="createOfficeAccountModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">New Office Account</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="create-office-account" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="">Account Name</label>
                                <input type="text" class="form-control mb-2" name="name" required>

                                <label for="">Office Name</label>
                                <select name="office" class="form-select mb-2" id="" required>
                                    <option value="">Select...</option>
                                    @foreach ($offices as $of)
                                        <option value="{{ $aes->encrypt($of->id) }}">{{ $of->office }}</option>
                                    @endforeach
                                </select>

                                <label for="">Email</label>
                                <input type="email" class="form-control mb-2" name="email" required>

                                <label for="">Password</label>
                                <input type="password" class="form-control mb-2 password" name="password" required>

                                <div id="toggle-password" class="mt-2 bg-transparent ms-1 cursor-pointer text-sm mb-4">
                                    <i class="fa fa-eye eye-icon"></i> <small><span class="text">Show</span> Password</small>
                                </div>  
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
