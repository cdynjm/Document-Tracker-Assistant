$.ajaxSetup({
    headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    headers: {  "Authorization": "Bearer " + $('meta[name="token"]').attr('content') }
});

$(document).on("click", '#toggle-password', function() {
    let passwordField = $('.password');
    let passwordFieldType = passwordField.attr('type');
    let eyeIcon = $('.eye-icon');
    
    if (passwordFieldType === 'password') {
        passwordField.attr('type', 'text');
        eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
        $('.text').text('Hide ');
    } else {
        passwordField.attr('type', 'password');
        eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
        $('.text').text('Show ');
    }
});

var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn bg-dark text-white',
        cancelButton: 'btn btn-secondary ms-3'
    },
    buttonsStyling: false
});

//DATATABLES:

function officeDataTable() {
    $('#office-data-result').DataTable(
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

function officeAccountDataTable() {
    $('#office-account-data-result').DataTable(
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
function userAccountDataTable() {
    $('#user-account-data-result').DataTable(
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

function officeDataTable() {
    $('#office-data-result').DataTable(
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

function userLogsDataTable() {
    $('#user-logs-history-data-result').DataTable(
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

function documentTypeDataTable() {
    $('#document-type-data-result').DataTable(
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

function adminDocumentTrackerDataTable() {
    $('#admin-document-tracker-data-result').DataTable(
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

document.addEventListener('livewire:navigated', () => { 
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#office-data-result')) {
            officeDataTable();
        }
    });
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#office-account-data-result')) {
            officeAccountDataTable();
        }
    });
   /* $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#user-account-data-result')) {
            userAccountDataTable();
        }
    }); */
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#user-logs-history-data-result')) {
            userLogsDataTable();
        }
    });
    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#document-type-data-result')) {
            documentTypeDataTable();
        }
    });

   /* $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#admin-document-tracker-data-result')) {
            adminDocumentTrackerDataTable();
        }
    }); */
});

$(document).on('click', "#add-office", function(e){
    $("#createOfficeModal").modal('show');
});

$(document).on('submit', "#create-office", function(e){
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
        return await axios.post('/api/create/office', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#createOfficeModal").modal('hide');
        $('input').val('');
        $("#office-data-result").html(response.data.Office);
        
        if ($.fn.dataTable.isDataTable('#office-data-result')) {
            $('#office-data-result').DataTable().clear().destroy();
            officeDataTable();
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
});


$(document).on('click', "#edit-office", function(e){

    var id = $(this).parents('tr').find('td[id]').attr("id");
    var office = $(this).parents('tr').find('td[office]').attr("office");
    $("#id").val(id);
    $("#office").val(office);

    $("#editOfficeModal").modal('show');
});

$(document).on('submit', "#update-office", function(e){
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
        return await axios.post('/api/update/office', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Authorization': 'Bearer ' + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#editOfficeModal").modal('hide');
        $('input').val('');
        $("#office-data-result").html(response.data.Office);

        if ($.fn.dataTable.isDataTable('#office-data-result')) {
            $('#office-data-result').DataTable().clear().destroy();
            officeDataTable();
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


$(document).on('click', "#delete-office", function(e){
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the office permanently.",
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
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/office', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $("#office-data-result").html(response.data.Office);
                if ($.fn.dataTable.isDataTable('#office-data-result')) {
                    $('#office-data-result').DataTable().clear().destroy();
                    officeDataTable();
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



$(document).on('click', "#add-section", function(e){
    $("#createOfficeSectionModal").modal('show');
});

$(document).on('submit', "#create-section", function(e){
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
        return await axios.post('/api/create/section', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#createOfficeSectionModal").modal('hide');
        $('input').val('');
        $('select').val('');
        $("#office-section-data-result").html(response.data.Section);

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


$(document).on('click', "#edit-section", function(e){

    var id = $(this).parents('tr').find('td[id]').attr("id");
    var office = $(this).parents('tr').find('td[officeID]').attr("officeID");
    var section = $(this).parents('tr').find('td[section]').attr("section");
    $("#id").val(id);
    $("#office").val(office);
    $("#section").val(section);

    $("#editOfficeSectionModal").modal('show');
});

$(document).on('submit', "#update-section", function(e){
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
        return await axios.post('/api/update/section', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }  
    APIrequest().then(response => {
        $("#editOfficeSectionModal").modal('hide');
        $('input').val('');
        $('select').val('');
        $("#office-section-data-result").html(response.data.Section);

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


$(document).on('click', "#delete-section", function(e){
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the section permanently.",
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
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/section', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $("#office-section-data-result").html(response.data.Section);
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

$(document).on('click', "#add-document-type", function(e){
    $("#createDocumentTypeModal").modal('show');
});

$(document).on('submit', "#create-document-type", function(e){
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
        return await axios.post('/api/create/document-type', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
   APIrequest().then(response => {
        $("#createDocumentTypeModal").modal('hide');
        $('input').val('');
        $('select').val('');
        $("#document-type-data-result").html(response.data.DocumentType);

        if ($.fn.dataTable.isDataTable('#document-type-data-result')) {
            $('#document-type-data-result').DataTable().clear().destroy();
            documentTypeDataTable();
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
            title: 'Error',
            text: 'Something went wrong',
            confirmButtonColor: "#3a57e8"
        })
    });
});

$(document).on('submit', "#update-document-type", function(e){
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
        return await axios.post('/api/update/document-type', formData, {
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
                text: response.data.Message,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong',
                confirmButtonColor: "#3a57e8"
            })
        });
});

$(document).on('click', "#delete-document-type", function(e){
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the document type permanently including its tracker.",
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
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/document-type', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    },
                })
            }
           APIrequest().then(response => {
                $("#document-type-data-result").html(response.data.DocumentType);

                if ($.fn.dataTable.isDataTable('#document-type-data-result')) {
                    $('#document-type-data-result').DataTable().clear().destroy();
                    documentTypeDataTable();
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

$(document).on('click', "#add-office-account", function(e){
    $("#createOfficeAccountModal").modal('show');
});

$(document).on('click', "#add-tracker", function(e){
    var selectHtml = $('#tracker-container .tracker-wrapper:first').clone();
    selectHtml.find('select').val(''); // Clear the selected value
    selectHtml.find('option:selected').removeAttr('selected'); // Remove the selected attribute
    selectHtml.find('.tracker-number').attr('title', 'Hold and drag to reorder');
    $('#tracker-container').append(selectHtml);
    updateTrackerNumbers();
    $('[title]').tooltip();
});

$(document).on('click', ".delete-tracker", function (e) {
    if ($('#tracker-container .tracker-wrapper').length > 1) {
        const $tracker = $(this).closest('.tracker-wrapper');
        
        // Destroy the tooltip instance before removing the tracker
        $tracker.find('[title]').tooltip('dispose');
        
        // Remove the specific tracker
        $tracker.remove();
        
        // Recalculate step numbers
        updateTrackerNumbers();
    }
});

function updateTrackerNumbers() {
    $('#tracker-container .tracker-wrapper').each(function(index) {
        $(this).find('.tracker-number').text(index + 1 + '. ');
    });
}

$(document).on('submit', "#create-office-account", function(e){
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
        return await axios.post('/api/create/office-account', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
   APIrequest().then(response => {
        $("#createOfficeAccountModal").modal('hide');
        $('input').val('');
        $('select').val('');
        $("#office-account-data-result").html(response.data.OfficeAccount);

        if ($.fn.dataTable.isDataTable('#office-account-data-result')) {
            $('#office-account-data-result').DataTable().clear().destroy();
            officeAccountDataTable();
        }

        SweetAlert.fire({
            icon: 'success',
            title: 'Done',
            text: 'Office Account created successfully',
            confirmButtonColor: "#3a57e8"
        });
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            title: 'Error',
            text: 'Email is already taken',
            confirmButtonColor: "#3a57e8"
        })
    });
});

$(document).on('click', "#delete-office-account", function(e){
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the office account permanently.",
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
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/office-account', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    },
                })
            }
           APIrequest().then(response => {
                $("#office-account-data-result").html(response.data.OfficeAccount);

                if ($.fn.dataTable.isDataTable('#office-account-data-result')) {
                    $('#office-account-data-result').DataTable().clear().destroy();
                    officeAccountDataTable();
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

$(document).on('submit', "#update-office-account", function(e){
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
        return await axios.post('/api/update/office-account', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
            $("#update-office-account").html(response.data.UpdatedOfficeAccount);
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'Office Account updated successfully',
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                title: 'Error',
                text: 'Email is already taken',
                confirmButtonColor: "#3a57e8"
            })
        });
});

$(document).on('click', "#add-user-account", function(e){
    $("#createUserAccountModal").modal('show');
});

$(document).on('submit', "#create-user-account", function(e){
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
        return await axios.post('/api/create/user-account', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#createUserAccountModal").modal('hide');
        $('input').val('');
        $('select').val('');
        $("#user-account-data-result").html(response.data.UserAccount);

        if ($.fn.dataTable.isDataTable('#user-account-data-result')) {
            $('#user-account-data-result').DataTable().clear().destroy();
            userAccountDataTable();
        }

        SweetAlert.fire({
            icon: 'success',
            title: 'Done',
            text: 'User Account created successfully',
            confirmButtonColor: "#3a57e8"
        });
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            title: 'Error',
            text: 'Email is already taken',
            confirmButtonColor: "#3a57e8"
        })
    });
});

$(document).on('click', "#edit-user-account", function(e) {

    var id = $(this).parents('tr').find('td[id]').attr("id");
    var name = $(this).parents('tr').find('td[name]').attr("name");
    var email = $(this).parents('tr').find('td[email]').attr("email");
    var section = $(this).parents('tr').find('td[section]').attr("section");
    var special = $(this).parents('tr').find('td[special]').attr("special");

    // Set the form fields
    $("#id").val(id);
    $("#name").val(name);
    $("#email").val(email);
    $("#section").val(section);

    // Check or uncheck the toggle based on the 'special' value
    if (special == "1") {
        $("#specialAccount").prop("checked", true); // Check the toggle
    } else {
        $("#specialAccount").prop("checked", false); // Uncheck the toggle
    }

    // Show the modal
    $("#editUserAccountModal").modal('show');
});


$(document).on('submit', "#update-user-account", function(e){
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
        return await axios.post('/api/update/user-account', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#editUserAccountModal").modal('hide');
        $('input').val('');
        $('select').val('');
        $("#user-account-data-result").html(response.data.UserAccount);

        if ($.fn.dataTable.isDataTable('#user-account-data-result')) {
            $('#user-account-data-result').DataTable().clear().destroy();
            userAccountDataTable();
        }

        SweetAlert.fire({
            icon: 'success',
            title: 'Done',
            text: 'User Account updated successfully',
            confirmButtonColor: "#3a57e8"
        });
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            title: 'Error',
            text: 'Email is already taken',
            confirmButtonColor: "#3a57e8"
        })
    });
});

$(document).on('click', "#delete-user-account", function(e){
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the user account permanently.",
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
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/user-account', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    },
                })
            }
           APIrequest().then(response => {
                $("#user-account-data-result").html(response.data.UserAccount);

                if ($.fn.dataTable.isDataTable('#user-account-data-result')) {
                    $('#user-account-data-result').DataTable().clear().destroy();
                    userAccountDataTable();
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
                return await axios.post('/api/update/admin-account-information', formData, {
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
        id: $('#employeeID').val()
    };
    async function APIrequest() {
        return await axios.post('/api/create/admin-select-date', data, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $("#user-logs-history-data-result").html(response.data.Logs);
        
        if ($.fn.dataTable.isDataTable('#user-logs-history-data-result')) {
            $('#user-logs-history-data-result').DataTable().clear().destroy();
            userLogsDataTable();
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

$(document).on('keyup', '#search-users', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#user-account-data-result tbody tr').each(function() {
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
        $('#user-account-data-result tbody').append('<tr class="no-data"><td colspan="7" class="text-center">No data found</td></tr>');
    } else {
        $('#user-account-data-result tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});

$(document).on('keyup', '#search-sections', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#office-section-data-result tbody tr').each(function() {
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
        $('#office-section-data-result tbody').append('<tr class="no-data"><td colspan="7" class="text-center">No data found</td></tr>');
    } else {
        $('#office-section-data-result tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});

document.addEventListener('livewire:navigated', () => {
$(document).ready(function () {
    // Initialize Bootstrap tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
});

$(document).on('keyup', '#search-office-document', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#admin-document-tracker-data-result tbody tr').each(function() {
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
        $('#admin-document-tracker-data-result tbody').append('<tr class="no-data"><td colspan="10" class="text-center">No data found</td></tr>');
    } else {
        $('#admin-document-tracker-data-result tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});

$(document).on('click', '#hide-card', function() {
    var cardBody = $('#card-body');
    var button = $(this);

    // Toggle visibility of the card body
    cardBody.toggle();

    // Update button text and icon based on visibility
    if (cardBody.is(':visible')) {
        button.html('<iconify-icon icon="teenyicons:down-solid" width="15" height="15" class="me-1"></iconify-icon> Hide');
    } else {
        button.html('<iconify-icon icon="teenyicons:up-solid" width="15" height="15" class="me-1"></iconify-icon> Show');
    }
});

$(document).on('click', "#search-month-year", function(e){
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
    const formData = new FormData();
    formData.append('month', $('#month-select').val());
    formData.append('year', $('#year-select').val());
    async function APIrequest() {
        return await axios.post('/api/search/data-analytics', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        SweetAlert.close();
        $("#data-analytics-result").html(response.data.DataAnalytics);

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

