$(document).ready(function () {
    var BASEURL = $('#baseURL').val();
    var suppliers = $('#supplier-list').DataTable({
        ajax: BASEURL + '/getsuppliers',
        order: [],
        iDisplayLength: 12,
        bLengthChange: false,
        bDeferRender:    true,
        columns: [

            { data: 'name',"orderable": false },
            { data: 'address',"orderable": false},
            { data: 'created_at',"orderable": false },
            { data: 'action',"orderable": false },
        ]
    });

    $('body').on('click','#update',function () {
        $('#addToCartModal').modal('show')
        $('#name').val($(this).data('name'))
        $('#address').val($(this).data('address'))
        $('#supplier_id').val($(this).data('id'))
    })

    $('body').on('click','#delete',function () {

        deletedItem($(this).data('id'))
    });

    $('#btn-update').on('click',function () {
        addToCart()
    })


    $('#search').on('input',function () {

        suppliers.search(this.value).draw();
    })
});
function addToCart() {
    var BASEURL = $('#baseURL').val();
    swal({
        title: "Are you sure?",
        text: "You want to update this supplier.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: 'Okay',
        closeOnConfirm: false
    }).then(function () {
        var data_save = $('#supplier').serializeArray();
        data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})

        $.ajax({
            url:BASEURL+'/updatesupplier',
            type:'POST',
            data: data_save,
            success: function(data){
                var supplier = $('#supplier-list').DataTable();
                supplier.ajax.reload(null, false );

                $('#addToCartModal').modal('hide');

                swal({
                    title: "",
                    text: "Supplier updated successfully",
                    type:"success"
                })
            }
        });
    });
}

function  deletedItem(id) {
    var BASEURL = $('#baseURL').val();
    swal.queue([{
        title: 'Are you sure',
        text: "You want to delete this supplier.",
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
                        type: 3,
                        id: id
                    },
                    success: function(data){
                        var supplier = $('#supplier-list').DataTable();
                        supplier.ajax.reload(null,false);

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
    var supplier = $('#supplier-list').DataTable();
    supplier.ajax.reload();
};