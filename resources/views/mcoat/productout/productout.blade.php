<div class="card-container">
    <div class="container-fluid">
        <div class="row pad_top_20">
            <div class="col-md-6 col-lg-6 table-search-input ">
                <input type="text" id="search-out" name="search" class="form-control" placeholder="Search..">
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
                    <th >Quantity</th>
                    <th>Unit Price</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
@include('modal.productoutmcoatmodal')
<script>
    var BASEURL = $('#baseURL').val();
    $('document').ready(function(){
        $('table').find('label#delete').remove();

        var product = $('#productout-list').DataTable({
            ajax: BASEURL + '/getProducts',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            deferRender:    true,
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
                { data: 'quantity',"orderable": false },
                { data: 'unit_price',"orderable": false },
                { data: 'action',"orderable": false }
            ],
            "createdRow": function ( row, data, index ) {

//                $('td', row).eq(7).find('#delete').remove();
                if (data.quantity == 0) {
                    $('td', row).eq(7).find('#add-to-cart').css({'visibility':'hidden'});
                    $(row).css({
                        'background-color': '#3498db',
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


        $('#search-out').on('input',function () {
            product.search(this.value).draw();
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

            if(parseInt($('#current_qty').text()) < parseInt($('#add-qty').val()) || parseInt($('#add-qty').val()) <= 0) {
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

        swal.queue([{
            title: 'Are you sure',
            text: "You want to add this product to cart.",
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
                        url:BASEURL+'/addToCart',
                        type:'POST',
                        data: {
                            _token: $('meta[name="csrf_token"]').attr('content'),
                            id: id,
                            qty: qty,
                            current_qty:current,
                            type:1,
                        },
                        success: function(data){
                            var productout = $('#productout-list').DataTable();
                            productout.ajax.reload(null, false );

                            var cartlist = $('#cart-list').DataTable();
                            cartlist.ajax.reload(null, false );

                            $('#print').prop('disabled', false);

                            $('#addToCartModal').modal('hide');
                            swal.insertQueueStep(data)
                            resolve()
                            $.ajax({
                                url:BASEURL + '/cartCount',
                                type: 'GET',
                                success: function (data){
                                    $('#tab-productout li:nth-child(2) a').html(data);
                                    receiptCount()
                                }
                            });
                        }
                    });
                })
            }
        }])
    }

    function  receiptCount() {
        $.ajax({
            url:BASEURL + '/receiptCount',
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
        var productout = $('#productout-list').DataTable();
        productout.ajax.reload();
    };

</script>