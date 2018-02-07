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

    #year-next-prev div{
        display: inline-block;
    }
    #previous-month,#next-month{
        cursor: pointer;
        font-size: 18px;
        padding: 10px 20px;
        color: #286090;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <a id="back"><h3><span> << Back </span></h3></a>
    </div>


    <div class="col-lg-12 text-center" id="year-next-prev">
        <div id="previous-month"> <i class="fa fa-angle-double-left"></i> PREVIOUS </div>
        <div><h1 class="page-header">{{ $branch->name }} <span class="year">2018</span> </h1></div>
        <div id="next-month"> NEXT <i class="fa fa-angle-double-right"></i>  </div>
        <input  type="hidden" id="branch" value=" {{ $branch->id }}" />
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="card-container">
    <div class="row">
    </div>
<script>

    var BASEURL = $('#baseURL').val();

    $(document).ready(function () {

        loadMonths()

        var current_date = $('.year').text();
        var now = new Date(current_date);

        var date_now = new Date()


        $('#previous-month').click(function(){

            if($('.year').text() > 2014){
                var past = now.setFullYear(now.getFullYear() -1);
                $('.year').text(now.getFullYear());
                loadMonths()
            }
        });


        $('#next-month').click(function(){
            if(($('.year').text() < date_now.getFullYear()) ){
                var future = now.setFullYear(now.getFullYear() +1);
                $('.year').text(now.getFullYear());

                loadMonths()
            }

        });


        $('body').delegate('#back','click',function () {
            window.location = BASEURL + '/admin/branchsales'
        })

        $('body').delegate('.view-details','click',function () {

            window.location = '/admin/sales/'+ $(this).data('branch') +'/'+$(this).data('month') +'/'+$('.year').text()
        })


        function  loadMonths() {
            $.ajax({
                url:BASEURL+'/admin/ajaxsale',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    branch: $('#branch').val(),
                    year: $('.year').text(),
                },
                success: function(data){
                    $('.card-container .row').html(data)
                }
            });



        }
        


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