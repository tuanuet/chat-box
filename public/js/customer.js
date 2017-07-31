/**
 * Created by vuong on 25/07/2017.
 */
function resetFormModal() {
    $('#form-name').val('');
    $('#form-email').val('');
    $('#form-phone').val('');
    $('#message').text('');
    $('#warning-message').text('');
};

$('#btn-add-customer').on('click', function (e) {
    e.preventDefault();
    resetFormModal();
});

$('#form-name, #form-email').on('keyup', function () {
    $('#message').html('');
});

/**
 * validate data before submit
 */
$('.btn-edit').on('click', function (e) {
    var id = $(this).data("id");
    $('.custom-modal-title').text('Edit');
    $('#myForm').attr("action", "customers/edit?id=" + id);

    var name = document.getElementById(id).getElementsByTagName("td")[1].innerHTML;
    var email = document.getElementById(id).getElementsByTagName("td")[3].innerHTML;
    var phone = document.getElementById(id).getElementsByTagName("td")[2].innerHTML;
    console.log(id);
    console.log(name);
    console.log(email);
    console.log(phone);

    $('#form-name').val(name);
    $('#form-email').val(email);
    $('#form-phone').val(phone);
});

$('#form_admin').submit(function (e) {
    //console.log("Validating form...");
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

function getRooms(id) {
    console.log(ok);
    return "ok";
}