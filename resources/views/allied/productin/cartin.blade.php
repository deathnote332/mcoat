<div class="card-container">
    <div class="container-fluid">
        <div class="row pad_top_20">
            <div class="col-md-6 table-search-input">
                <input type="text" id="search_cart_allied_in" name="search_cart" class="form-control" placeholder="Search..">
            </div>
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
    <div class="container-fluid">
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




        $('#search_cart_allied_in').on('input',function () {
            cart.search(this.value).draw();

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

        swal.queue([{
            title: "Are you sure?",
            text: "You want to update the stokcs",
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
                })
            }
        }])


    }

    function removeToCart(id,product_id,qty) {

        swal.queue([{
            title: "Are you sure?",
            text: "You want to remove this product to cart.",
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
                        url:BASEURL+'/removeToCart',
                        type:'POST',
                        data: {
                            _token: $('meta[name="csrf_token"]').attr('content'),
                            temp_id: id,
                            product_id: product_id,
                            qty: qty,
                            type: 4,


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
                })
            }
        }])



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