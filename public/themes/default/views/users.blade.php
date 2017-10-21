<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #user-list_wrapper .row:nth-child(1){
        display: none;
    }
    #user-list_wrapper tbody tr td:nth-child(4){
        text-align: center;
    }
    .search-inputs{
        margin-left: 15px;
        margin-bottom: 10px;
    }
    #add-to-cart{
        cursor: pointer;
    }

    label.alert{
        margin: 0;
        padding: 5px 30px;
        margin-left: 20px;
        cursor: pointer;
    }
    #approve{
        cursor: pointer;
    }
    .pending,.approved,.online,.offline{
        padding: 5px 10px !important;
        border: none;
        background: none;
        cursor: none;
    }
    .offline{
        color:red;
    }
    .online{
        color:green;
    }

</style>
<div class="card-container">
    <div class="row">

        <div class="col-md-3">
            <input type="text" id="search" name="search" class="form-control search-inputs" placeholder="Search..">
        </div>
    </div>
<div class="row">
    <div class="col-md-12">
        <table id="user-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>User Status</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Action</th>

            </tr>
            </thead>

        </table>
    </div>
</div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
$(document).ready(function () {
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
});

    function approveDisapprove(id,status) {
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
    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var supplier = $('#user-list').DataTable();
        supplier.ajax.reload();
    };
</script>