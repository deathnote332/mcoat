<style>
    .huge {
        font-size: 20px !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

@if(\Illuminate\Support\Facades\Auth::user()->user_type == 1)
<!-- /.row -->
<div class="row">
    <div class="col-lg-4 col-md-6">
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
    <div class="col-lg-4 col-md-6">
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
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge">{{ \App\User::where('active','=',1)->count() }}</div>
                        <div>User Online</div>
                    </div>
                </div>
            </div>
            <a href="{{ url('users') }}">
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

    <!-- /.col-lg-6 -->
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                BRANCH ORDER GRAPH
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div id="morris-bar-chart"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.panel -->
</div>
    <!-- /.col-lg-6 -->

</div>
@endif
<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {
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
            url:BASEURL + '/fastMovingProducts',
            type: 'GET',
            success: function (data){

                chart.setData(data);
            }
        });


    })




</script>