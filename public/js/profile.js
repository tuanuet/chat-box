/**
 * Created by vuong on 25/07/2017.
 */
$('#btn-edit').on('click', function (e) {
    e.preventDefault();
    var isDisable = $('#form-name').prop("disabled");
    //console.log(isDisable);
    if (isDisable) {
        $('#form-name').prop("disabled", false);
        $('#form-phone').prop("disabled", false);
        $('#form-email').prop("disabled", false);
        $('#form-password').prop("disabled", false);
        $('.myPencil').text('Save');
    }
});

$('#form-name, #form-email, #form-password').on('keyup', function () {
    $('#message').html('');
})

$('#myForm').submit(function (e) {
    console.log("Validating form...");
    if ($('#form-name').val() === '') {
        $('#message').html('Invalid name').css('color', 'red');
        e.preventDefault();
        return;
    } else {
        $('#message').html('');
    }

    if ($('#form-email').val() === '') {
        $('#message').html('Invalid email').css('color', 'red');
        e.preventDefault();
        return;
    } else {
        $('#message').html('');
    }

    if ($('#form-password').val() === '') {
        $('#message').html('Invalid password').css('color', 'red');
        e.preventDefault();
        return;
    } else {
        $('#message').html('');
    }
});