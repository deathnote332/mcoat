<div class="card-container">
    <div class="container-fluid">
        <div class="row pad_top_20">
            <div class="col-md-6">
                <div class="range-selection table-search-input">
                    <select id="range" class="form-control">
                        <option selected value="today">Today</option>
                        <option  value="week">Week</option>
                        <option  value="month">Month</option>
                        <option value="all">All</option>
                    </select>
                </div>

            </div>
            <div class="col-md-4 col-md-offset-2 table-search-input">
                <input type="text" id="search" name="search" class="form-control" placeholder="Search..">
            </div>
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
            var receipt = $('#receiptin-list').DataTable();
            receipt.search(this.value).draw();
        })

        $('#range').on('change',function () {
            loadReceipts($(this).val())
        })



    });

    function loadReceipts(range) {
        var _range = (range == null) ? 'today' : range
        var BASEURL = $('#baseURL').val();
        var receipt = $('#receiptin-list').DataTable({
            ajax: {
                url: BASEURL + '/getRecieptsIn',
                type: "POST",
                data:{
                    _range: _range,
                    _token: $('meta[name="csrf_token"]').attr('content'),
                }
            },
            order: [],
            destroy: true,
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