{!! Theme::asset()->usePath()->add('style','/css/web/style.css') !!}
<div class="card-container">
    <div class="row">

        <div class="col-md-6 col-lg-6 pad-left col-sm-6">
            <input type="text" id="search" name="search" class="form-control search-inputs" placeholder="Search..">
        </div>
        <div class="col-md-4 col-md-offset-2 col-sm-6">
            <div class="btn-add">
                <button type="button" class="btn btn-primary form-control add-new"><span class="fa fa-plus"> Add new warehouse</span></button>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="branch-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Warehouse name</th>
                    <th>Location</th>
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
                <h4 class="modal-title" id="myModalLabel">Update Branch</h4>
            </div>
            <form id="branch">
                <div class="modal-body">
                    <input type="hidden" id="supplier_id" name="id"  value="">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label>Warehouse name</label>
                                <input class="form-control" id="name" name="name"/>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label>Location</label>
                                <input class="form-control" id="address" name="location"/>
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
        var branch = $('#branch-list').DataTable({
            ajax: BASEURL + '/admin/getwarehouse',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            deferRender: true,
            deferRender:    true,
            columns: [

                { data: 'warehouse',"orderable": false },
                { data: 'location',"orderable": false},
                { data: 'created_at',"orderable": false },
                { data: 'action',"orderable": false },


            ]
        });


        $('body').on('click','#update',function () {
            $('#addToCartModal .modal-title').text('Update')
            $('#addToCartModal').modal('show')
            $('#btn-update').text('Update')
            $('#name').val($(this).data('name'))
            $('#address').val($(this).data('location'))
            $('#supplier_id').val($(this).data('id'))
        })

        $('body').on('click','#delete',function () {
            deletedItem($(this).data('id'))
        });

        $('#btn-update').on('click',function () {
            if($(this).text() == 'Add'){
                addNew()
            }else{
                addToCart()
            }

        })

        $('#search').on('input',function () {

            branch.search(this.value).draw();
        })

        $('.add-new').on('click',function () {
            $('#addToCartModal .modal-title').text('Add new warehouse')
            $('#addToCartModal').modal('show')
            $('#btn-update').text('Add')
            $('#name').val('')
            $('#address').val('')
        })
    });
    function addToCart() {

        swal({
            title: "Are you sure?",
            text: "You want to update this warehouse.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {
            var data_save = $('#branch').serializeArray();
            data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})

            $.ajax({
                url:BASEURL+'/admin/updatewarehouse',
                type:'POST',
                data: data_save,
                success: function(data){
                    var branch = $('#branch-list').DataTable();
                    branch.ajax.reload(null, false );

                    $('#addToCartModal').modal('hide');

                    swal({
                        title: "",
                        text: "Warehouse updated successfully",
                        type:"success"
                    })
                }
            });
        });

    }

    function addNew() {

        swal({
            title: "Are you sure?",
            text: "You want to add this warehouse.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {
            var data_save = $('#branch').serializeArray();
            data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})

            $.ajax({
                url:BASEURL+'/admin/addwarehouse',
                type:'POST',
                data: data_save,
                success: function(data){
                    var branch = $('#branch-list').DataTable();
                    branch.ajax.reload(null, false );

                    $('#addToCartModal').modal('hide');

                    swal({
                        title: "",
                        text: "Warehouse added successfully",
                        type:"success"
                    })
                }
            });
        });

    }

    function  deletedItem(id) {
        swal.queue([{
            title: 'Are you sure',
            text: "You want to delete this branch.",
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
                            type: 6,
                            id: id
                        },
                        success: function(data){
                            var branch = $('#branch-list').DataTable();
                            branch.ajax.reload(null,false);

                            swal.insertQueueStep('Warehouse deleted successfully')
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
        var branch = $('#branch-list').DataTable();
        branch.ajax.reload();
    };
</script>