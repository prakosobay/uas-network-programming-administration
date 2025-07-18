$('#loginForm').on('submit', function (e) {
    e.preventDefault();
    alert('clicked');

    const email = $('[name="email"]').val();
    const password = $('[name="password"]').val();

    $.ajax({
        url: OTP_LOGIN_URL,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        contentType: 'application/json',
        data: JSON.stringify({ email: email, password: password }),
        success: function (data) {
            if (data.success) {
                // OTP sent, show modal
                $('#otpModal').modal('show');
                $('#otp_user_id').val(data.user_id);
            } else {
                alert(data.message);
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('Terjadi kesalahan saat login.');
        }
    });
});
