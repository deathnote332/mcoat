<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #productin-list_wrapper .row:nth-child(1){
        display: none;
    }
    #productin-list_wrapper tbody tr td:nth-child(8){
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
        position: absolute;
        top: 15%;

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
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="productin-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
                <h4 class="modal-title" id="myModalLabel">Add to cart</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="product_id"  value="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Brand</label>
                            <p class="form-control-static" id="brand">Test</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <p class="form-control-static" id="category">Test</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Code</label>
                            <p class="form-control-static" id="code">Test</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Description</label>
                            <p class="form-control-static" id="description">Test</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unit</label>
                            <p class="form-control-static" id="unit">Test</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Current quantity</label>
                            <p class="form-control-static" id="current_qty">Test</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-groupx">
                            <input class="form-control" placeholder="Enter quantity" id="add-qty" maxlength="5">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-addCart">Add to cart</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<script>
    var BASEURL = $('#baseURL').val();
    $('document').ready(function(){


        var product = $('#productin-list').DataTable({
            ajax: BASEURL + '/getProducts',
            order: [],
            iDisplayLength: 14,
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
                if (data.quantity == 0) {
                    $('td', row).eq(7).find('.alert').css({'visibility':'hidden'});
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


        $('body').on('click','#add-to-cart',function() {
            $('#add-qty').val('')
            var id = $(this).data('id');
            var brand = $(this).data('brand');
            var category =$(this).data('category');
            var code = $(this).data('code');
            var description = $(this).data('description');
            var quantity = $(this).data('quantity');
            var unit = $(this).data('unit');

            $('#addToCartModal').modal('show');
            $('#brand').text(brand)
            $('#category').text(category)
            $('#code').text(code)
            $('#description').text(description)
            $('#unit').text(unit)
            $('#current_qty').text(quantity)

            $('#product_id').val(id);

        });

        $('#btn-addCart').on('click',function () {

            if( parseInt($('#add-qty').val()) <= 0) {
                swal({
                    title: "",
                    text: "Invalid quantity",
                    type: "error"
                });
            }else{
                addToCart($('#product_id').val(),$('#add-qty').val(),$('#current_qty').text())
            }


        })

        //numeric input
        $('#add-qty').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

    });

    function addToCart(id,qty,current) {

        swal({
            title: "Are you sure?",
            text: "You want to add this product to cart.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {

            $.ajax({
                url:BASEURL+'/addToCart',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    id: id,
                    qty: qty,
                    current_qty:current,
                    type:2,
                },
                success: function(data){
                    var productout = $('#productout-list').DataTable();
                    productout.ajax.reload();

                    swal({
                        title: "",
                        text: "Product addded to cart",
                        type:"success"
                    }).then(function () {
                        $('#addToCartModal').modal('hide');
                    });


                    $.ajax({
                        url:BASEURL + '/cartCountIn',
                        type: 'GET',
                        success: function (data){
                            $('#tab-productout li:nth-child(2) a').html(data);
                        }
                    });

                }
            });
        });


    }



    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var productin = $('#productin-list').DataTable();
        productin.ajax.reload();
    };

</script>