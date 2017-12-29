$('document').ready(function(){
    var BASEURL = $('#baseURL').val();
    var validator = $('#update-products').validate();

    var product = $('#alliedmanage-list').DataTable({
        ajax: BASEURL + '/getProducts',
        order: [],
        iDisplayLength: 10,
        bLengthChange: false,
        deferRender: true,
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
            { data: 'quantity_1',"orderable": false },
            { data: 'unit_price',"orderable": false },
            { data: 'action',"orderable": false }
        ],
        "createdRow": function ( row, data, index ) {
            $('td', row).eq(7).find('#add-to-cart').text('Update');
            if (data.quantity_1 == 0) {
                $(row).css({
                    'background-color': '#3498db',
                    'color': '#fff'
                });

            }else if (data.quantity_1 <= 3 && data.quantity_1 >= 1){
                $(row).css({
                    'background-color': '#95a5a6',
                    'color': '#fff'
                });
            }
        }
    });

    $('#search').on('input',function () {
        product.search(this.value).draw();

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
        var quantity = $(this).data('quantity_1');
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

    $('body').on('click','#delete',function () {
        deletedItem($(this).data('id'))
    });

});

function addNewProduct() {
    var BASEURL = $('#baseURL').val();
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
                data_save.push({ name : "type", value: 2})
                $.ajax({
                    url:BASEURL+'/addNewProduct',
                    type:'POST',
                    data: data_save,
                    success: function(data){
                        $('#addToCartModal').modal('hide');
                        var productout = $('#alliedmanage-list').DataTable();
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
    var BASEURL = $('#baseURL').val();
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
                data_save.push({ name : "type", value: 2})
                $.ajax({
                    url:BASEURL+'/updateProduct',
                    type:'POST',
                    data: data_save,
                    success: function(data){
                        var productout = $('#alliedmanage-list').DataTable();
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

function  deletedItem(id) {
    var BASEURL = $('#baseURL').val();
    swal.queue([{
        title: 'Are you sure',
        text: "You want to delete this product.",
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
                        type: 5,
                        id: id,
                        warehouse: 2
                    },
                    success: function(data){
                        var alliedmanage = $('#alliedmanage-list').DataTable();
                        alliedmanage.ajax.reload(null,false);
                        swal.insertQueueStep('Supplier deleted successfully')
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
    var productout = $('#alliedmanage-list').DataTable();
    productout.ajax.reload();
};
