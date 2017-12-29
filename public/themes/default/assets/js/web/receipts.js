$('document').ready(function(){
    var BASEURL = $('#baseURL').val();
    loadReceipts()

    $('#search').on('input',function () {
        var receipt = $('#receipt-list').DataTable();
        receipt.search(this.value).draw();
    })

    $('#range').on('change',function () {
        loadReceipts($(this).val())
    })

    $('body').delegate('#delete-receipt','click',function () {
        deleteReceipt($(this).data('id'),$(this).data('receipt'),$(this).data('type'))
    })

    $('body').delegate('#edit-receipt','click',function () {
        var rec_no  = $(this).data('receipt');
        //editReceipt/$data->receipt_no
        editReceipt(rec_no)

    })

    function loadReceipts(range) {

        var _range = (range == null) ? 'today' : range

        var BASEURL = $('#baseURL').val();
        var receipt = $('#receipt-list').DataTable({
            ajax: {
                url: BASEURL + '/getReciepts',
                type: "POST",
                data:{
                    _range: _range,
                    _token: $('meta[name="csrf_token"]').attr('content'),
                }
            },
            destroy: true,
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            bDeferRender: true,
            columns: [

                { data: 'receipt_no',"orderable": false },
                { data: 'delivered_to',"orderable": false},
                { data: 'total',"orderable": false },
                { data: 'created_by',"orderable": false },
                { data: 'created_at',"orderable": false },
                { data: 'action',"orderable": false }

            ],
            "createdRow": function ( row, data, index ) {




            }
        });
    }

    function editReceipt(rec_no) {
        var BASEURL = $('#baseURL').val();
        swal.queue([{
            title: 'Are you sure',
            html: "You want to edit this receipt." ,
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
                        url:BASEURL+'/ajaxSaveToTemp',
                        type:'POST',
                        data: {
                            _token: $('meta[name="csrf_token"]').attr('content'),
                            receipt_no:rec_no
                        },
                        success: function(data){

                            window.open(BASEURL+'/editReceipt/'+rec_no);
                            resolve()
                        }
                    });


                })
            }
        }])
    }


    function deleteReceipt(id,rec,type) {
        var BASEURL = $('#baseURL').val();
        swal.queue([{
            title: 'Are you sure',
            html: "You want to delete this receipt. <br><span class='note'> ***All the product quantity containing in receipt <br>"+ rec +"  will be back.</span>" ,
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
                            type: 4,
                            id: id,
                            rec_no:rec,
                            warehouse:type
                        },
                        success: function(data){
                            var receipt = $('#receipt-list').DataTable();
                            receipt.ajax.reload(null,false);

                            swal.insertQueueStep('Receipt deleted successfully')
                            resolve()
                        }
                    });
                })
            }
        }])
    }

});

//New error event handling has been added in Datatables v1.10.5
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.log(message);
    var receipt = $('#receipt-list').DataTable();
    receipt.ajax.reload();
};