<form action="" id="update-office-account" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $aes->encrypt($officeAccount->id) }}" class="form-control" readonly>
    <div class="row">
        <div class="col-md-12 mb-2">
            <label for="">Account Name</label>
            <input type="text" class="form-control mb-2" value="{{ $officeAccount->name }}" name="name" required>

            <label for="">Office Name</label>
            <select name="office" class="form-select mb-2" id="" required>
                <option value="">Select...</option>
                @foreach ($offices as $of)
                    <option value="{{ $aes->encrypt($of->id) }}" @if($of->id == $officeAccount->officeID) selected @endif>{{ $of->office }}</option>
                @endforeach
            </select>

            <label for="">Email</label>
            <input type="email" class="form-control mb-2" value="{{ $officeAccount->email }}" name="email" required>

            <label for="">New Password</label>
            <input type="password" class="form-control mb-2 password" name="password">

            <div id="toggle-password" class="mt-2 bg-transparent ms-1 cursor-pointer text-sm mb-4">
                <i class="fa fa-eye eye-icon"></i> <small><span class="text">Show</span> Password</small>
            </div>  
        </div>

    </div>
    <div class="d-flex justify-content-center mt-4">
        <button type="submit" class="btn btn-sm bg-dark text-white">Update</button>
    </div>
</form>