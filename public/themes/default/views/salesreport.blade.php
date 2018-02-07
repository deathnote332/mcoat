<style>
    .card{
        box-shadow: 1px 2px 2px 2px  #eee;;
        padding: 20px;
        margin-bottom: 20px;
    }
    .year-container{
        display: block;
    }
    .year-container div{
        display: inline-block;
    }
</style>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="year-container">
                <div class="previous">
                    <<
                </div>
                    <div><h1> Sales of {{ \App\Branches::find(Auth::user()->branch_id)->name }} <span class="year">2018</span> </h1></div>
                <div class="next">
                    >>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        @for($i=1;$i<=12;$i++)
            <div class="col-lg-4 col-md-4">
                <div class="panel panel-primary" data-id="{{ $i }}">
                    <div class="panel-heading">
                        <div class="row">


                            <?php
                            $total = 0;
                            $bank_depo = 0;
                            $taken = 0;
                            $expense = 0;

                            $total_sales = \App\MonthSales::where('branch_id',\App\Branches::find(Auth::user()->branch_id)->id)->where(DB::raw('MONTH(_date)'),$i)->where(DB::raw('YEAR(_date)'),2018)->get();

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
                    <a class="view-details" data-month="{{ $i }}" data-branch="{{ \App\Branches::find(Auth::user()->branch_id)->id }}">
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
    $(document).ready(function () {
        $('.view-details').on('click',function () {
            window.location = '/user/sales/'+ $(this).data('branch') +'/'+ $(this).data('month') +'/'+$('.year').text()
        })




    })

</script>