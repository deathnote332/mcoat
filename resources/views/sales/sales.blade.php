{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ $branch->name }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="card-container">
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-calculator fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">₱ 0.00</div>
                            <div>Total {{ $branch->name }} Inventory</div>
                        </div>
                    </div>
                </div>
                <a href={{ URL('mcoat') }}>
                    <div class="panel-footer">
                        <span class="pull-left">View Inventory</span>
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
                            <div class="huge">₱ 0.00</div>
                            <div>Sales for the month of {{ date('M') }}</div>
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
        <div class="col-lg-12">
            <h1 class="page-header">Sale for Today</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

        <table id="notification-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Product Details</th>
                <th>Amount</th>
            </tr>
            </thead>

        </table>


    </div>
</div>