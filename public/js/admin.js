/**
 * Created by vuong on 25/07/2017.
 */
$('#password_modal, #confirm_password_modal').on('keyup', function ()
{
    if ($('#password_modal').val() == $('#confirm_password_modal').val()) {
        $('#warning-message').html('Matching').css('color', 'green');
    } else {
        $('#warning-message').html('Not Matching').css('color', 'red');
    }

    if (!$('#confirm_password_modal').val()) {
        $('#warning-message').html('');
    }

    $('#message').html('');
});

$('#form-name, #form-email').on('keyup', function () {
    $('#message').html('');
})

/**
 * validate data before submit
 */

$('#form_admin').submit(function (e) {
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

    if ($('#password_modal').val() === '') {
        $('#message').html('Invalid password').css('color', 'red');
        e.preventDefault();
        return;
    } else {
        $('#message').html('');
    }

    if ($('#password_modal').val() !== $('#confirm_password_modal').val()) {
        $('#message').html('Confirm password does not match').css('color', 'red');
        e.preventDefault();
        return;
    } else {
        $('#message').html('');
    }

    if (!$('#confirm_password_modal').val()) {
        $('#warning-message').html('');
    } else {
        $('#message').html('');
    }
});