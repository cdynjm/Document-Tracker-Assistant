$(document).on("click", '#toggle-password', function() {
    let passwordField = $('#password');
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

$(document).on('submit', "#sign-in", function(e){
    e.preventDefault();
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Signing In...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            SweetAlert.showLoading(); // Show the loading indicator
         }
    });
    const formData = new FormData(this);
    async function APIrequest() {
        return await axios.post('/login', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        location.reload(); 
    })
    .catch(error => {
        console.error('Error:', error);
        let errorMessage = 'An unknown error occurred';
        if (error.response && error.response.data && error.response.data.Message) {
            errorMessage = error.response.data.Message;
        } else if (error.response && error.response.statusText) {
            errorMessage = error.response.statusText;
        }
        SweetAlert.fire({
            icon: 'error',
            title: 'Log In Failed',
            text: errorMessage,
            confirmButtonColor: "#3a57e8"
        });
    });
});