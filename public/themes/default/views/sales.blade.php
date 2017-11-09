<style>
    .huge{
        font-size: 20px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Branch Sales and Inventory</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="card-container">
    <div class="row">
        @foreach(\Illuminate\Support\Facades\DB::table('branches')->get() as $key=>$val)
        <div class="col-lg-4 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-calculator fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$val->name}}</div>
                            <div>₱ 0.00</div>
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
        @endforeach
    </div>
</div>
