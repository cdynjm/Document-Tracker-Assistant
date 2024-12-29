<!-- The Modal -->
<div class="modal fade" id="generateQRCodeModal" aria-hidden="true" style="display: none;" >
    <div class="modal-dialog modal-lg" data-backdrop="static" data-keyboard="false">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Generate QR Code/s</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="generate-qrcode" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Total</label>
                                <input type="number" class="form-control" step="1" min="1" value="1" name="quantity" required>        
                            </div>
                            <div class="col-md-6">
                                <label for="">Document Type</label>
                                <select name="docType" id="" class="form-select" required>
                                    <option value="">Select...</option>
                                    @foreach ($docType as $dt)
                                        <option value="{{ $aes->encrypt($dt->id) }}">{{ $dt->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="">Additional Information</label>
                                <textarea name="extension" cols="30" rows="5" class="form-control" required></textarea>      
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
