
<style>




    h1{
        text-align:  center;
        padding-bottom: 20px;
    }
    table{
        border: 1px solid;

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

    .date-sales{
        padding-bottom: 30px;
    }

    .table-computation{
        padding: 10px;

    }


    a.page.current{
        z-index: 3;
        color: #fff;
        cursor: default;
        background-color: #337ab7;
        border-color: #337ab7;
    }

    .easyPaginateNav{
        text-align: right;
        padding: 20px 20px;
        width: 100% !important;
    }
    a.page,a.first,a.prev,a.next,a.last {
        padding: 8px 12px;
        background-color: #fff;
        border: 1px solid #ddd;
        /* margin: 1px; */

        color: #337ab7;
    }

    a.prev{
        margin-left: 0;
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    a.next{
        margin-right: 0;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }

    a.last,a.first{
        margin-right: 0;

        display: none;
    }

</style>
<row>
    <div class="col-md-12">
        <a id="back"><h3><span> << Back </span></h3></a>
    </div>
    <div class="col-md-12">
        <h1>{{ \App\Branches::find($branch)->name }} - {{date('F', mktime(0, 0, 0, $month, 1))}} {{$year}}  Sales</h1>
    </div>
</row>
<input type="hidden" id="user_type" value="{{ Auth::user()->user_type }}">
<input type="hidden" id="branch_id" value="{{ $branch }}">
<div class="row" id="paginate">
    @for($i = 1; $i<=$end_date;$i++)
        <?php
            $str = $i.'-'.$month.'-'.$year;
            $date = date('Y-m-d', strtotime($str));
            $_date = date('F', mktime(0, 0, 0, $month, 1)). ' '.$i.' ,'.$year;
            $datas =\Illuminate\Support\Facades\DB::table('month_sales')->where('branch_id',$branch)->where('_date',$date)->first();


            $with_receipt_total = 0;
            $without_receipt_total = 0;
            $credit_total = 0;
            $expense_total = 0;
            if($datas != null){

                $data = json_decode($datas->data,TRUE);

                if($data['with_receipt'] != null){
                    foreach (json_decode($datas->data,TRUE)['with_receipt']  as $key =>$val){
                        $with_receipt_total = $with_receipt_total + ($val['rec_amount'] == '' ? 0 : $val['rec_amount']);
                    }
                }


                if($data['without_receipt'] != null){
                    foreach (json_decode($datas->data,TRUE)['without_receipt']  as $key =>$val){
                        $without_receipt_total = $without_receipt_total + ($val['amount'] == '' ? 0 : $val['amount']);
                    }
                }


                if($data['credit'] != null){
                    foreach (json_decode($datas->data,TRUE)['credit']  as $key =>$val){
                        $credit_total = $credit_total + ($val['amount'] == '' ? 0 : $val['amount']);
                    }
                }



                if($data['expense'] != null){
                    foreach (json_decode($datas->data,TRUE)['expense']  as $key =>$val){
                        $expense_total = $expense_total + ($val['amount'] == '' ? 0 : $val['amount']);
                    }
                }


                //total



                //cash computation

                $thousand = 0;
                $fivehundred = 0;
                $hundred = 0;
                $fifty = 0;
                $twenty = 0;
                $coins = 0;
                if($data['amount_1000'] != null){
                    $thousand = ($data['amount_1000'] == '' ? 0 : $data['amount_1000']);

                }
                if($data['amount_500'] != null){
                    $fivehundred = ($data['amount_500'] == '' ? 0 : $data['amount_500']);
                }

                if($data['amount_100'] != null){
                    $hundred = ($data['amount_100'] == '' ? 0 : $data['amount_100']);
                }

                if($data['amount_50'] != null){
                    $fifty = ($data['amount_50'] == '' ? 0 : $data['amount_50']);
                }

                if($data['amount_20'] != null){
                    $twenty = ($data['amount_20'] == '' ? 0 : $data['amount_20']);
                }
                if($data['amount_coins'] != null){
                    $coins = ($data['amount_coins'] == '' ? 0 : $data['amount_coins']);
                }

                $cash_total = ($thousand * 1000) + ($fivehundred * 500) + ($hundred * 100) + ($fifty * 50) + ($twenty * 20) + $coins;
                $_total = $with_receipt_total + $without_receipt_total + $credit_total + $expense_total;


                $excess = 0;
                if($_total < $cash_total){
                    $excess = $cash_total - $_total;
                }else{
                    $excess =0;
                }

                $loss = 0;
                if($_total > $cash_total){
                    $loss = $cash_total - $_total;
                }else{
                    $loss =0;
                }

            }

        ?>
        <div class="col-md-6 date-sales">

            <div>
                <div class="col-md-8">
                    <h4>{{date('F', mktime(0, 0, 0, $month, 1))}} {{$i}}, {{$year}} </h4>

                </div>
                <div class="col-md-4 text-right">
                    <button class="btn btn-warning" id="edit-modal" data-data="{{ ($datas != '') ? $datas->data :'' }}" data-_date="{{$_date}}" data-year="{{ $year }}" data-month="{{ $month }}" data-day="{{ $i }}"
                    >Edit</button>
                    <button class="btn btn-primary">View</button>
                </div>

            </div>
            <div class="col-md-12 table-computation">
                <table width="100%" >

                    <tbody>
                    <tr >
                        <td>WITH RECEIPT</td>
                        <td>{{ 'P '.number_format($with_receipt_total,2) }} (+)</td>
                    </tr>
                    <tr>
                        <td>WITHOUT RECEIPT</td>
                        <td>{{ 'P '.number_format($without_receipt_total,2) }} (+)</td>
                    </tr>
                    <tr>
                        <td>CREDIT COLLECTION</td>
                        <td>{{ 'P '.number_format($credit_total,2) }} (+)</td>
                    </tr>
                    <tr>
                        <td>EXPENSES</td>
                        <td>{{ 'P '.number_format($expense_total,2) }} (-)</td>
                    </tr>
                    <tr>
                        <td>TOTAL</td>
                        <td><b>{{'P '.number_format($_total,2)  }}</b></td>
                    </tr>
                    <tr>
                        <td>CASH COMPUTATION</td>
                        <td>{{ 'P '.number_format($cash_total,2) }}</td>
                    </tr>
                    <tr>
                        <td>EXCESS</td>
                        <td>
                            @if($excess == 0)
                                {{ 'P '.number_format($excess,2) }}
                            @else
                                <b>{{ 'P '.number_format($excess,2) }}</b>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>LOSS</td>
                        <td>
                            @if($loss == 0)
                                {{ 'P '.number_format($loss,2) }}
                            @else
                                <b style="color: red">{{ 'P '.number_format($loss,2) }}</b>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>TOTAL BALANCE</td>
                        <td>100</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    @endfor
</div>
@include('modal.sales.editsale')
<script>
    $(document).ready(function () {

        $('#paginate').easyPaginate({
            paginateElement: 'div.date-sales',
            elementsPerPage: 6,
        });


        $('body').on('click','#edit-modal',function () {

            $('#daily-edit-sale')[0].reset()
            var _date = $(this).data('year') +'-'+$(this).data('month')+'-'+$(this).data('day')
            $('#_date').text($(this).data('_date'))




            parseData($(this).data('data'))


            $('#edit-day-modal').modal('show')

            $("#steps").steps().destroy





        })


        $('#back').on('click',function () {
            if($('#user_type').val() == 1){
                window.location = BASEURL + '/admin/branch/' + $('#branch_id').val()
            }else{
                window.location = BASEURL + '/user/sales'
            }
        })

    });

    function saveDaily(day) {
        var BASEURL = $('#baseURL').val();

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
                    var data_save = $('#daily-edit-sale').serializeArray();
                    data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})
                    data_save.push({ name : "_date", value: day })
                    data_save.push({ name : "branch_id", value: $('#branch_id').val() })
                    $.ajax({
                        url:BASEURL+"/user/editsale",
                        type:'POST',
                        data: data_save,
                        success: function(data){
                            swal.insertQueueStep(data)
                            resolve()
                            $('#edit-day-modal').modal('hide')
                            location.reload()
                        }
                    });
                })
            }
        }])
    }



    function parseData(json){

        if(json != ''){
            $.each(json,function (name,value) {
                $('[name="'+name+'"]').val(value)
            })

            if(json['with_receipt'] != null){
                $('#step1').find('.margin_top').remove()
            }
            $.each(json['with_receipt'],function (index,value){
                $('[name="with_receipt[][rec_no]"]').eq(index).val(value)
                $('#step1').append('<div class="row margin_top">' +
                    '<div class="col-md-1 ">' +
                    '<div class="number-ctr">'+ (index + 1) +'.</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<input type="text" class="form-control" name="with_receipt['+ index + '][rec_no]" placeholder="Receipt no." value="'+ value['rec_no'] +'"></div>' +
                    '<div class="col-md-5">' +
                    '<input type="text" class="form-control" name="with_receipt['+ index +'][rec_amount]" placeholder="Amount" value="' + value['rec_amount'] +'"></div>' +
                    '</div>');
            })

            if(json['without_receipt'] != null){
                $('#step2').find('.margin_top').remove()
            }
            $.each(json['without_receipt'],function (index,value){

                $('#step2').append('<div class="row margin_top">' +
                    '<div class="col-md-1">' +
                    '<div class="number-ctr">'+ (index + 1) +'.</div></div>' +
                    '<div class="col-md-11">' +
                    '<input type="text" class="form-control" name="without_receipt['+ index+'][amount]" placeholder="Amount" value="'+ value['amount'] +'"></div>' +
                    '</div>')


            })

            if(json['credit'] != null){
                $('#step3').find('.margin_top').remove()
            }
            $.each(json['credit'],function (index,value){
                $('#step3').append('<div class="row margin_top">' +
                    '<div class="col-md-1">' +
                    '<div class="number-ctr">' + ( index + 1) +'.</div></div>' +
                    '<div class="col-md-4"><input type="text" class="form-control" name="credit['+ index +'][company]" placeholder="Company" value="'+ value['company'] +'"></div>' +
                    '<div class="col-md-4"><input type="text" class="form-control" name="credit['+ index +'][bank]" placeholder="Bank Number" value="'+ value['bank'] +'"></div>' +
                    '<div class="col-md-3"><input type="text" class="form-control" name="credit['+ index +'][amount]" placeholder="Amount" value="'+ value['amount'] +'"></div>' +
                    '</div>')
            })

            if(json['expense'] != null){
                $('#step4').find('.margin_top').remove()
            }
            $.each(json['expense'],function (index,value){

                $('#step4').append('<div class="row margin_top">' +
                    '<div class="col-md-1 "><div class="number-ctr">' + ( index + 1) +'.</div></div>' +
                    '<div class="col-md-6"><input type="text" class="form-control" name="expense['+ index+'][details]" placeholder="Details" value="'+ value['details'] +'"></div>' +
                    '<div class="col-md-5"><input type="text" class="form-control" name="expense['+ index +'][amount]" placeholder="Amount" value="' + value['amount'] +'"></div>' +
                    '</div>')

            })

            if(json['taken'] != null){
                $('#step6').find('.margin_top').remove()
            }
            $.each(json['taken'],function (index,value){

                $('#step6').append('<div class="row margin_top">' +
                    '<div class="col-md-1"><div class="number-ctr">'+ (index + 1) +'.</div></div>' +
                    '<div class="col-md-6"><input type="text" class="form-control" name="taken['+ index +'][name]" placeholder="Name" value="'+ value['name'] +'"></div>' +
                    '<div class="col-md-5"><input type="text" class="form-control" name="taken['+ index +'][amount]" placeholder="Amount" value="'+ value['amount'] +'"></div>' +
                    '</div>')

            })
        }else {

            $('#step1').find('.margin_top').remove()
            $('#step1').append('<div class="row margin_top">' +
                '<div class="col-md-1 ">' +
                '<div class="number-ctr">1.</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<input type="text" class="form-control" name="with_receipt[0][rec_no]" placeholder="Receipt no." value=""></div>' +
                '<div class="col-md-5">' +
                '<input type="text" class="form-control" name="with_receipt[0][rec_amount]" placeholder="Amount" value=""></div>' +
                '</div>');


            $('#step2').find('.margin_top').remove()
            $('#step2').append('<div class="row margin_top">' +
                '<div class="col-md-1">' +
                '<div class="number-ctr">1.</div></div>' +
                '<div class="col-md-11">' +
                '<input type="text" class="form-control" name="without_receipt[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')


            $('#step3').find('.margin_top').remove()
            $('#step3').append('<div class="row margin_top">' +
                '<div class="col-md-1">' +
                '<div class="number-ctr">1.</div></div>' +
                '<div class="col-md-4"><input type="text" class="form-control" name="credit[0][company]" placeholder="Company" value=""></div>' +
                '<div class="col-md-4"><input type="text" class="form-control" name="credit[0][bank]" placeholder="Bank Number" value=""></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="credit[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')


            $('#step4').find('.margin_top').remove()
            $('#step4').append('<div class="row margin_top">' +
                '<div class="col-md-1 "><div class="number-ctr">1.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="expense[0][details]" placeholder="Details" value=""></div>' +
                '<div class="col-md-5"><input type="text" class="form-control" name="expense[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')


            $('#step6').find('.margin_top').remove()
            $('#step6').append('<div class="row margin_top">' +
                '<div class="col-md-1"><div class="number-ctr">1.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="taken[0][name]" placeholder="Name" value=""></div>' +
                '<div class="col-md-5"><input type="text" class="form-control" name="taken[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')

        }

    }

</script>
