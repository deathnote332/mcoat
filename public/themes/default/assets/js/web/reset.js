$(document).ready(function () {
    var BASEURL = $('#baseURL').val();
    var reset = $('#reset-list').DataTable({
        ajax: BASEURL + '/admin/getresetted',
        order: [],
        iDisplayLength: 5,
        bLengthChange: false,
        bDeferRender:    true,
        columns: [
            { data: 'reset_by',"orderable": false },
            { data: 'message',"orderable": false},
            { data: 'created_at',"orderable": false},
            { data: 'action',"orderable": false},

        ]
    });

    viewProductList()
    viewAlliedProductList()

    $('body').on('click','#undo',function () {
        var id = $(this).data('id');
        swal.queue([{
            title: 'Are you sure',
            text: "You want undo this product quantity.",
            type:'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnConfirm: false,
            confirmButtonText: 'Okay',
            confirmButtonColor: "#DD6B55",
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url:BASEURL + '/admin/undoreset',
                        type: 'POST',
                        data:{
                            _token : $('meta[name="csrf_token"]').attr('content'),
                            id: id
                        },
                        success: function (data){
                            var supplier = $('#reset-list').DataTable();
                            supplier.ajax.reload();
                            swal.insertQueueStep(data)
                            resolve()
                        }
                    });

                })
            }
        }])


    })


})

function viewProductList() {
    var BASEURL = $('#baseURL').val();
    $.ajax({
        url:BASEURL + '/admin/resetmcoat',
        type: 'GET',
        success: function (data){
            $('#mcoat').html(data);
        }
    });

}


function viewAlliedProductList() {
    var BASEURL = $('#baseURL').val();
    $.ajax({
        url:BASEURL + '/admin/resetallied',
        type: 'GET',
        success: function (data){
            $('#allied').html(data);
        }
    });

}
//New error event handling has been added in Datatables v1.10.5
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.log(message);
    var supplier = $('#reset-list').DataTable();
    supplier.ajax.reload();
};