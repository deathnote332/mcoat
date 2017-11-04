{!! Theme::asset()->usePath()->add('receipts','/css/web/receipts.css') !!}
<div class="card-container">
    <div class="row">
        <div class="col-md-3">
            <div class="range-selection">
                <select id="range" class="form-control">
                    <option selected value="today">Today</option>
                    <option  value="week">Week</option>
                    <option  value="month">Month</option>
                    <option value="all">All</option>
                </select>
            </div>

        </div>
        <div class="col-md-3">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search..">
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="receipt-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Receipt no.</th>
                    <th>Delivered to</th>
                    <th>Total</th>
                    <th>Created by</th>
                    <th>Date created</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>






<script>

    $('document').ready(function(){

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

</script>