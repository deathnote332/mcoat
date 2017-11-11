{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Warehouse Inventory</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

@if(\Illuminate\Support\Facades\Auth::user()->user_type == 1)
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
            <a href={{ URL('mcoat') }}>
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
            <a href={{ URL('allied') }}>
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
    <div class="col-lg-12">
        <h1 class="page-header">Notifications</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel ">

            <div class="panel-body">
                <div class="row">
                    <table id="notification-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr>

                            <th>Action</th>
                            <th>Date</th>

                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
            <a href={{ URL('allied') }}>
                <div class="panel-footer noti-footer">
                    <span class="pull-left">View All</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>


</div>
@endif
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
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var notification = $('#notification-list').DataTable();
        notification.ajax.reload();
    };

</script>