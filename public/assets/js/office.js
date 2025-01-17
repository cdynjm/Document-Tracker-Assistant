$.ajaxSetup({
    headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    headers: {  "Authorization": "Bearer " + $('meta[name="token"]').attr('content') }
});

$(document).on("click", '#toggle-password', function() {
    let passwordField = $('.password');
    let passwordFieldType = passwordField.attr('type');
    let eyeIcon = $('#eye-icon');
    
    if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
        eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        $('#text').text('Hide ');
    } else {
        passwordField.attr('type', 'password');
        eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        $('#text').text('Show ');
    }
});

var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn bg-dark text-white',
        cancelButton: 'btn btn-secondary ms-3'
    },
    buttonsStyling: false
});

function documentTrackerDataTable() {
    $('#document-tracker-data-result').DataTable(
        {
            language: {
              'paginate': {
                'previous': '<span class="prev-icon"><i class="fas fa-angle-double-left"></i></span>',
                'next': '<span class="next-icon"><i class="fas fa-angle-double-right"></i></span>'
              },
              'lengthMenu': `Show 
                            <select class="form-select form-select-sm pe-5">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> 
                           entries`
            },
            pageLength: 20
          }
    );
    $('.dataTables_wrapper .dataTables_filter input').css('width', '200px');
}
function archivesDaTable() {
    $('#archives-data-result').DataTable(
        {
            language: {
              'paginate': {
                'previous': '<span class="prev-icon"><i class="fas fa-angle-double-left"></i></span>',
                'next': '<span class="next-icon"><i class="fas fa-angle-double-right"></i></span>'
              },
              'lengthMenu': `Show 
                            <select class="form-select form-select-sm pe-5">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select> 
                           entries`
            },
            pageLength: 20
          }
    );
    $('.dataTables_wrapper .dataTables_filter input').css('width', '200px');
}

/* document.addEventListener('livewire:navigated', () => { 
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#document-tracker-data-result')) {
            documentTrackerDataTable();
        }
    });
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#archives-data-result')) {
            archivesDaTable();
        }
    });
}); */

$(document).on('click', "#add-qrcode", function(e){
    $("#generateQRCodeModal").modal('show');
});

$(document).on('submit', "#generate-qrcode", function(e){
    e.preventDefault();
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            SweetAlert.showLoading(); // Show the loading indicator
            }
    });
    const formData = new FormData(this);
    async function APIrequest() {
        return await axios.post('/api/create/qrcode', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#generateQRCodeModal").modal('hide');
        $("select").val('');
        $("#document-tracker-data-result").html(response.data.documentTracker);
        $(".modal-content").addClass("bg-white");
        if ($.fn.dataTable.isDataTable('#document-tracker-data-result')) {
            $('#document-tracker-data-result').DataTable().clear().destroy();
            documentTrackerDataTable();
        }

        SweetAlert.fire({
            icon: 'success',
            title: 'Done',
            text: response.data.Message,
            confirmButtonColor: "#3a57e8"
        });
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('submit', "#rename-document-code", function(e){
    e.preventDefault();
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            SweetAlert.showLoading(); // Show the loading indicator
            }
    });
    const formData = new FormData(this);
    formData.append('_method', 'PATCH');
    async function APIrequest() {
        return await axios.post('/api/update/qrcode', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#renameDocumentModal").modal('hide');
        $("select").val('');
        $("#document-tracker-data-result").html(response.data.documentTracker);
        $(".modal-content").addClass("bg-white");
        if ($.fn.dataTable.isDataTable('#document-tracker-data-result')) {
            $('#document-tracker-data-result').DataTable().clear().destroy();
            documentTrackerDataTable();
        }

        SweetAlert.fire({
            icon: 'success',
            title: 'Done',
            text: response.data.Message,
            confirmButtonColor: "#3a57e8"
        });
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'QR Code name already exist.',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#masterCheckbox", function(e){
    $('.childCheckbox').prop('checked', $(this).prop('checked'));
    $('.childCheckboxHidden').prop('checked', $(this).prop('checked'));
});

$(document).on('change', ".childCheckbox", function(e){
    $(this).next('.childCheckboxHidden').prop('checked', $(this).prop('checked'));
});

$(document).on('click', "#startScanBtn", function(e) {
    $("#scannerModal").modal('show');
    const scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });

    scanner.addListener('scan', function(content) {
        console.log(content);
        const data = {
            documentID: content,
            _method: 'PATCH'
        };
        async function APIrequest() {
            return await axios.post('/api/update/scan-document-office', data, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            });
        }
        APIrequest().then(response => {
            if (response.data.res == 200) {
                SweetAlert.fire({
                    icon: 'success',
                    title: 'Done',
                    text: response.data.Message,
                    confirmButtonColor: "#3a57e8"
                }).then(() => {
                    location.reload();
                });
            } else if (response.data.res == 201) {
                SweetAlert.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'You have already scanned this document.',
                    confirmButtonColor: "#3a57e8"
                });
            }
        }).catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                title: 'Oops...',
                html: `
                    <h5>You are not authorized to scan this QR code! Possible reasons include:</h5>
                    <ul style="text-align: left; margin-left: 15px;">
                        <li><small>You have already forwarded this document.</small></li>
                        <li><small>This document was wrongly forwarded to you.</small></li>
                        <li><small>The QR code may be invalid.</small></li>
                    </ul>
                `,
                confirmButtonColor: "#3a57e8"
            });
        });

        $("#scannerModal").modal('hide');
        scanner.stop();
    });

    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            // Check for rear camera (back camera)
            const rearCamera = cameras.find(camera => camera.name.toLowerCase().includes('back') || camera.name.toLowerCase().includes('rear'));
            if (rearCamera) {
                // No flip for rear camera
                document.getElementById('scanner').style.transform = ""; 
                scanner.start(rearCamera);
            } else {
                // Fallback to the first available camera (if no rear camera)
                document.getElementById('scanner').style.transform = ""; 
                scanner.start(cameras[0]);
            }
        } else {
            console.error('No cameras found.');
        }
    }).catch(function(error) {
        console.error(error);
    });

    function stopScanner() {
        scanner.stop();
    }

    $(document).off('click.modalHandler').on('click.modalHandler', function(e) {
        if ($('#scannerModal').is(':visible') && !$(e.target).closest('.modal-dialog').length) {
            $("#scannerModal").modal('hide');
            stopScanner();
        }
    });

    $('#scannerModal').on('hidden.bs.modal', function() {
        stopScanner();
    });
});

$(document).on('click', "#startScanArchiveBtn", function(e){
    
    $("#scannerModal").modal('show');
    const scanner = new Instascan.Scanner({ video: document.getElementById('scanner') });
    scanner.addListener('scan', function(content) {
        $('#search-office-archives').val(content);
        $('#search-office-archives').trigger('keyup');
        $("#scannerModal").modal('hide');
        scanner.stop();
        Instascan.Camera.stop();
    });
    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            // Check for rear camera (back camera)
            const rearCamera = cameras.find(camera => camera.name.toLowerCase().includes('back') || camera.name.toLowerCase().includes('rear'));
            if (rearCamera) {
                // No flip for rear camera
                document.getElementById('scanner').style.transform = ""; 
                scanner.start(rearCamera);
            } else {
                // Fallback to the first available camera (if no rear camera)
                document.getElementById('scanner').style.transform = ""; 
                scanner.start(cameras[0]);
            }
        } else {
            console.error('No cameras found.');
        }
    }).catch(function(error) {
        console.error(error);
    });
    function stopScanner() {
        scanner.stop();
        Instascan.Camera.stop();
    }
   $(document).off('click.modalHandler').on('click.modalHandler', function(e) {
    if ($('#scannerModal').is(':visible') && !$(e.target).closest('.modal-dialog').length) {
        $("#scannerModal").modal('hide');
        stopScanner();
    }
    });
    $('#scannerModal').on('hidden.bs.modal', function() {
        stopScanner();
    });
});

$(document).on('click', "#forward-document", function (e) {
    const remarks = $(this).data('remarks'); // Fetch the remarks attribute
    const docType = $(this).data('doctype');
    const documentID = $(this).data('id'); // Fetch the document ID

    if (!remarks) {
        // If remarks are empty, execute the request
        SweetAlert.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: "This will forward the document to the next section.",
            showCancelButton: true,
            confirmButtonColor: '#160e45',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm'
        }).then((result) => {
            if (result.value) {
                SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    SweetAlert.showLoading(); // Show the loading indicator
                 }
            });

                const data = {
                    id: documentID,
                    _method: 'PATCH'
                };

                async function APIrequest() {
                    return await axios.post('/api/update/office-forward-document', data, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                        }
                    });
                }

                APIrequest().then(response => {
                    $("#document-tracker-data-result").html(response.data.documentTracker);
                    $(".modal-content").addClass("bg-white");
                    if ($.fn.dataTable.isDataTable('#document-tracker-data-result')) {
                        $('#document-tracker-data-result').DataTable().clear().destroy();
                        documentTrackerDataTable();
                    }

                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: response.data.Message,
                        confirmButtonColor: "#3a57e8"
                    });
                }).catch(error => {
                    console.error('Error:', error);
                    SweetAlert.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        confirmButtonColor: "#3a57e8"
                    });
                });
            }
        });
    } else {
        SweetAlert.fire({
            icon: 'info',
            title: 'Forward to Next Office',
            html: `
                <p>Please select the exact office that will be receiving the document again. Note: The first option represents the initial station, while the last option represents the most recent station. If there are two consecutive receiving/releasing stations, select the first one, as it is the receiving station, while the second one is the releasing station.</p>
                <select id="action-select" class="form-select">
                    <option value="" disabled selected>Loading...</option>
                </select>
            `,
            showCancelButton: true,
            confirmButtonText: 'Proceed',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const selectedAction = Swal.getPopup().querySelector('#action-select').value;
                if (!selectedAction) {
                    Swal.showValidationMessage('Please select an office!');
                }
                return { selectedOffice: selectedAction };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    SweetAlert.showLoading(); // Show the loading indicator
                 }
            });
    
                const data = {
                    id: documentID,
                    trackerID: result.value.selectedOffice, // Include the selected office ID
                    _method: 'PATCH'
                };
    
                axios.post('/api/update/office-forward-document-again', data, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
                .then(response => {
                    $("#document-tracker-data-result").html(response.data.documentTracker);
                    $(".modal-content").addClass("bg-white");
                    if ($.fn.dataTable.isDataTable('#document-tracker-data-result')) {
                        $('#document-tracker-data-result').DataTable().clear().destroy();
                        documentTrackerDataTable();
                    }
    
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: response.data.Message,
                        confirmButtonColor: "#3a57e8"
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    SweetAlert.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                        confirmButtonColor: "#3a57e8"
                    });
                });
            }
        });
    
        // Populate the <select> element after the SweetAlert modal is displayed
        const $officeSelect = $("#action-select");
        axios
            .get('/api/create/get-next-office', {
                params: {
                    docType: docType,
                    documentID: documentID
                },
                headers: {
                    'Authorization': 'Bearer ' + $('meta[name="token"]').attr('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.data.Office && response.data.Office.length > 0) {
                    // Clear existing options
                    $officeSelect.html(`
                        <option value="" disabled selected>Select Office...</option>
                    `);
    
                    // Populate the select box with the received data
                    response.data.Office.forEach(office => {
                        $officeSelect.append(
                            `<option value="${office.trackerID}">${office.sectionstrack.section}</option>`
                        );
                    });
                } else {
                    $officeSelect.html(`<option value="">No Office Found</option>`);
                }
            })
            .catch(error => {
                console.error('Error fetching offices:', error);
                $officeSelect.html(
                    `<option value="0">Source Office</option><option value="">Failed to load offices</option>`
                );
            });
    }
    
    
});


$(document).on('click', "#forward-selected-document", function(e){
    const selectedValues = [];
    $('.childCheckbox:checked').each(function() {
        selectedValues.push($(this).val());
    });

    if(selectedValues != ''){
        SweetAlert.fire({
            icon: 'question',
            title: 'Are you sure?',
            text: "This will forward the selected document to the next section.",
            showCancelButton: true,
            confirmButtonColor: '#160e45',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Confirm'
        }).then((result) => {
            if (result.value) {
                SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    SweetAlert.showLoading(); // Show the loading indicator
                 }
            });
                const data = {
                    id: selectedValues,
                    _method: 'PATCH'
                };
                async function APIrequest() {
                    return await axios.post('/api/update/office-forward-selected-document', data, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                        }
                    })
                }
                APIrequest().then(response => {
                    $("#document-tracker-data-result").html(response.data.documentTracker);

                    if ($.fn.dataTable.isDataTable('#document-tracker-data-result')) {
                        $('#document-tracker-data-result').DataTable().clear().destroy();
                        documentTrackerDataTable();
                    }
                    
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: response.data.Message,
                        confirmButtonColor: "#3a57e8"
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                        SweetAlert.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                            confirmButtonColor: "#3a57e8"
                        });
                });
            }
        })
    }
    else {
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please select at least one document',
            confirmButtonColor: "#3a57e8"
        });
    }
});

$(document).on('click', "#delete-qrcode", function(e){
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the code permanently.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    SweetAlert.showLoading(); // Show the loading indicator
                 }
            });
            const data = {id: $(this).data('id')};
            async function APIrequest() {
                return await axios.delete('/api/delete/qrcode', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    },
                })
            }
            APIrequest().then(response => {
                $("#document-tracker-data-result").html(response.data.documentTracker);
                $(".modal-content").addClass("bg-white");
                if ($.fn.dataTable.isDataTable('#document-tracker-data-result')) {
                    $('#document-tracker-data-result').DataTable().clear().destroy();
                    documentTrackerDataTable();
                }
                
                SweetAlert.fire({
                    icon: 'success',
                    title: 'Done',
                    text: response.data.Message,
                    confirmButtonColor: "#3a57e8"
                });
            })
            .catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    })
});

$(document).on('submit', "#update-account-information", function(e){
    e.preventDefault();
    SweetAlert.fire({
        icon: 'info',
        title: 'Are you sure?',
        text: "This will update your account information.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Update!'
    }).then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    SweetAlert.showLoading(); // Show the loading indicator
                 }
            });
            const formData = new FormData(this);
            formData.append('_method', 'PATCH');
            async function APIrequest() {
                return await axios.post('/api/update/office-account-information', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    title: 'Done',
                    text: 'Account updated successfully',
                    confirmButtonColor: "#3a57e8"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
            }).catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Email is already taken',
                    confirmButtonColor: "#3a57e8"
                })
            });
        }
    })
});

$(document).on('click', "#print-qrcode", function(e){
    var qrCodeData = $(this).data('code');
    $("#printQRCodeModal" + qrCodeData).modal('show');
});


$(document).on('click', ".qr-button", function(e) {
    $(this).toggleClass("active");
});

$(document).on('click', "#printQRCodeButton", function (e) {
    e.preventDefault();

    // Get the current modal context
    const currentModal = $(this).closest(".modal");

    // Get selected QR buttons within the current modal
    const selectedButtons = currentModal.find(".qr-button.active");
    if (selectedButtons.length === 0) {
        SweetAlert.fire({
            icon: 'error',
            title: 'No QR Code Selected',
            text: 'Please select at least one QR Code to print.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#160e45'
        });
        return;
    }

    // Generate content for printing based on selected QR codes
    let qrCodeContent = '';
    selectedButtons.each(function () {
        const type = $(this).data("type");
        if (type === "attachment") {
            qrCodeContent += currentModal.find(".attachment").clone().find(".qr-button").remove().end().html();
        } else if (type === "tracking") {
            qrCodeContent += currentModal.find(".tracking").clone().find(".qr-button").remove().end().html();
        }
    });

    // Open a new print window and display selected QR codes
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print QR Code</title><style>body { text-align: center; }</style></head><body>');
    printWindow.document.write(qrCodeContent); // Add sanitized content without buttons
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
    printWindow.close();

    // Clear the content to prevent it from being reused
    qrCodeContent = '';
    currentModal.find(".qr-button").removeClass("active"); // Reset active buttons
});


$(document).on('click', "#print-selected-qrcode", function(e){
    const selectedValues = [];
    const names = []; // array to hold corresponding names
    
    // Loop through each checked checkbox to get the values and names
    $('.childCheckboxHidden:checked').each(function() {
        selectedValues.push($(this).val());
        names.push($(this).data('name')); // assuming data-name attribute holds the name
    });
    
    console.log(names);
    
    if(selectedValues.length > 0) {
        $('#selectedQRCodeContainer').empty();
        
        function generateQRCodeSVG(text, size) {
            var qr = qrcode(0, 'M');
            qr.addData(text);
            qr.make();
            return qr.createSvgTag(size, size);
        }
        
        selectedValues.forEach(function(value, index) {
            const qrCodeSVG = generateQRCodeSVG(value, 5.5);
            const rawText = names[index]; // corresponding raw text
            $('#selectedQRCodeContainer').append(
                `<div style="margin: 30px; display: inline-block;">
                    ${qrCodeSVG}
                    <div style="margin-top: 10px">${rawText}</div>
                </div>`
            );
        });
        
        $("#printSelectedQRCodeModal").modal('show');
    }
    else {
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please select at least one document',
            confirmButtonColor: "#3a57e8"
        });
    }
});


$(document).on('click', "#printSelectedQRCodeButton", function(e){

    var qrCodeContent = $("#selectedQRCodeContainer").html();
    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center">');
    printWindow.document.write(qrCodeContent);
    printWindow.document.write('</body></html>');
    
    printWindow.document.close(); 
    printWindow.print();
    printWindow.close();
});

$(document).on('keyup', '#search-office-document', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#document-tracker-data-result tbody tr').each(function() {
        var rowText = $(this).text().toLowerCase();

        // Check if row contains the search term
        if (rowText.includes(searchTerm)) {
            $(this).show();  // Show rows that match the search term
            noResults = false; // At least one row matches
        } else {
            $(this).hide();  // Hide rows that don’t match
        }
    });

    // Show 'No data found' message if no rows match
    if (noResults) {
        $('#document-tracker-data-result tbody').append('<tr class="no-data"><td colspan="10" class="text-center">No data found</td></tr>');
    } else {
        $('#document-tracker-data-result tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});

$(document).on('keyup', '#search-office-document-mobile', function() {
    var searchTerm = $(this).val().toLowerCase().trim(); // Get the search term and trim leading/trailing spaces
    var noResults = true;

    // Filter through each list item in the container
    $('.list-container .list-item').each(function() {
        var itemText = $(this).text().toLowerCase();

        // Check if the list item contains the search term
        if (itemText.includes(searchTerm)) {
            $(this).show(); // Show items that match the search term
            noResults = false; // At least one item matches
        } else {
            $(this).hide(); // Hide items that don’t match
        }
    });

    // Handle "No data found" message
    if (noResults) {
        if (!$('.list-container .no-data').length) { 
            // Append 'No data found' only if it doesn’t already exist
            $('.list-container').append(
                '<div class="no-data text-center text-danger fw-bold mt-3">No data found</div>'
            );
        }
    } else {
        $('.list-container .no-data').remove(); // Remove the message if there are matching items
    }
});


$(document).on('keyup', '#search-office-archives', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#archives-data-result tbody tr').each(function() {
        var rowText = $(this).text().toLowerCase();

        // Check if row contains the search term
        if (rowText.includes(searchTerm)) {
            $(this).show();  // Show rows that match the search term
            noResults = false; // At least one row matches
        } else {
            $(this).hide();  // Hide rows that don’t match
        }
    });

    // Show 'No data found' message if no rows match
    if (noResults) {
        $('#archives-data-result tbody').append('<tr class="no-data"><td colspan="10" class="text-center">No data found</td></tr>');
    } else {
        $('#archives-data-result tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});

document.addEventListener('livewire:navigated', () => {
    $(document).ready(function () {
        // Initialize Bootstrap tooltips
        $('[data-toggle="tooltip"]').tooltip();
    });
});

$(document).on('click', '#rename-document', function() {
    var code = $(this).data('code');
    var id = $(this).data('id');
    $('#code-id').val(id);
    $('#code-name').val(code);
    $('#renameDocumentModal').modal('show');
})