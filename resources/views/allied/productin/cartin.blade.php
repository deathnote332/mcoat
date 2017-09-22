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

    .branches{
        font-size: 18px;
        margin-left: 15px;
        margin-top: 10px;
    }
    .btn-print .btn{

        font-size: 16px;


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
    .receiptin-details input, .receiptin-details select, .receiptin-details .btn{
        margin-top: 15px;
    }

    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        /* background-color: #eee; */
        background-color: #337ab7;
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

                <select class="form-control" id="suppliers">
                    <option selected disabled value="0">Choose supplier</option>
                    @foreach(\App\Supplier::orderBy('name','asc')->get() as $key=>$val)
                        <option value="{{$val->name}}" data-id="{{$val->id}}" data-address="{{$val->address}}">{{$val->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="invoice_number" id="invoice_number" placeholder="Invoice number">
            </div>


            <div class="col-md-3 col-md-offset-3">
                <div class="btn-print">

                    <button type="button" class="form-control btn btn-primary" id="save">Save</button>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
    $('document').ready(function(){
        $('#save').prop('disabled',true);

        cartCount()

        var cart = $('#cartIn-list').DataTable({
            ajax: BASEURL + '/getCart/4',
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
            var suppliers = $('#suppliers option:selected');

            if(suppliers.val()=="0" || $('#invoice_number').val() == ''){
                swal({
                    title: "",
                    text: "Please fill required fields",
                    type: "error"
                });
            }else{
                addToStocks($('#invoice_number').val(),suppliers.data('id'))
            }
        })

    });

    function addToStocks(receipt_no,supplier_id) {

        swal({
            title: "Are you sure?",
            text: "You want to update the stokcs",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }).then(function () {

            $.ajax({
                url:BASEURL+'/saveProductin',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    receipt_no: receipt_no,
                    supplier_id: supplier_id,
                    type:4

                },
                success: function(data){
                    var productout = $('#cartIn-list').DataTable();
                    productout.ajax.reload();

                    var productin = $('#productin-list').DataTable();
                    productin.ajax.reload();

                    cartCount()



                    swal({
                        title: "",
                        text: "Stocks are now updated",
                        type:"success"
                    })

                    $('#invoice_number').val('');
                    $('#suppliers').val('0');
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


                },
                success: function(data){
                    cartCount()

                    var productout = $('#cartIn-list').DataTable();
                    productout.ajax.reload();

                    swal({
                        title: "",
                        text: "Product removed to cart",
                        type:"success"
                    })




                }
            });
        });


    }

     function cartCount() {
         $.ajax({
             url:BASEURL + '/alliedcartcountin',
             type: 'GET',
             success: function (data){

                 if(data == 0){
                     $('#save').prop('disabled',true);
                     $('#tab-productout li:nth-child(2) a').html("Cart")
                 }else{
                     $('#tab-productout li:nth-child(2) a').html("Cart  <span class='badge badge-danger'>"+ data + "</span>");
                     $('#save').prop('disabled',false);
                 }
             }
         });
    }

    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var cartIn = $('#cartIn-list').DataTable();
        cartIn.ajax.reload();
    };

</script>