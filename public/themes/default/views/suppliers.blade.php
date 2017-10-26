<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #supplier-list_wrapper .row:nth-child(1){
        display: none;
    }
    #supplier-list_wrapper tbody tr td:nth-child(4){
        text-align: center;
    }
    .search-inputs{
        margin-left: 15px;
        margin-bottom: 10px;
    }
    #add-to-cart{
        cursor: pointer;
    }

    .modal{

        top: 15%;

    }

    label.alert{
        margin: 0;
        padding: 5px 30px;
        margin-left: 20px;
        cursor: pointer;
        color: white;
    }
    .alert-warning{
        background-color: #8a6d3b;
    }
    .alert-danger{
        background-color: #a94442;
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
            <table id="supplier-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Supplier name</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Supplier</h4>
            </div>
            <form id="supplier">
                <div class="modal-body">
                    <input type="hidden" id="supplier_id" name="id"  value="">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" id="name" name="name"/>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" id="address" name="address"/>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-update">Update</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {
        var users = $('#supplier-list').DataTable({
            ajax: BASEURL + '/getsuppliers',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            deferRender:    true,
            columns: [

                { data: 'name',"orderable": false },
                { data: 'address',"orderable": false},
                { data: 'created_at',"orderable": false },
                { data: 'action',"orderable": false },
            ]
        });

        $('body').on('click','#update',function () {
            $('#addToCartModal').modal('show')
            $('#name').val($(this).data('name'))
            $('#address').val($(this).data('address'))
            $('#supplier_id').val($(this).data('id'))
        })

        $('body').on('click','#delete',function () {
            alert()
            deletedItem($(this).data('id'))
        });

        $('#btn-update').on('click',function () {
            addToCart()
        })
    });
    function addToCart() {

        swal({
            title: "Are you sure?",
            text: "You want to update this supplier.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {
            var data_save = $('#supplier').serializeArray();
            data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})

            $.ajax({
                url:BASEURL+'/updatesupplier',
                type:'POST',
                data: data_save,
                success: function(data){
                    var supplier = $('#supplier-list').DataTable();
                    supplier.ajax.reload(null, false );

                    $('#addToCartModal').modal('hide');

                    swal({
                        title: "",
                        text: "Supplier updated successfully",
                        type:"success"
                    })
                }
            });
        });
    }

    function  deletedItem(id) {
        $.ajax({
            url:BASEURL+'/deleteitems',
            type:'POST',
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                type: 3,
                id: id
            },
            success: function(data){

                swal({
                    title: "",
                    text: "Supplier deleted successfully",
                    type:"success"
                })
            }
        });
    }
    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var supplier = $('#supplier-list').DataTable();
        supplier.ajax.reload();
    };
</script>