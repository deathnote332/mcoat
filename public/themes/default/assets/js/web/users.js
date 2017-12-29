
$(document).ready(function () {
    var BASEURL = $('#baseURL').val();
    var users = $('#user-list').DataTable({
        ajax: BASEURL + '/admin/getusers',
        order: [],
        iDisplayLength: 12,
        bLengthChange: false,
        deferRender:    true,
        columns: [

            { data: 'name',"orderable": false },
            { data: 'email',"orderable": false},
            { data: 'status',"orderable": false},
            { data: 'user_status',"orderable": false},
            { data: 'created_at',"orderable": false },
            { data: 'action',"orderable": false },


        ]
    });

    $('body').on('click','#approve',function () {
        approveDisapprove($(this).data('id'),$(this).data('approve'))
    })
    $('body').on('click','#admin',function () {
        approveDisapproveAdmin($(this).data('id'),$(this).data('approve'))
    })

    $('body').on('click','#delete',function () {

        deletedItem($(this).data('id'))
    });

    $('#search').on('input',function () {

        users.search(this.value).draw();
    })


});

function approveDisapprove(id,status) {
    var BASEURL = $('#baseURL').val();
    var message = (status == 1) ? 'approve' :'disapprove'
    swal({
        title: "Are you sure?",
        text: "You want to "+ message +" this user.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: 'Okay',
        closeOnConfirm: false
    }).then(function () {
        $.ajax({
            url:BASEURL+'/admin/approveDisapproveUser',
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
                    text: "User successfully "+ message,
                    type:"success"
                })
            }
        });
    });

}

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
            url:BASEURL+'/admin/approveDisapproveUserAdmin',
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

function  deletedItem(id) {
    var BASEURL = $('#baseURL').val();
    swal.queue([{
        title: 'Are you sure',
        text: "You want to delete this user.",
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
                    url:BASEURL+'/deleteitems',
                    type:'POST',
                    data: {
                        _token: $('meta[name="csrf_token"]').attr('content'),
                        type: 1,
                        id: id
                    },
                    success: function(data){
                        var user = $('#user-list').DataTable();
                        user.ajax.reload(null,false);

                        swal.insertQueueStep('Supplier deleted successfully')
                        resolve()
                    }
                });
            })
        }
    }])

}

//New error event handling has been added in Datatables v1.10.5
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.log(message);
    var supplier = $('#user-list').DataTable();
    supplier.ajax.reload();
};