
<style>


    h4{
        margin: 0;
        font-weight: 600;
        font-size: 14px;
    }

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
        <input type="hidden" id="branch" value="{{ \App\Branches::find($branch)->name }}">
        <input type="hidden" id="address" value="{{ \App\Branches::find($branch)->address }}">
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
            $_total = 0;
            $cash_total = 0;
            $excess = 0;
            $loss = 0;

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
                if($data['amount_1000'] != null || $data['amount_1000'] != ''){
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


                $_total = ($with_receipt_total + $without_receipt_total + $credit_total ) - $expense_total;

                $cash_total = ($thousand * 1000) + ($fivehundred * 500) + ($hundred * 100) + ($fifty * 50) + ($twenty * 20) + $coins;


                if($_total > $cash_total){
                    $loss = $cash_total - $_total;
                }else{

                    $excess = $cash_total- $_total ;
                }


            }

        ?>
        <div class="col-md-4 date-sales">

            <div>
                <div class="col-md-6">
                    <h4>{{date('F', mktime(0, 0, 0, $month, 1))}} {{$i}}, {{$year}} </h4>

                </div>
                <div class="col-md-6 text-right">
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
                        <td>{{ 'P '.number_format($_total,2) }}</td>
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
                                <b style="color: blue">{{ 'P '.number_format($excess,2) }}</b>
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
            elementsPerPage: 12,
        });


        $('body').on('click','#edit-modal',function () {

            $('#daily-edit-sale')[0].reset()
            var _date = $(this).data('year') +'-'+$(this).data('month')+'-'+$(this).data('day')
            $('#_date').text($(this).data('_date'))
            $('#_branch').text($('#branch').val())
            $('#_address').text($('#address').val())

            parseData($(this).data('data'))


            $('#edit-day-modal').modal('show')

            $("#steps").steps().destroy


        })


        $('#back').on('click',function () {
            var BASEURL = $('#baseURL').val();

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
            var w_total = 0

            $.each(json['with_receipt'],function (index,value){
                w_total = w_total + (value['rec_amount'] == '' ? 0 : parseFloat(value['rec_amount']))
                $('#step1').append('<div class="row margin_top">' +
                    '<div class="col-md-1 ">' +
                    '<div class="number-ctr">'+ (index + 1) +'.</div>' +
                    '</div>' +
                    '<div class="col-md-6">' +
                    '<input type="text" class="form-control" name="with_receipt['+ index + '][rec_no]" placeholder="Receipt no." value="'+ value['rec_no'] +'"></div>' +
                    '<div class="col-md-5">' +
                    '<input type="text" id="w-amount" class="form-control" name="with_receipt['+ index +'][rec_amount]" placeholder="Amount" value="' + value['rec_amount'] +'"></div>' +
                    '</div>');

                $('#step1').find('.total').text('P '+w_total)
            })
//            <div class="col-md-6 margin_bottom text-right">
//                <button type="button" class="btn btn-primary" id="add-w-rec">Add more</button>
//            </div>
            //adding plus to last child
            $('#step1 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-w-rec">Add more</button></div>')
//
//            //WITH REC TOTAL
            var w_total = 0
//            $.each($('#step1 div div:nth-child(3) input'),function (index,value){
//                w_total = w_total + parseInt(($(this).val() == '') ? 0 : $(this).val())
//                $('#step1').find('.total').text('P '+w_total)
//            })



            if(json['without_receipt'] != null){
                $('#step2').find('.margin_top').remove()
            }

            var wo_total = 0
            $.each(json['without_receipt'],function (index,value){

                wo_total = wo_total + (value['amount'] == '' ? 0 : parseFloat(value['amount']))
                $('#step2').append('<div class="row margin_top">' +
                    '<div class="col-md-1">' +
                    '<div class="number-ctr">'+ (index + 1) +'.</div></div>' +
                    '<div class="col-md-11">' +
                    '<input type="text" id="wo-amount" class="form-control" name="without_receipt['+ index+'][amount]" placeholder="Amount" value="'+ value['amount'] +'"></div>' +
                    '</div>')
                $('#step2').find('.total').text('P '+wo_total)


            })

            $('#step2 div.row.margin_top:last-child div:nth-child(2)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-wo-rec">Add more</button></div>')


            if(json['credit'] != null){
                $('#step3').find('.margin_top').remove()
            }
            var credit_total = 0
            $.each(json['credit'],function (index,value){
                credit_total = credit_total + (value['amount'] == '' ? 0 : parseFloat(value['amount']))

                $('#step3').append('<div class="row margin_top">' +
                    '<div class="col-md-1">' +
                    '<div class="number-ctr">' + ( index + 1) +'.</div></div>' +
                    '<div class="col-md-3"><input type="text" class="form-control" name="credit['+ index +'][company]" placeholder="Company" value="'+ value['company'] +'"></div>' +
                    '<div class="col-md-3"><input type="text" class="form-control" name="credit['+ index +'][bank_name]" placeholder="Bank Name" value="'+ value['bank_name'] +'"></div>' +
                    '<div class="col-md-3"><input type="text" class="form-control" name="credit['+ index +'][bank]" placeholder="Bank Number" value="'+ value['bank'] +'"></div>' +
                    '<div class="col-md-2"><input type="text" id="credit-amount" class="form-control" name="credit['+ index +'][amount]" placeholder="Amount" value="'+ value['amount'] +'"></div>' +
                    '</div>')
                $('#step3').find('.total').text('P '+credit_total)
            })
            $('#step3 div.row.margin_top:last-child div:nth-child(5)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-credit">Add more</button></div>')


            if(json['expense'] != null){
                $('#step4').find('.margin_top').remove()
            }
            var expense = 0

            $.each(json['expense'],function (index,value){
                expense = expense + (value['amount'] == '' ? 0 : parseFloat(value['amount']))

                $('#step4').append('<div class="row margin_top">' +
                    '<div class="col-md-1 "><div class="number-ctr">' + ( index + 1) +'.</div></div>' +
                    '<div class="col-md-6"><input type="text" class="form-control" name="expense['+ index+'][details]" placeholder="Details" value="'+ value['details'] +'"></div>' +
                    '<div class="col-md-5"><input type="text" id="expense-amount" class="form-control" name="expense['+ index +'][amount]" placeholder="Amount" value="' + value['amount'] +'"></div>' +
                    '</div>')
                $('#step4').find('.total').text('P '+expense)
            })
            $('#step4 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-expense">Add more</button></div>')


            if(json['return'] != null){
                $('#step5').find('.margin_top').remove()
            }
            var _return = 0
            $.each(json['return'],function (index,value){
                _return = _return + (value['amount'] == '' ? 0 : parseFloat(value['amount']))

                $('#step5').append('<div class="row margin_top">' +
                    '<div class="col-md-1 "><div class="number-ctr">' + ( index + 1) +'.</div></div>' +
                    '<div class="col-md-6"><input type="text" class="form-control" name="return['+ index+'][name]" placeholder="Name" value="'+ value['name'] +'"></div>' +
                    '<div class="col-md-5"><input type="text" id="return-amount" class="form-control" name="return['+ index +'][amount]" placeholder="Amount" value="' + value['amount'] +'"></div>' +
                    '</div>')

                $('#step5').find('.total').text('P '+_return)
            })
            $('#step5 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-return">Add more</button></div>')


            if(json['taken'] != null){
                $('#step7').find('.margin_top').remove()
            }

            var taken = 0
            $.each(json['taken'],function (index,value){
                taken = taken + (value['amount'] == '' ? 0 : parseFloat(value['amount']))

                $('#step7').append('<div class="row margin_top">' +
                    '<div class="col-md-1"><div class="number-ctr">'+ (index + 1) +'.</div></div>' +
                    '<div class="col-md-6"><input type="text" class="form-control" name="taken['+ index +'][name]" placeholder="Name" value="'+ value['name'] +'"></div>' +
                    '<div class="col-md-5"><input type="text" id="taken-amount" class="form-control" name="taken['+ index +'][amount]" placeholder="Amount" value="'+ value['amount'] +'"></div>' +
                    '</div>')
                $('#step7').find('.total').text('P '+taken)
            })
            $('#step7 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-taken">Add more</button></div>')

            if(json['deposit'] != null){
                $('#step8').find('.margin_top').remove()
            }
            var deposit = 0
            $.each(json['deposit'],function (index,value){
                deposit = deposit + (value['amount'] == '' ? 0 : parseFloat(value['amount']))
                $('#step8').append('<div class="row margin_top">' +
                    '<div class="col-md-1"><div class="number-ctr">'+ (index + 1) +'.</div></div>' +
                    '<div class="col-md-4"><input type="text" class="form-control" name="deposit['+ index +'][bank_name]" placeholder="Bank Name" value="'+ value['bank_name'] +'"></div>' +
                    '<div class="col-md-4"><input type="text" class="form-control" name="deposit['+ index +'][bank_number]" placeholder="Bank Number" value="'+ value['bank_number'] +'"></div>' +
                    '<div class="col-md-3"><input type="text" id="deposit-amount" class="form-control" name="deposit['+ index +'][amount]" placeholder="Amount" value="'+ value['amount'] +'"></div>' +
                    '</div>')
                $('#step8').find('.total').text('P '+deposit)
            })
            $('#step8 div.row.margin_top:last-child div:nth-child(4)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-deposit">Add more</button></div>')



            //total cash
            var _1000 = json['amount_1000'] * 1000
            var _500 = json['amount_500'] * 500
            var _100 = json['amount_100'] * 100
            var _50 = json['amount_50'] * 50
            var _20 = json['amount_20'] * 20
            var _coins = json['amount_coins']
            var cash = parseFloat(_1000) + parseFloat(_500) + parseFloat(_100) +parseFloat( _50) + parseFloat(_20) + parseFloat(_coins)
            $('#step6').find('.total').text('P '+ cash)



        }else {
            $('#step1').find('.total').text('P 0')

            $('#step1').find('.margin_top').remove()
            $('#step1').append('<div class="row margin_top">' +
                '<div class="col-md-1 ">' +
                '<div class="number-ctr">1.</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<input type="text" class="form-control" name="with_receipt[0][rec_no]" placeholder="Receipt no." value=""></div>' +
                '<div class="col-md-5">' +
                '<input type="text" id="w-amount" class="form-control" name="with_receipt[0][rec_amount]" placeholder="Amount" value=""></div>' +
                '</div>');
            $('#step1 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-w-rec">Add more</button></div>')


            $('#step2').find('.total').text('P 0')

            $('#step2').find('.margin_top').remove()
            $('#step2').append('<div class="row margin_top">' +
                '<div class="col-md-1">' +
                '<div class="number-ctr">1.</div></div>' +
                '<div class="col-md-11">' +
                '<input type="text" id="wo-amount" class="form-control" name="without_receipt[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')
            $('#step2 div.row.margin_top:last-child div:nth-child(2)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-wo-rec">Add more</button></div>')

            $('#step3').find('.total').text('P 0')
            $('#step3').find('.margin_top').remove()
            $('#step3').append('<div class="row margin_top">' +
                '<div class="col-md-1">' +
                '<div class="number-ctr">1.</div></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="credit[0][company]" placeholder="Company" value=""></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="credit[0][bank_name]" placeholder="Bank Name" value=""></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="credit[0][bank]" placeholder="Bank Number" value=""></div>' +
                '<div class="col-md-2"><input type="text" id="credit-amount" class="form-control" name="credit[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')
            $('#step3 div.row.margin_top:last-child div:nth-child(5)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-credit">Add more</button></div>')


            $('#step4').find('.total').text('P 0')
            $('#step4').find('.margin_top').remove()
            $('#step4').append('<div class="row margin_top">' +
                '<div class="col-md-1 "><div class="number-ctr">1.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="expense[0][details]" placeholder="Details" value=""></div>' +
                '<div class="col-md-5"><input type="text" id="expense-amount" class="form-control" name="expense[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')
            $('#step4 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-expense">Add more</button></div>')

            $('#step5').find('.total').text('P 0')
            $('#step5').find('.margin_top').remove()
            $('#step5').append('<div class="row margin_top">' +
                '<div class="col-md-1 "><div class="number-ctr">1.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="return[0][name]" placeholder="Name" value=""></div>' +
                '<div class="col-md-5"><input type="text" id="return-amount" class="form-control" name="return[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')
            $('#step5 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-return">Add more</button></div>')


            $('#step7').find('.total').text('P 0')
            $('#step7').find('.margin_top').remove()
            $('#step7').append('<div class="row margin_top">' +
                '<div class="col-md-1"><div class="number-ctr">1.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="taken[0][name]" placeholder="Name" value=""></div>' +
                '<div class="col-md-5"><input type="text" id="taken-amount" class="form-control" name="taken[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')
            $('#step7 div.row.margin_top:last-child div:nth-child(3)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-taken">Add more</button></div>')

            $('#step8').find('.total').text('P 0')
            $('#step8').find('.margin_top').remove()

            $('#step8').append('<div class="row margin_top">' +
                '<div class="col-md-1"><div class="number-ctr">1.</div></div>' +
                '<div class="col-md-4"><input type="text" class="form-control" name="deposit[0][bank_name]" placeholder="Bank Name" value=""></div>' +
                '<div class="col-md-4"><input type="text" class="form-control" name="deposit[0][bank_number]" placeholder="Bank Number" value=""></div>' +
                '<div class="col-md-3"><input type="text" id="deposit-amount" class="form-control" name="deposit[0][amount]" placeholder="Amount" value=""></div>' +
                '</div>')
            $('#step8 div.row.margin_top:last-child div:nth-child(4)').append('<div class="margin_top text-right"><button type="button" class="btn btn-primary" id="add-deposit">Add more</button></div>')


            $('#step6').find('.total').text('P 0')


        }


        //numeric input
        $('#taken-amount,#return-amount,#expense-amount,#credit-amount,#w-amount,#wo-amount').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});


    }

</script>
