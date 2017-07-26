/**
 * Created by vuong on 25/07/2017.
 */

$('#form-name, #form-email').on('keyup', function () {
    $('#message').html('');
});

/**
 * validate data before submit
 */
$('#btn-edit').on('click', function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $('.custom-modal-title').text('Edit');
    $('#myForm').attr("action", "customers/edit?id=" + id);

    $('#form-name').val(name);
    $('#form-email').val(email);
    $('#form-phone').val(phone);
});

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
});