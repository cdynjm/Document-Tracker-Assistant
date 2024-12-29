$(document).on('submit', "#sign-out", function(e){
    e.preventDefault();
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Signing Out...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            SweetAlert.showLoading(); // Show the loading indicator
         }
    });
    const formData = new FormData(this);
    async function APIrequest() {
        return await axios.post('/logout', formData, {
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
    });
});