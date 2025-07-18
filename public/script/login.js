$('#loginForm').on('submit', function (e) {
    e.preventDefault();


    const email = $('[name="email"]').val();
    const password = $('[name="password"]').val();

    $.ajax({
        url: OTP_LOGIN_URL,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        contentType: 'application/json',
        data: JSON.stringify({ email: email, password: password }),
        success: function (data) {
            if (data.success) {
                // OTP sent, show modal
                $('#otpModal').modal('show');
                $('#otp_user_id').val(data.user_id);
                $('#otpError').text("").hide();
            } else {
                $('#otpError').text(data.message).show();
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('Terjadi kesalahan saat verifikasi OTP.');
        }
    });
});
