$(document).ready(function () {
    var BASEURL = $('#baseURL').val();
    var branch = $('#branch-list').DataTable({
        ajax: BASEURL + '/getbranches',
        order: [],
        iDisplayLength: 12,
        bLengthChange: false,
        bDeferRender: true,
        columns: [

            { data: 'name',"orderable": false },
            { data: 'address',"orderable": false},
            { data: 'created_at',"orderable": false },
            { data: 'action',"orderable": false },


        ]
    });


    $('body').on('click','#update',function () {
        $('#addToCartModal .modal-title').text('Update')
        $('#addToCartModal').modal('show')
        $('#btn-update').text('Update')
        $('#name').val($(this).data('name'))
        $('#address').val($(this).data('address'))
        $('#supplier_id').val($(this).data('id'))
    })

    $('body').on('click','#delete',function () {
        deletedItem($(this).data('id'))
    });

    $('#btn-update').on('click',function () {
        if($(this).text() == 'Add'){
            addNew()
        }else{
            addToCart()
        }

    })

    $('#search').on('input',function () {

        branch.search(this.value).draw();
    })

    $('.add-new').on('click',function () {
        $('#addToCartModal .modal-title').text('Add new branch')
        $('#addToCartModal').modal('show')
        $('#btn-update').text('Add')
        $('#name').val('')
        $('#address').val('')
    })
});
function addToCart() {
    var BASEURL = $('#baseURL').val();
    swal({
        title: "Are you sure?",
        text: "You want to update this branch.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: 'Okay',
        closeOnConfirm: false
    }).then(function () {
        var data_save = $('#branch').serializeArray();
        data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})

        $.ajax({
            url:BASEURL+'/updatebranch',
            type:'POST',
            data: data_save,
            success: function(data){
                var branch = $('#branch-list').DataTable();
                branch.ajax.reload(null, false );

                $('#addToCartModal').modal('hide');

                swal({
                    title: "",
                    text: "Branch updated successfully",
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
        text: "You want to delete this branch.",
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
                        type: 2,
                        id: id
                    },
                    success: function(data){
                        var branch = $('#branch-list').DataTable();
                        branch.ajax.reload(null,false);

                        swal.insertQueueStep('Branch deleted successfully')
                        resolve()
                    }
                });
            })
        }
    }])


}

function addNew() {
    var BASEURL = $('#baseURL').val();
    swal({
        title: "Are you sure?",
        text: "You want to add this branch.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: 'Okay',
        closeOnConfirm: false
    }).then(function () {
        var data_save = $('#branch').serializeArray();
        data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})

        $.ajax({
            url:BASEURL+'/addbranch',
            type:'POST',
            data: data_save,
            success: function(data){
                var branch = $('#branch-list').DataTable();
                branch.ajax.reload(null, false );

                $('#addToCartModal').modal('hide');

                swal({
                    title: "",
                    text: "Branch added successfully",
                    type:"success"
                })
            }
        });
    });

}

//New error event handling has been added in Datatables v1.10.5
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.log(message);
    var branch = $('#branch-list').DataTable();
    branch.ajax.reload();
};