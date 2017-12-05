{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}

<div class="card-container">
    <div class="row">

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

        <div class="col-md-12">
            <div class="print-count">
                Total Receipt ( <span>1</span> )
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <select class="branches form-control">
                <option selected disabled>Choose Location</option>
                @foreach(\App\Branches::orderBy('name','asc')->where('status',1)->get() as $key=>$val)
                    <option value="{{$val->name}}" data-address="{{$val->address}}" data-id="{{$val->id}}">{{$val->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 col-md-offset-3">
            <div class="btn-print">
                <button type="button" class="form-control btn btn-primary form-control" id="print">Print</button>
            </div>

        </div>
        <div class="col-md-3 ">
            <div class="total-amount form-control">
                {{ '₱ '.number_format(\App\TempProductout::join('tblproducts','temp_product_out.product_id','tblproducts.id')->where('type',3)->select(DB::raw('sum(temp_product_out.qty * tblproducts.unit_price) as total'))->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->first()->total, 2) }}
            </div>

        </div>
    </div>

</div>
<script>
    var BASEURL = $('#baseURL').val();
    $('document').ready(function(){

        //receipt count
        receiptCount();


        var cart = $('#cart-list').DataTable({
            ajax: BASEURL + '/getCart/3',
            order: [],
            iDisplayLength: 10,
            bLengthChange: false,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                }
            },
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

        swal.queue([{
            title: "Are you sure?",
            text: "You want to print",
            type: "warning",
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnConfirm: false,
            confirmButtonText: 'Okay',
            confirmButtonColor: "#DD6B55",
            preConfirm: function () {
                return new Promise(function (resolve) {

                    $.ajax({
                        url:BASEURL+'/saveProductout',
                        type:'POST',
                        data: {
                            _token: $('meta[name="csrf_token"]').attr('content'),
                            branch_id: branch_id,
                            type:3
                        },
                        success: function(data){
                            var productout = $('#cart-list').DataTable();
                            productout.ajax.reload();

                            $('.total-amount').text('₱ 0.00')
                            receiptCount();

                            $.ajax({
                                url:BASEURL + '/alliedcartcount',
                                type: 'GET',
                                success: function (data){
                                    $('#tab-productout li:nth-child(2) a').html(data);
                                }
                            });

                            $('.branches').prop('selectedIndex',0);

                            swal({
                                title: "",
                                text: "Receipt successfully created",
                                type:"success"
                            })

                            var i =0;
                            for(i=0;i<data.length; i++){
                                var path = BASEURL+'/invoice/'+ data[i];
                                window.open(path);
                            }
                        }
                    });

                })
            }
        }])



    }

    function removeToCart(id,product_id,qty) {
        swal.queue([{
            title: 'Are you sure',
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
                            type: 3
                        },
                        success: function(data){
                            var productout = $('#cart-list').DataTable();
                            productout.ajax.reload();
                            var productout = $('#alliedproductout-list').DataTable();
                            productout.ajax.reload();
                            swal.insertQueueStep('Product successfully removed.')
                            resolve()
                            $.ajax({
                                url:BASEURL + '/alliedcartcount',
                                type: 'GET',
                                success: function (data){
                                    $('#tab-productout li:nth-child(2) a').html(data);
                                }
                            });
                            receiptCount()
                            $('.total-amount').text( '₱ '+data)
                        }
                    });
                })
            }
        }])
    }

    function  receiptCount() {
        $.ajax({
            url:BASEURL + '/alliedreceiptcount',
            type: 'GET',
            success: function (data){
                $('.print-count').html("Total Receipt ( <span>"+data+"</span> )");

                if(data == 0){
                    $('#print').prop('disabled',true);
                }
            }
        });
    }

    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var cart = $('#cart-list').DataTable();
        cart.ajax.reload();
    };

</script>