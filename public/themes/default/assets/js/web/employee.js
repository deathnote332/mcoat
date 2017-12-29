
$(document).ready(function () {
    var BASEURL = $('#baseURL').val();
    var users = $('#user-list').DataTable({
        ajax: BASEURL + '/admin/getemployee',
        order: [],
        iDisplayLength: 12,
        bLengthChange: false,
        bInfo: false,
        deferRender: true,
        deferRender:    true,
        columns: [

            { data: 'name',"orderable": false },
            { data: 'position',"orderable": false},
            { data: 'date_hired',"orderable": false},
            { data: 'branch_hired',"orderable": false},
            { data: 'action',"orderable": false },
        ]
    });

    $('#search').on('input',function () {
        users.search(this.value).draw();
    })

});


function approveDisapproveAdmin(id,status) {
    var BASEURL = $('#baseURL').val();
    var message = (status == 1) ? 'appoint' :'revoke'
    swal({
        title: "Are you sure?",
        text: "You want to "+ message +" this user as administrator.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: 'Okay',
        closeOnConfirm: false
    }).then(function () {
        $.ajax({
            url:BASEURL+'/approveDisapproveUserAdmin',
            type:'POST',
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                status: status,
                id: id
            },
            success: function(data){
                var supplier = $('#user-list').DataTable();
                supplier.ajax.reload(null, false );

                swal({
                    title: "",
                    text: "User successfully "+ message+'ed being administrator' ,
                    type:"success"
                })
            }
        });
    });

}
//New error event handling has been added in Datatables v1.10.5
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.log(message);
    var supplier = $('#user-list').DataTable();
    supplier.ajax.reload();
};