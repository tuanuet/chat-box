/**
 * Created by vuong on 03/08/2017.
 */
$('.btn-delete').on('click', function (e) {
    var id = $(this).data("id");
    $('#deleteForm').attr("action", "/files/delete?id=" + id);
})