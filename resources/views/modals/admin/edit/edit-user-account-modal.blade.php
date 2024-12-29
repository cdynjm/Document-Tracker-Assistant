<!-- The Modal -->
<div class="modal fade" id="editUserAccountModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Edit User Account</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="update-user-account" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control mb-2" name="id" id="id" readonly>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Name</label>
                                <input type="text" class="form-control mb-2" name="name" id="name" required>

                                <label for="">Office Section</label>
                                <select name="section" id="section" class="form-select mb-2" required>
                                    <option value="">Select...</option>
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

                                <label for="">Email</label>
                                <input type="email" class="form-control mb-2" name="email" id="email" required>

                                <label for="">New Password</label>
                                <input type="password" class="form-control mb-2 password" name="password">

                                <div id="toggle-password" class="mt-2 bg-transparent ms-1 cursor-pointer text-sm mb-4">
                                    <i class="fa fa-eye eye-icon"></i> <small><span class="text">Show</span> Password</small>
                                </div> 
                                <hr>
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input" type="checkbox" id="specialAccount" value="1" name="special">
                                    <label class="form-check-label" for="specialAccount">Special Account?</label>
                                </div>  

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
