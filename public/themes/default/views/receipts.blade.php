<style>

    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    tr td:nth-child(4){
        text-transform: capitalize;
    }
    .card-container{
        padding-top: 30px;
    }

    #receipt-list_wrapper .row:nth-child(1){
        display: none;
    }

    #receipt-list_wrapper tbody tr td:nth-child(6){
        text-align: center;
    }
    .range-selection{

        margin-left: 15px;
       margin-bottom: 20px;
    }
    #add-to-cart{
        cursor: pointer;
    }

    .modal{
        position: absolute;
        top: 15%;

    }
    label#view-receipt,label#edit-receipt,label#delete-receipt {
        margin: 0;
        padding: 5px 20px;
    }
    .alert-success,.alert-warning{
        background-color: #3c763d;
        margin-right: 10px !important;
    }
    .alert-warning{
        background-color: #8a6d3b;
    }
    .alert-danger{
        background-color: #a94442;
    }

    .alert-warning,.alert-success,.alert-danger{
        color:white;
        cursor: pointer;

    }
</style>

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
            deleteReceipt($(this).data('id'))
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
                columns: [

                    { data: 'receipt_no',"orderable": false },
                    { data: 'delivered_to',"orderable": false},
                    { data: 'total',"orderable": false },
                    { data: 'created_by',"orderable": false },
                    { data: 'created_at',"orderable": false },
                    { data: 'action',"orderable": false }

                ]
            });
        }

        function deleteReceipt(invoice) {

            swal.queue([{
                title: 'Are you sure',
                confirmButtonText: 'Show my public IP',
                text:
                'You want to delete this receipt',
                type:'warning',

                showLoaderOnConfirm: true,
                closeOnConfirm: false,
                confirmButtonText: 'Okay',
                confirmButtonColor: "#DD6B55",
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.get('https://api.ipify.org?format=json')
                            .done(function (data) {
                                swal.insertQueueStep(data.ip)
                                resolve()
                            })
                    })
                }
            }])

//            swal({
//                title: "Are you sure?",
//                text: "You want to delete this receipt.</br>HEllo",
//                type: "warning",
//                showCancelButton: true,
//                confirmButtonColor: "#DD6B55",
//                confirmButtonText: 'Okay',
//                closeOnConfirm: false
//            }).then(function () {
//
//                $.ajax({
//                    url:BASEURL+'/updateProduct',
//                    type:'POST',
//                    data:{
//                        _range: invoice,
//                        _token: $('meta[name="csrf_token"]').attr('content'),
//                    },
//                    success: function(data){
//
//                        swal({
//                            title: "",
//                            text: "Product updated successfully",
//                            type:"success"
//                        }).then(function () {
//                            $("#update-products")[0].reset()
//                        });
//                    }
//                });
//            });
        }


    });



    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var receipt = $('#receipt-list').DataTable();
        receipt.ajax.reload();
    };

</script>