{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}
<style>
    table{
        border: 1px solid;
        margin-bottom: 40px;

    }

    table tbody{
        padding: 15px;
        margin: 10px;
    }
    table tbody tr td{
        padding: 10px;
    }

    table tbody tr td:first-child{
        font-weight: 600;
        border-bottom: 1px dashed red;
    }
    table tbody tr td:nth-child(2){
        text-align: center;
    }


    h3{
        margin: 10px 0;
    }

    .col-md-6{
        padding: 0;
    }

    .page-header{
        font-size: 32px !important;
        font-weight: 600;
        margin-bottom: 20px !important;
    }

</style>
<div class="row">
    <div class="col-md-12">
        <a id="back"><h3><span> << Back </span></h3></a>
    </div>
    <div class="col-lg-12 text-center">
        <h1 class="page-header">{{ $branch->name }} <span class="year">2018</span> </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="card-container">

    <div class="row">
        @for($i=1;$i<= date('m') ;$i++)
            <div class="col-md-4 table-computation">
                <div class="col-md-6">
                    <h3>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</h3>
                </div>

                <div class="col-md-6 text-right">
                    <button type="button" class="btn btn-primary view-details" data-month="{{ $i }}" data-branch="{{ $branch->id }}">View all</button>
                </div>

                <table width="100%" >
                    <tbody>
                    <tr >
                        <td>WITH RECEIPT</td>
                        <td>{{ 'P '.number_format(1000000,2) }} (+)</td>
                    </tr>
                    <tr>
                        <td>WITHOUT RECEIPT</td>
                        <td>{{ 'P '.number_format(0,2) }} (+)</td>
                    </tr>
                    <tr>
                        <td>CREDIT COLLECTION</td>
                        <td>{{ 'P '.number_format(0,2) }} (+)</td>
                    </tr>
                    <tr>
                        <td>EXPENSES</td>
                        <td>{{ 'P '.number_format(0,2) }} (-)</td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td>{{ 'P '.number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>CASH COMPUTATION</td>
                        <td>{{ 'P '.number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>EXCESS</td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>LOSS</td>
                        <td>

                        </td>
                    </tr>

                    </tbody>

                </table>
            </div>
        @endfor
    </div>
</div>

<script>

    var BASEURL = $('#baseURL').val();

    $(document).ready(function () {

        $('body').delegate('#back','click',function () {
            window.location = BASEURL + '/admin/branchsales'
        })

        $('body').delegate('.view-details','click',function () {


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
    });d
</script>