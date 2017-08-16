// $(document).ready(function () {
//     var table = $('#datatable').dataTable({
//         "searching": false,
//         "ordering": false,
//         "lengthMenu": [ 5, 10, 20 ],
//         "language": {
//             "info": "_PAGE_ / _PAGES_",
//         },
//         "columns": [
//             { "width": "10%" },
//             { "width": "10%" },
//             null,
//             { "width": "10%" },
//         ]
//
//     });
//     $('.btn-add-topic').on('click',function (e) {
//         console.log(table);
//         console.log(1);
//
//     });
//     $('.btn-edit').on('click', function (e) {
//
//     });
//
//     $('.btn-delete').on('click', function (e) {
//         $(this).parent().parent().remove();
//     });
function standardized(topic) {
    var res = topic.toLowerCase();
    res = res.substr(0, 1).toUpperCase() + res.substr(1);
    return res;
}

// });
$(document).ready(function () {


    $('#add-row-topic').on('click', function (event) {
        console.log("dsad");
        var block = '<li>'+
            '<input type="text" placeholder="Type topic here" name="topic" value=""> '+
            '<button class="btn btn-primary delete-row-topic"><i class="fa fa-remove"></i></button>'+
            '</li>';
        $('#list-topics').append(block);
    });

    $(document).on('click', '.delete-row-topic', function() {
        $(this).parent().remove();

    });
    $('#btn-send').on('click',function(e){
       // console.log("Okbcs");
        var res = {};
        res.registers = []
        res.topics = []
        $("input:checkbox[name=checkbox]:checked").each(function(){
            var id = $(this).attr("id");
            // console.log(id);

            res.registers.push($("label[for='"+id+"']").text().trim());
        });

        $("input:text[name=topic]").each(function(){
            var topic = $(this).val().trim();
            if (topic !== '') res.topics.push(standardized(topic));
        });
        // console.log(res.registers);
        // console.log(res.topics);
        console.log(res);

        if (res.registers.length === 0) {
            alert("Chưa chọn trường!");
            return;
        }

        $.ajax({
            url: 'getBundle',
            type: 'post',
            data: res,
            dataType: 'json',
            success: function (data) {
                console.log(data);
            },
            error: function (err) {
                console.log("Loi r", err);
            }
        })
        // console.log("end");
    });

});