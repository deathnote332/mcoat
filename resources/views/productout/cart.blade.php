<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #cart-list_wrapper .row:nth-child(1){
        display: none;
    }
    .search-inputs{
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
            <table id="cart-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
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
        <div class="col-md-3">
            <select class="branches form-control">
                <option selected disabled>Choose Location</option>
                @foreach(\App\Branches::orderBy('name','asc')->get() as $key=>$val)
                    <option value="{{$val->name}}" data-address="{{$val->address}}">{{$val->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 col-md-offset-6">
            <div class="total-amount">
                {{ '₱ '.number_format(\App\TempProductout::join('tblproducts','temp_product_out.product_id','tblproducts.id')->select(DB::raw('sum(temp_product_out.qty * tblproducts.unit_price) as total'))->first()->total, 2) }}
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-offset-9 text-right">
            <div class="btn-print">

                <button type="button" class="btn btn-primary">Print</button>
            </div>

        </div>
    </div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
    $('document').ready(function(){


        var cart = $('#cart-list').DataTable({
            ajax: BASEURL + '/getCart',
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
            var branch = $('.branches option:selected').val();
            if(branch=="Choose Location"){
                swal({
                    title: "",
                    text: "Please choose delivery location",
                    type: "error"
                });
            }else{

            }
        })

    });

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
                    var productout = $('#cart-list').DataTable();
                    productout.ajax.reload();

                    swal({
                        title: "",
                        text: "Product removed to cart",
                        type:"success"
                    })


                    $.ajax({
                        url:BASEURL + '/cartCount',
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
        var cart = $('#cart-list').DataTable();
        cart.ajax.reload();
    };

</script>