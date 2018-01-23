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
                    <<<<
                </div>
                <div><h1> Sales of <span class="year">2018</span> </h1></div>
                <div class="next">
                    >>>>
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
                            <div class="col-md-12">
                                <h3>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</h3>
                                <div>Total Sales</div>
                                <div>Bank deposit</div>
                                <div>Taken</div>
                                <div>Expenses</div>
                            </div>
                        </div>
                    </div>
                    <a class="view-details" data-month="{{ $i }}" >
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
            window.location = '/user/sales/'+ $(this).data('month') +'/'+$('.year').text()
        })




    })

</script>