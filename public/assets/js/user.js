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

function documentDataTable() {
    $('#document-data-result').DataTable(
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
    $('.dataTables_wrapper .dataTables_filter input').css('width', '200px')
}

function receivedLogsDataTable() {
    $('#received-logs-data-result').DataTable(
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
    $('.dataTables_wrapper .dataTables_filter input').css('width', '200px')
}

function forwardedLogsDataTable() {
    $('#forwarded-logs-data-result').DataTable(
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
    $('.dataTables_wrapper .dataTables_filter input').css('width', '200px')
}

/* document.addEventListener('livewire:navigated', () => { 
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#document-data-result')) {
            documentDataTable();
        }
    });
}); */

/* document.addEventListener('livewire:navigated', () => { 
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#received-logs-data-result')) {
            receivedLogsDataTable();
        }
    });
});

document.addEventListener('livewire:navigated', () => { 
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#forwarded-logs-data-result')) {
            forwardedLogsDataTable();
        }
    });
}); */

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
            return await axios.post('/api/update/scan-document', data, {
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
                        <li><small>The QR code might already be part of a batch.</small></li>
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


$(document).on('change', "#masterCheckbox", function(e){
    $('.childCheckbox').prop('checked', $(this).prop('checked'));
});

$(document).on('click', "#forward-document", function(e){
    var identifier = $(this).data("dataid");
    var textValue = $(this).data('text');
    SweetAlert.fire({
        icon: 'question',
        title: 'Are you sure?',
        text: textValue,
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
                documentID: $(this).data("id"),
                id: $(this).data("officeid"),
                dataID: identifier,
                _method: 'PATCH'
            };
            async function APIrequest() {
                return await axios.post('/api/update/user-forward-document', data, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $("#document-data-result").html(response.data.documentTracker);
                $("#all-pending-documents-data-result").html(response.data.allDocuments);
                $("#to-be-batch-data-result").html(response.data.batchDocuments);
                $(".count-data-result[data-id='" + identifier + "']").html(response.data.count);

                if ($.fn.dataTable.isDataTable('#document-data-result')) {
                    $('#document-data-result').DataTable().clear().destroy();
                    documentDataTable();
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
});

$(document).on('click', "#forward-batch-document", function(e){
    var identifier = $(this).data("dataid");
    var textValue = $(this).data('text');
    SweetAlert.fire({
        icon: 'question',
        title: 'Are you sure?',
        text: textValue,
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
                documentID: $(this).data("id"),
                id: $(this).data("officeid"),
                dataID: identifier,
                _method: 'PATCH'
            };
            async function APIrequest() {
                return await axios.post('/api/update/user-forward-batch-document', data, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                
                SweetAlert.fire({
                    icon: 'success',
                    title: 'Done',
                    text: response.data.Message,
                    confirmButtonColor: "#3a57e8"
                }).then(() => {
                    // Add blur to the whole page
                    $('body').addClass('page-blur'); // Add the blur class to the body
                
                    // Reload the page after applying the blur effect
                    setTimeout(() => {
                        location.reload(); // Reload the page
                    }, 200); // Optional delay to ensure smooth transition
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
});

$(document).on('click', "#forward-selected-document", function(e){
    var identifier = $("#dataID").val();
    const selectedValues = [];
    $('.childCheckbox:checked').each(function() {
        selectedValues.push($(this).val());
    });
    console.log(selectedValues);
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
                    showConfirmButton: false
                });
                const data = {
                    documentID: selectedValues,
                    id: $("#officeID").val(),
                    dataID: identifier,
                    _method: 'PATCH'
                };
                async function APIrequest() {
                    return await axios.post('/api/update/user-forward-selected-document', data, {
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                        }
                    })
                }
                APIrequest().then(response => {
                    $("#document-data-result").html(response.data.documentTracker);
                    $(".count-data-result[data-id='" + identifier + "']").html(response.data.count);

                    if ($.fn.dataTable.isDataTable('#document-data-result')) {
                        $('#document-data-result').DataTable().clear().destroy();
                        documentDataTable();
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

$(document).on('click', "#reject-document", function(e) {
    var documentID = $(this).data('id');
    var identifier = $(this).data('dataid');
    var officeID = $(this).data('officeid');
    var docType = $(this).data('doctype');
    var sourceOffice = $(this).data('office'); // Fetch the source office value

    $("#id").val(documentID);
    $("#data-id").val(identifier);
    $("#office-id").val(officeID);

    // Clear the select box and show a loading message
    var $officeSelect = $("#return-to-office");
    $officeSelect.html('<option value="">Loading...</option>');

    // Send docType to the server via Axios
    axios.get('/api/create/get-office', {
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
            // Reset options and include the source office as the first option
            $officeSelect.html(`
                <option value="">Select Office...</option>
                <option value="0">Source Office: ${sourceOffice ? sourceOffice : 'Source Office'}</option>
            `);

            // Populate the select box with the received data
            response.data.Office.forEach(office => {
                $officeSelect.append(
                    `<option value="${office.trackerID}">${office.sectionstrack.section}</option>`
                );
            });
        } else {
            $officeSelect.html(`<option value="0">Source Office: ${sourceOffice ? sourceOffice : 'Source Office'}</option>`);
        }
    })
    .catch(error => {
        console.error('Error fetching offices:', error);
        $officeSelect.html('<option value="0">${sourceOffice ? sourceOffice : "Source Office"}</option><option value="">Failed to load offices</option>');
    });

    // Show the modal
    $("#returnDocumentModal").modal('show');
});



$(document).on('click', "#reject-selected-document", function(e){
    const selectedValues = [];
    $('.childCheckbox:checked').each(function() {
        selectedValues.push($(this).val());
        $('<input>').attr({
            type: 'hidden',
            name: 'documentID[]',
            value: $(this).val()
        }).appendTo('#hiddenInputsContainer');
    });
    console.log(selectedValues);
    if(selectedValues != ''){
        var identifier = $("#dataID").val();
        var officeID = $("#officeID").val();
        $("#selected-data-id").val(identifier);
        $("#selected-office-id").val(officeID);
        $("#returnSelectedDocumentModal").modal('show');
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

$(document).on('submit', "#return-selected-document", function(e){
    var identifier = $("#selected-data-id").val();
    console.log(identifier);
    e.preventDefault();
    SweetAlert.fire({
        icon: 'question',
        title: 'Are you sure?',
        text: "This will return the document to the previous section.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Return'
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
                return await axios.post('/api/update/user-return-selected-document', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
           APIrequest().then(response => {
                $("#returnSelectedDocumentModal").modal('hide');
                $("#document-data-result").html(response.data.documentTracker);
                $(".count-data-result[data-id='" + identifier + "']").html(response.data.count);

                if ($.fn.dataTable.isDataTable('#document-data-result')) {
                    $('#document-data-result').DataTable().clear().destroy();
                    documentDataTable();
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

$(document).on('submit', "#return-document", function(e){
    var identifier = $("#data-id").val();
    console.log(identifier)
    e.preventDefault();
    SweetAlert.fire({
        icon: 'question',
        title: 'Are you sure?',
        text: "This will return the document to the previous section.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Return'
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
                return await axios.post('/api/update/user-return-document', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
           APIrequest().then(response => {
                $("#returnDocumentModal").modal('hide');
                $("#document-data-result").html(response.data.documentTracker);
                $("#all-pending-documents-data-result").html(response.data.allDocuments);
                $(".count-data-result[data-id='" + identifier + "']").html(response.data.count);

                if ($.fn.dataTable.isDataTable('#document-data-result')) {
                    $('#document-data-result').DataTable().clear().destroy();
                    documentDataTable();
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
                return await axios.post('/api/update/user-account-information', formData, {
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

$(document).on('change', "#select-date", function(e){
    e.preventDefault();
    console.log($('#select-date').val())
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
        date: $('#select-date').val(),
    };
    async function APIrequest() {
        return await axios.post('/api/create/user-select-date', data, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#received-logs-data-result").html(response.data.Logs);
        
        if ($.fn.dataTable.isDataTable('#received-logs-data-result')) {
            $('#received-logs-data-result').DataTable().clear().destroy();
            receivedLogsDataTable();
        }
        SweetAlert.close();
    }).catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#select-date-forwarded", function(e){
    e.preventDefault();
    console.log($('#select-date-forwarded').val())
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
        date: $('#select-date-forwarded').val(),
    };
    async function APIrequest() {
        return await axios.post('/api/create/user-select-date-forwarded', data, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#forwarded-logs-data-result").html(response.data.Logs);
        
        if ($.fn.dataTable.isDataTable('#forwarded-logs-data-result')) {
            $('#forwarded-logs-data-result').DataTable().clear().destroy();
            forwardedLogsDataTable();
        }
        SweetAlert.close();
    }).catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('keyup', '#search-office-document', function() {
    var searchTerm = $(this).val().toLowerCase().trim(); // Remove leading/trailing spaces
    var noResults = true;

    // Combine the tbody rows of both tables
    $('#document-data-result tbody tr, #all-pending-documents-data-result tbody tr').each(function() {
        var rowText = $(this).text().toLowerCase();

        // Check if row contains the search term
        if (rowText.includes(searchTerm)) {
            $(this).show(); // Show rows that match the search term
            noResults = false; // At least one row matches
        } else {
            $(this).hide(); // Hide rows that don’t match
        }
    });

    // Show 'No data found' message if no rows match in both tables
    if (noResults) {
        // Append 'No data found' to both tables
        $('#document-data-result tbody, #all-pending-documents-data-result tbody').each(function() {
            if ($(this).find('.no-data').length === 0) { // Avoid duplicating the message
                $(this).append('<tr class="no-data"><td colspan="10" class="text-center">No data found</td></tr>');
            }
        });
    } else {
        // Remove 'No data found' messages if there are matches
        $('#document-data-result tbody .no-data, #all-pending-documents-data-result tbody .no-data').remove();
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

$(document).on('click', "#startScanBtnSearch", function(e){
    
    $("#searchScannerModal").modal('show');
    const scanner = new Instascan.Scanner({ video: document.getElementById('searchScanner') });
    scanner.addListener('scan', function(content) {
        $('#search-office-document').val(content);
        $('#search-office-document').trigger('keyup');
        $('#search-office-document-mobile').val(content);
        $('#search-office-document-mobile').trigger('keyup');
        $("#searchScannerModal").modal('hide');
        scanner.stop();
        Instascan.Camera.stop();
    });
    Instascan.Camera.getCameras().then(function(cameras) {
        if (cameras.length > 0) {
            // Check for rear camera (back camera)
            const rearCamera = cameras.find(camera => camera.name.toLowerCase().includes('back') || camera.name.toLowerCase().includes('rear'));
            if (rearCamera) {
                // No flip for rear camera
                document.getElementById('searchScanner').style.transform = ""; 
                scanner.start(rearCamera);
            } else {
                // Fallback to the first available camera (if no rear camera)
                document.getElementById('searchScanner').style.transform = ""; 
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
    if ($('searchScannerModal').is(':visible') && !$(e.target).closest('.modal-dialog').length) {
        $("#searchScannerModal").modal('hide');
        stopScanner();
    }
    });
    $('#searchScannerModal').on('hidden.bs.modal', function() {
        stopScanner();
    });
});

$(document).ready(function() {
    // When the group checkbox is clicked
    $(document).on('click', '.groupCheckbox', function() {
        var group = $(this).data('group'); // Get the group type
        var isChecked = $(this).prop('checked'); // Get the state of the group checkbox

        // Check/uncheck all child checkboxes with the same group
        $(`.childCheckbox[data-group="${group}"]`).prop('checked', isChecked);
    });

    // When a child checkbox is clicked
    $(document).on('click', '.childCheckbox', function() {
        var group = $(this).data('group'); // Get the group type
        var allChecked = $(`.childCheckbox[data-group="${group}"]`).length === $(`.childCheckbox[data-group="${group}"]:checked`).length;

        // Check/uncheck the group checkbox based on the child checkboxes' state
        $(`.groupCheckbox[data-group="${group}"]`).prop('checked', allChecked);
    });
});


$(document).on('click', '#batchDocuments', function (e) {
    e.preventDefault(); // Prevent default behavior of the link

    // Collect all checked checkbox values and their data-group attributes
    var selectedDocuments = [];
    var selectedGroups = [];

    $('input.childCheckbox:checked').each(function () {
        selectedDocuments.push($(this).val());
        selectedGroups.push($(this).data('group')); // Collect data-group attributes
    });

    if (selectedDocuments.length === 0) {
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please select at least one document to be batched!',
            confirmButtonColor: "#3a57e8"
        });
        return; // Stop further execution if no checkbox is selected
    }

    // Validate if all selected documents have the same data-group
    var uniqueGroups = [...new Set(selectedGroups)]; // Get unique document types
    if (uniqueGroups.length > 1) {
        SweetAlert.fire({
            icon: 'error',
            title: 'Invalid Selection',
            text: 'You can only batch documents with the same document type!',
            confirmButtonColor: "#3a57e8"
        });
        return; // Stop further execution if document types differ
    }

    // Show SweetAlert for confirmation with input
    SweetAlert.fire({
        title: 'Batch Documents',
        text: 'Please provide additional information before batching:',
        icon: 'question',
        html: `
            <div class="mt-2 mb-4">
                <div class="mb-3">
                    <small class="text-secondary" style="font-size: 14px">Please provide additional information before batching. Batching documents will generate a single MAIN QR code, which will be attached to the documents. This MAIN QR code will represent all the individual QR codes associated with each document. After batching and the creation of the new MAIN QR code, it will be used for scanning at the subsequent stations.</small>
                </div>
                <textarea id="info" class="form-control" rows="3" placeholder="Enter additional information"></textarea>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Batch',
        confirmButtonColor: "#3a57e8",
        cancelButtonColor: '#d33',
        preConfirm: () => {
            const info = $('#info').val().trim();
            if (!info) {
                Swal.showValidationMessage('<small>Additional information is required</small>');
            }
            return { info };
        }
    }).then((result) => {
        if (result.isConfirmed && result.value.info) {
            const additionalInfo = result.value.info;

            // Create payload with the selected documents and additional info
            const data = {
                documents: selectedDocuments,
                additionalInfo: additionalInfo,
                action: 'batch'
            };

            // SweetAlert to show loading
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    SweetAlert.showLoading(); // Show loading indicator
                }
            });

            // Axios POST request
            axios.post('/api/create/batch-documents', data, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
            .then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    title: 'Batch Processed!',
                    text: response.data.Message,
                    confirmButtonColor: "#3a57e8"
                }).then(() => {
                    $('body').addClass('page-blur'); // Add the blur class to the body
                        
                    // Reload the page after applying the blur effect
                    setTimeout(() => {
                        location.reload(); // Reload the page
                    }, 200); // Reload the page
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
});


$(document).on('click', '#add-to-existing-batch', function() {
    var id = $(this).data('id');
    var group = $(this).data('group');
    $('#documentID').val(id);
    $('#documentType').val(group);
    $('#addToExistingBatchModal').modal('show');
});

$(document).on('submit', "#insert-to-existing-batch", function(e) {
    e.preventDefault();

    // Retrieve values for validation
    const documentType = $('#documentType').val().trim(); // Value from the input
    const selectedOption = $('select[name="batch"] option:selected'); // Selected option
    const selectedGroup = selectedOption.data('group'); // data-group attribute of the selected option

    // Validation: Check if documentType matches the selected option's data-group
    if (documentType != selectedGroup) {
        SweetAlert.fire({
            icon: 'error',
            title: 'Invalid Selection',
            text: 'You can only batch documents with the same document type!',
            confirmButtonColor: "#3a57e8"
        });
        return; // Stop further execution
    }

    // Show loading SweetAlert
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            SweetAlert.showLoading();
        }
    });

    // Prepare FormData
    const formData = new FormData(this);
    formData.append('_method', 'PATCH');

    // Axios POST request
    async function APIrequest() {
        return await axios.post('/api/update/insert-to-existing-batch', formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        });
    }

    // Send the request
    APIrequest().then(response => {
        $('#addToExistingBatchModal').modal('hide');
        SweetAlert.fire({
            icon: 'success',
            title: 'Done',
            text: response.data.Message,
            confirmButtonColor: "#3a57e8"
        }).then(() => {
            $('body').addClass('page-blur'); // Add the blur class to the body
                
            // Reload the page after applying the blur effect
            setTimeout(() => {
                location.reload(); // Reload the page
            }, 200); // Reload the page
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


$(document).on('click', '#saveBatchDocuments', function (e) {
    e.preventDefault(); // Prevent default behavior of the link

    // Collect all checked checkbox values
    var selectedDocuments = [];
    $('input.childCheckbox:checked').each(function () {
        selectedDocuments.push($(this).val());
    });

    if (selectedDocuments.length === 0) {
        SweetAlert.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Please select at least one document to be batched!',
            confirmButtonColor: "#3a57e8"
        });
        return; // Stop further execution if no checkbox is selected
    }

    
        const additionalInfo = $('#additional-information').val(); // Get additional information input
        const id = $(this).data('id');

            // Create a payload with the selected documents and additional info
            const data = {
                documents: selectedDocuments,
                additionalInfo: additionalInfo,
                action: 'batch',
                id: id,
                _method: 'PATCH'
            };

            // SweetAlert to show loading
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

            // Axios POST request
            async function batchDocumentsAPI() {
                return await axios.post('/api/update/batch-documents', data, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                });
            }

            batchDocumentsAPI()
                .then(response => {
                    // Handle success response
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Batch Processed!',
                        text: response.data.Message,
                        confirmButtonColor: "#3a57e8"
                    }).then(() => {
                        $('body').addClass('page-blur'); // Add the blur class to the body
                            
                        // Reload the page after applying the blur effect
                        setTimeout(() => {
                            location.reload(); // Reload the page
                        }, 200); // Reload the page
                    });
                    
                })
                .catch(error => {
                    // Handle error response
                    console.error('Error:', error);
                    SweetAlert.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'QR Code name already exists!',
                        confirmButtonColor: "#3a57e8"
                    });
                });
        
    
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