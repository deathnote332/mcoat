<div class="page-wrapper">
    @if(\Illuminate\Support\Facades\Auth::user()->user_type == 1)
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Warehouse Inventory</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-calculator fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{'₱ '.number_format( \App\Product::select(DB::raw('sum(quantity * unit_price) as total'))->first()->total, 2) }}</div>
                                <div>Total Mcoat Inventory</div>
                            </div>
                        </div>
                    </div>
                    <a href={{ URL('/admin/mcoat') }}>
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-calculator fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">{{'₱ '.number_format( \App\Product::select(DB::raw('sum(quantity_1 * unit_price) as total'))->first()->total, 2) }}</div>
                                <div>Total Dagupan Inventory</div>
                            </div>
                        </div>
                    </div>
                    <a href={{ URL('/admin/allied') }}>
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="row">

            @if(\App\Productout::where(DB::raw('MONTH(created_at)'),DB::raw('MONTH(NOW())'))->where('status',1)->count() != 0)
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            BRANCH ORDER GRAPH FOR THE MONTH OF <span class="date">{{ date('M') }}</span>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="morris-bar-chart"></div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

            @else
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading total-count">
                            BRANCH ORDER GRAPH FOR THE MONTH {{ date('M') }} TOTAL: <span> {{ \App\Productout::where(DB::raw('MONTH(created_at)'),DB::raw('MONTH(NOW())'))->where('status',1)->count() }}</span>
                        </div>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6 col-sm-6">
                    <h1 class="page-header pull-left">Notifications</h1>

                </div>
                <div class="col-md-6 col-sm-6">
                    <a href={{ URL('/admin/activity') }}><h1 class="header-view-all pull-right">View All >>></h1></a>

                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="row">
                    <table id="notification-list" class="table table-bordered dt-responsive" cellspacing="0" width="100%">
                        <thead>
                        <tr>

                            <th>Action</th>
                            <th class="width_20">Date</th>

                        </tr>
                        </thead>

                    </table>
                </div>


            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Sale Today <b>({{ date('M d, Y') }})</b></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <form id="daily-sale">
            <div class="row">
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Receipt no.</label>
                                <input  type="text" class="form-control" id="receipt_no" name="receipt_no"  value="{{ ($data != '') ? $data['receipt_no'] :'' }}"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Total Amount</label>
                                <input  type="text" class="form-control" id="amount" name="total_amount"  value="{{ ($data != '') ? $data['total_amount'] :'' }}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Deposit Amount.</label>
                                <input  type="text" class="form-control" id="deposit_amount" name="deposit_amount"  value="{{ ($data != '') ? $data['deposit_amount'] :'' }}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Taken Amount.</label>
                                <input  type="text" class="form-control" id="taken_amount" name="taken_amount" value="{{ ($data != '') ? $data['taken_amount'] :'' }}"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Expenses Amount.</label>
                                <input  type="text" class="form-control" id="expenses_amount" name="expenses_amount" value="{{ ($data != '') ? $data['expenses_amount'] :'' }}"/>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Expenses Description</label>
                                <input  type="text" class="form-control" id="expenses_description" name="expenses_description" value="{{ ($data != '') ? $data['expenses_description'] :'' }}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row btn-save">
                <div class="col-md-3 col-lg-offset-9">
                    <button type="button" class="btn btn-primary form-control" id="save-daily">{{ ($data != '') ? 'Update' :'Save' }}</button>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6 for-user">
                    <span>Requestig</span><input type="text " class="form-control"/>
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control"/>
                </div>

            </div>
        </form>
    @endif
</div>

<script>
    var BASEURL = $('#baseURL').val();

    $(document).ready(function () {

        var notification = $('#notification-list').DataTable({
            ajax: BASEURL + '/admin/notifications/5',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            bFilter:false,
            bInfo: false,
            bPaginate:false,
            deferRender: true,
            columns: [

                { data: 'message',"orderable": false },
                { data: 'created_at',"orderable": false},

            ],

        });

        $('#save-daily').on('click',function () {
            saveDaily()
        })

        var chart = Morris.Bar({
            element: 'morris-bar-chart',
            data:[0,0],
            xkey: ['label'],
            ykeys: ['value'],
            ymax: 100,
            labels: ['Order Percentage'],
            hideHover: 'auto',
            resize: true
        });

        $.ajax({
            url:BASEURL + '/admin/fastMovingProducts',
            type: 'GET',
            success: function (data){

                chart.setData(data);
            }
        });



    })


    function saveDaily() {

        swal.queue([{
            title: 'Are you sure',
            text: "You want to save this record.",
            type:'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnConfirm: false,
            confirmButtonText: 'Okay',
            confirmButtonColor: "#DD6B55",
            preConfirm: function () {
                return new Promise(function (resolve) {
                    var data_save = $('#daily-sale').serializeArray();
                    data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})
                    $.ajax({
                        url:BASEURL+'/dailysale',
                        type:'POST',
                        data: data_save,
                        success: function(data){
                            swal.insertQueueStep(data)
                            resolve()
                        }
                    });
                })
            }
        }])

    }

    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var notification = $('#notification-list').DataTable();
        notification.ajax.reload();
    };

</script>