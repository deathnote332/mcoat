{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}
<div class="row">
    <div class="col-md-12">
        <a id="back"><h3><span> << Back </span></h3></a>
    </div>
    <div class="col-lg-12">
        <h1 class="page-header">{{ $branch->name }} 2018</h1>
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
                            <div>Sales for the year of {{ date('M') }}</div>
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
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="year-container">
                <div><h1> Sales of  <span class="year">2018</span> </h1></div>
            </div>
        </div>
    </div>
    <div class="row">
        @for($i=1;$i<=12;$i++)
            <div class="col-lg-4 col-md-4">
                <div class="panel panel-primary" data-id="{{ $i }}" >
                    <div class="panel-heading">
                        <div class="row">

                            <?php
                            $total = 0;
                            $bank_depo = 0;
                            $taken = 0;
                            $expense = 0;

                            $total_sales = \App\MonthSales::where('branch_id',$branch->id)->where(DB::raw('MONTH(_date)'),$i)->where(DB::raw('YEAR(_date)'),2018)->get();

                            foreach ($total_sales as $key=>$data_val){
                                $total  = $total + json_decode($data_val->data,TRUE)['total_amount'];
                                $bank_depo  = $bank_depo + json_decode($data_val->data,TRUE)['deposit_amount'];
                                $taken  = $taken + json_decode($data_val->data,TRUE)['taken_amount'];
                                $expense  = $expense + json_decode($data_val->data,TRUE)['expenses_amount'];
                            }
                            ?>

                            <div class="col-md-12">
                                <h3>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</h3>
                               <table width="100%">
                                   <tbody>
                                        <tr>
                                            <td><div>Total Sales</div></td>

                                            <td>{{'P '.number_format($total,2)}}</td>
                                        </tr>
                                        <tr>
                                            <td><div>Total Bank Deposit</div></td>
                                            <td>{{'P '.number_format($bank_depo,2)}}</td>
                                        </tr>
                                        <tr>
                                            <td><div>Total Taken</div></td>
                                            <td>{{'P '.number_format($taken,2)}}</td>
                                        </tr>
                                        <tr>
                                            <td><div>Total Expenses</div></td>
                                            <td>{{'P '.number_format($expense,2)}}</td>
                                        </tr>
                                   </tbody>
                               </table>
                            </div>
                        </div>
                    </div>
                    <a class="view-details" data-month="{{ $i }}" data-branch="{{ $branch->id }}" >
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        @endfor
    </div>
</div>

<script>

    var BASEURL = $('#baseURL').val();

    $(document).ready(function () {

        $('#back').on('click',function () {
            window.location = BASEURL + '/admin/branchsales'
        })

        $('.view-details').on('click',function () {

            window.location = '/admin/sales/'+ $(this).data('branch') +'/'+$(this).data('month') +'/'+$('.year').text()
        })

        var sales = $('#sales-list').DataTable({
            ajax: BASEURL + '/monthlysale',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            bFilter:false,
            bInfo: false,
            bPaginate:false,
            deferRender: true,
            columns: [

                { data: 'day',"orderable": false },
                { data: 'receipt_no',"orderable": false},
                { data: 'total_amount',"orderable": false},
                { data: 'deposit_amount',"orderable": false},
                { data: 'taken_amount',"orderable": false},
                { data: 'expenses',"orderable": false},

            ],

        });
    });
</script>