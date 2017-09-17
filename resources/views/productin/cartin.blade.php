<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #cartIn-list_wrapper .row:nth-child(1){
        display: none;
    }

    #cartIn-list_wrapper tbody tr td:nth-child(9){
        text-align: center;
    }
    .search-inputs,.receiptin-details{
        padding-left: 15px;
        padding-bottom: 10px;
    }


    .alert {
        padding: 2px 10px;
        margin-bottom: 0px;
        border: 1px solid transparent;
        border-radius: 4px;
    }
    .btn-print{

        margin-top: 20px;
    }
    .branches{
        font-size: 18px;
        margin-left: 15px;
        margin-top: 10px;
    }
    .btn-print .btn{
        width:300px;
        font-size: 20px;

    }
    #remove-cart{
        cursor: pointer;
    }
    .total-amount{
        padding: 5px;
        /* border: 1px solid red; */
        width: 300px;
        /* text-align: right; */
        position: relative;
        /* right: -22px; */
        float: right;
        text-align: center;
        background: black;
        color: white;
        font-size: 24px;
        margin-top: 10px;

    }
</style>

<div class="card-container">
    <div class="row">
        <div class="col-md-2">
            <div class="search-inputs">
                <select class="form-control" id="searchByCart">
                    <option>Brand</option>
                    <option>Category</option>
                    <option>Code</option>
                    <option>Descripion</option>
                    <option>All</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <input type="text" id="search_cart" name="search_cart" class="form-control" placeholder="Search..">
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="cartIn-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th>Brand</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>

    <div class="row">
        <div class="receiptin-details">
            <div class="col-md-3">

                <input type="text" class="form-control" name="invoice_number" placeholder="Invoice number">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="invoice_number" placeholder="Invoice number">
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-9 text-right">
            <div class="btn-print">

                <button type="button" class="btn btn-primary" id="save">Save</button>
            </div>

        </div>
    </div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
    $('document').ready(function(){


        var cart = $('#cartIn-list').DataTable({
            ajax: BASEURL + '/getCart/2',
            order: [],
            iDisplayLength: 10,
            bLengthChange: false,
            columns: [

                { data: 'brand',"orderable": false },
                { data: 'category',"orderable": false},
                { data: 'code',"orderable": false },
                { data: 'description',"orderable": false },
                { data: 'unit',"orderable": false },
                { data: 'temp_qty',"orderable": false },
                { data: 'unit_price',"orderable": false },
                { data: 'total',"orderable": false },
                { data: 'action',"orderable": false }
            ]

        });
        $('#searchByCart').on('change',function () {
            $('#search_cart').val('')
            cart.search( '' )
                .columns().search( '' )
                .draw();
            alert()
        })

        $('#search_cart').on('input',function () {
            var searchBy = $('#searchByCart option:selected').val();
            if(searchBy == 'All'){
                cart.search(this.value).draw();
            }else if(searchBy == 'Brand'){

                cart.column(0).search(this.value).draw();
            }else if(searchBy == 'Category'){

                cart.column(1).search(this.value).draw();
            }else if(searchBy == 'Code'){

                cart.column(2).search(this.value).draw();
            }else if(searchBy == 'Description'){

                cart.column(3).search(this.value).draw();
            }

        })

        $('body').on('click','#remove-cart',function () {
            removeToCart($(this).data('id'),$(this).data('product_id'),$(this).data('qty'))
        })

        $('.btn-print .btn').on('click',function () {
            var branch = $('.branches option:selected');
            if(branch.val()=="Choose Location"){
                swal({
                    title: "",
                    text: "Please choose delivery location",
                    type: "error"
                });
            }else{
                printReceipt(branch.data('id'))
            }
        })



    });

    function printReceipt(branch_id) {

        swal({
            title: "Are you sure?",
            text: "You want to print",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }).then(function () {

            $.ajax({
                url:BASEURL+'/saveProductout',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    branch_id: branch_id,

                },
                success: function(data){
                    var productout = $('#cart-list').DataTable();
                    productout.ajax.reload();
                    $('.total-amount').text('₱ 0.00')
                    $.ajax({
                        url:BASEURL + '/cartCount',
                        type: 'GET',
                        success: function (data){
                            $('#tab-productout li:nth-child(2) a').html(data);
                        }
                    });

                    swal({
                        title: "",
                        text: "Receipt successfully created",
                        type:"success"
                    }).then(function () {

                        var i =0;
                        for(i=0;i<data.length; i++){
                            var path = '/invoice/'+ data[i];
                            window.open(path);
                        }
                    })
                }
            });
        });

    }

    function removeToCart(id,product_id,qty) {

        swal({
            title: "Are you sure?",
            text: "You want to remove this product to cart.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {

            $.ajax({
                url:BASEURL+'/removeToCart',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    temp_id: id,
                    product_id: product_id,
                    qty: qty,
                    type: 2

                },
                success: function(data){
                    var productout = $('#cartIn-list').DataTable();
                    productout.ajax.reload();

                    swal({
                        title: "",
                        text: "Product removed to cart",
                        type:"success"
                    })


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
        var cartIn = $('#cartIn-list').DataTable();
        cartIn.ajax.reload();
    };

</script>