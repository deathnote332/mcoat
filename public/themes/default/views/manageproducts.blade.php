<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #productout-list_wrapper .row:nth-child(1){
        display: none;
    }

    #productout-list_wrapper tbody tr td:nth-child(8){
        text-align: center;
    }
    .search-inputs{
        padding-left: 15px;
        padding-bottom: 10px;
    }
    #add-to-cart{
        cursor: pointer;
    }

    .modal{

        top: 15%;

    }
    .alert-info{
        background-color: #31708f;
        color: white;
    }
    label#add-to-cart {
        padding: 5px 20px;
        margin: 0;
    }
    .btn-add {
        padding:5px 20px;

    }
    label.error{
        color: red;
        font-size: 12px;
        font-style: italic;
    }
</style>

<div class="card-container">
    <div class="row">
        <div class="col-md-2">
            <div class="search-inputs">
                <select class="form-control" id="searchBy">
                    <option>Brand</option>
                    <option>Category</option>
                    <option>Code</option>
                    <option>Descripion</option>
                    <option selected>All</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search..">
        </div>
        <div class="col-md-3 col-md-offset-4">
            <div class="btn-add">
                <button type="button" class="btn btn-primary form-control add-new"><span class="fa fa-plus"> Add new product</span></button>
            </div>

        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="productout-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th>Brand</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
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
                <h4 class="modal-title" id="myModalLabel">Update product</h4>
            </div>
            <form id="update-products">
                <div class="modal-body">
                    <input type="hidden" id="product_id" name="product_id"  value="">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label>Brand</label>
                                <input  type="text" class="form-control" id="brand" name="brand" required/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label>Category</label>
                                <input  type="text" class="form-control" id="category" name="category" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label>Code</label>
                                <input  type="text" class="form-control" id="code" name="code" required/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label>Description</label>
                                <input  type="text" class="form-control" id="description" name="description" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <input  type="text" class="form-control" id="unit" name="unit" required/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group">
                                <label>Unit price</label>
                                <input  type="text" class="form-control" id="unit_price" name="unit_price" required/>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label>Quantity</label>
                                <input  type="text" class="form-control" id="quantity" name="quantity" required/>
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
    $('document').ready(function(){

        var validator = $('#update-products').validate();


        var product = $('#productout-list').DataTable({
            ajax: BASEURL + '/getProducts',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            columns: [

                { data: 'brand',"orderable": false },
                { data: 'category',"orderable": false},
                { data: 'code',"orderable": false },
                { data: 'description',"orderable": false },
                { data: 'unit',"orderable": false },
                { data: 'quantity',"orderable": false },
                { data: 'unit_price',"orderable": false },
                { data: 'action',"orderable": false }
            ],
            "createdRow": function ( row, data, index ) {
                $('td', row).eq(7).find('.alert').text('Update');
                if (data.quantity == 0) {

                    $(row).css({
                        'background-color': '#e74c3c',
                        'color': '#fff'
                    });

                }else if (data.quantity <= 3 && data.quantity >= 1){
                    $(row).css({
                        'background-color': '#95a5a6',
                        'color': '#fff'
                    });
                }
            }
        });
        $('#searchBy').on('change',function () {
            $('#search').val('')
            product.search( '' )
                .columns().search( '' )
                .draw();

        })

        $('#search').on('input',function () {
            var searchBy = $('#searchBy option:selected').val();
            if(searchBy == 'All'){
                product.search(this.value).draw();
            }else if(searchBy == 'Brand'){

                product.column(0).search(this.value).draw();
            }else if(searchBy == 'Category'){

                product.column(1).search(this.value).draw();
            }else if(searchBy == 'Code'){

                product.column(2).search(this.value).draw();
            }else if(searchBy == 'Description'){

                product.column(3).search(this.value).draw();
            }

        })

        $('body').on('click','.add-new',function() {
            $('#addToCartModal').modal('show');
            $('.modal-title').text('Add new product');
            $('#addToCartModal').find('#btn-update').text('Add')

        });

        $('#addToCartModal').on('hidden.bs.modal', function(){
            validator.resetForm();
            $("#update-products")[0].reset();
        });

        $('body').on('click','#add-to-cart',function() {
            $('.modal-title').text('Update product');
            $('#addToCartModal').find('#btn-update').text('Update')

            $('#add-qty').val('')
            var id = $(this).data('id');
            var brand = $(this).data('brand');
            var category =$(this).data('category');
            var code = $(this).data('code');
            var description = $(this).data('description');
            var unit_price = $(this).data('unit_price');
            var quantity = $(this).data('quantity');
            var unit = $(this).data('unit');

            $('#addToCartModal').modal('show');
            $('#brand').val(brand)
            $('#category').val(category)
            $('#unit_price').val(unit_price)
            $('#code').val(code)
            $('#description').val(description)
            $('#unit').val(unit)
            $('#quantity').val(quantity)

            $('#product_id').val(id);

        });

        $('#btn-update').on('click',function () {
            var form = $('#update-products');
            if(form.valid()){
                var action = ($(this).text() == 'Add') ? addNewProduct(): updateProduct();
            }
        })

        //numeric input
        $('#quantity,#unit_price').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

    });

    function addNewProduct() {

        swal.queue([{
            title: 'Are you sure',
            text: "You want to add this product.",
            type:'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnConfirm: false,
            confirmButtonText: 'Okay',
            confirmButtonColor: "#DD6B55",
            preConfirm: function () {
                return new Promise(function (resolve) {
                    var data_save = $('#update-products').serializeArray();
                    data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})
                    data_save.push({ name : "type", value: 1})
                    $.ajax({
                        url:BASEURL+'/addNewProduct',
                        type:'POST',
                        data: data_save,
                        success: function(data){
                            $('#addToCartModal').modal('hide');
                            var productout = $('#productout-list').DataTable();
                            productout.ajax.reload(null,false);
                            $("#update-products")[0].reset()
                            var type = (data =='Product existed') ? 'error': 'success';
                            swal.insertQueueStep(data)
                            resolve()
                        }
                    });
                })
            }
        }])

    }


    function updateProduct() {

        swal.queue([{
            title: 'Are you sure',
            text: "You want to update this product.",
            type:'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnConfirm: false,
            confirmButtonText: 'Okay',
            confirmButtonColor: "#DD6B55",
            preConfirm: function () {
                return new Promise(function (resolve) {
                    var data_save = $('#update-products').serializeArray();
                    data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})
                    data_save.push({ name : "type", value: 1})
                    $.ajax({
                        url:BASEURL+'/updateProduct',
                        type:'POST',
                        data: data_save,
                        success: function(data){
                            var productout = $('#productout-list').DataTable();
                            productout.ajax.reload(null,false);
                            $("#update-products")[0].reset()
                            $('#addToCartModal').modal('hide');
                            swal.insertQueueStep(data)
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
        var productout = $('#productout-list').DataTable();
        productout.ajax.reload();
    };

</script>