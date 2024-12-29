<!-- The Modal -->
<div class="modal fade" id="printQRCodeModal{{ $doc->qrcode }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">QR Code</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">  
                <div id="qrCodeContainer">
                    <div class="row">
                        <!-- Attachment QR Code -->
                        <div class="col-md-12 text-center">
                            <div class="attachment">
                                <div style="margin-bottom: 20px">
                                    <small><strong>BATCHED DOCUMENTS (MAIN QRCODE)</strong></small>
                                </div>
                                <div>
                                    {!! QrCode::size(150)->generate($doc->qrcode) !!}
                                    <p style="margin: 20px;" class="mb-1">{{ $doc->qrcode }}</p>
                                    <button 
                                        class="qr-button btn btn-outline-dark mt-2" 
                                        data-type="attachment">
                                        Select
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    <button id="printQRCodeButton" class="btn btn-sm bg-dark text-white">Print / Save as PDF</button>
                </div>
            </div>
        </div>
    </div>
</div>


