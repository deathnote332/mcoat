<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #receiptin-list_wrapper .row:nth-child(1){
        display: none;
    }

    #receiptin-list_wrapper tbody tr td:nth-child(5){
        text-align: center;
    }
    #search{

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
    label#view-receipt,label#edit-receipt {
        margin: 0;
        padding: 5px 20px;
    }
    .alert-success{
        background-color: #3c763d;
        margin-right: 10px !important;
    }
    .alert-warning{
        background-color: #8a6d3b;
    }

    .alert-warning,.alert-success{
        color:white;

    }
</style>

<div class="card-container">
    <div class="row">

        <div class="col-md-3">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search..">
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="receiptin-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th>Receipt no.</th>
                    <th>Delivered from</th>
                    <th>Warehouse</th>
                    <th>Updated by</th>
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




    });

    function loadReceipts() {
        var BASEURL = $('#baseURL').val();
        var receipt = $('#receiptin-list').DataTable({
            ajax: {
                url: BASEURL + '/getRecieptsIn',
                type: "POST",
                data:{
                    _token: $('meta[name="csrf_token"]').attr('content'),
                }
            },
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            columns: [

                { data: 'receipt_no',"orderable": false },
                { data: 'delivered_from',"orderable": false},
                { data: 'warehouse',"orderable": false},
                { data: 'created_by',"orderable": false },
                { data: 'created_at',"orderable": false },
                { data: 'action',"orderable": false }

            ]
        });
    }


    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var receiptin = $('#receiptin-list').DataTable();
        receiptin.ajax.reload();
    };

</script>