$(document).ready(() => {
    console.log("running");

    Handler();
});

function Handler() {
    $("#btnRegis").click(async function () {
        try {
            // const modalOtp = $("#mdlOtpInput");
            // modalOtp.modal('show');
        } catch (err) {
            alert("error Regis");
        }
    });
}
