
<style>
    table{
        text-align: center;
        font-weight: 600;
    }
    tr th {
        background: #337ab7 !important;
        color: #fff !important;;
        text-transform: uppercase;
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
<table id="sales" class="table table-bordered dt-responsive" cellspacing="0" width="100%">
    <input type="hidden" id="user_type" value="{{ Auth::user()->user_type }}">
    <input type="hidden" id="branch_id" value="{{ $branch }}">
    <thead>
        <tr>
            <th>Day</th>
            <th>Receipt no.</th>
            <th>Total Sales</th>
            <th>Bank Deposit</th>
            <th>Taken</th>
            <th>Expenses</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 1; $i<=$end_date;$i++)
            <?php
                    $total_sales = 0;
            $str = $i.'-'.$month.'-'.$year;
            $date = date('Y-m-d', strtotime($str));
            $datas =\Illuminate\Support\Facades\DB::table('month_sales')->where('branch_id',$branch)->where('_date',$date)->first();

            $rec_no = ($datas != null) ? json_decode($datas->data,TRUE)['receipt_no'] : 0;
            $total = ($datas != null) ? json_decode($datas->data,TRUE)['total_amount'] : 0;
            $deposit = ($datas != null) ? json_decode($datas->data,TRUE)['deposit_amount'] : 0;
            $taken = ($datas != null) ? json_decode($datas->data,TRUE)['taken_amount'] : 0;
            $expense = ($datas != null) ? json_decode($datas->data,TRUE)['expenses_amount'] : 0;
            $expense_desc = ($datas != null) ? json_decode($datas->data,TRUE)['expenses_description'] : '';
            $_date = date('F', mktime(0, 0, 0, $month, 1)). ' '.$i.' ,'.$year;

            ?>
            <tr>

                <td class="day">{{$i}}</td>
                <td>{{ $rec_no }}</td>
                <td>{{ 'P '.number_format($total,2) }}</td>
                <td>{{ 'P '.number_format($deposit,2) }}</td>
                <td>{{ 'P '.number_format($taken,2) }}</td>
                <td>{{ 'P '.number_format($expense,2).'-'.$expense_desc }}</td>
                <td>
                    <button class="btn btn-primary" id="edit-day" data-day="{{ $i }}" data-year="{{ $year }}" data-month="{{ $month }}"
                    data-rec_no="{{ $rec_no }}" data-total="{{$total}}" data-deposit="{{ $deposit }}"
                            data-taken="{{ $taken }}" data-expense="{{ $expense }}" data-expense_desc="{{$expense_desc}}"
                            data-_date="{{ $_date }}"

                    >Edit</button>
                </td>

            </tr>
        @endfor
    </tbody>
</table>
@include('modal.sales.editsale')
<script>
    $(document).ready(function () {
        var BASEURL = $('#baseURL').val();

        var sales = $('#sales').DataTable({
            iDisplayLength: 10,
            bLengthChange: false,
            bDeferRender:    true,
            ordering:false
        });
        
        $('body').on('click','#edit-day',function () {
            var _date = $(this).data('year') +'-'+$(this).data('month')+'-'+$(this).data('day')
            $('#edit-day-modal').modal('show')
            $('#day').text($(this).data('_date'))
            $('#_date').val(_date)
            $('#receipt_no').val($(this).data('rec_no'))
            $('#total_amount').val($(this).data('total'))
            $('#deposit_amount').val($(this).data('deposit'))
            $('#taken_amount').val($(this).data('taken'))
            $('#expenses_amount').val($(this).data('expense'))
            $('#expenses_description').val($(this).data('expense_desc'))
        })


        $('#back').on('click',function () {
            if($('#user_type').val() == 1){
                window.location = BASEURL + '/admin/branch/' + $('#branch_id').val()
            }else{
                window.location = BASEURL + '/user/sales'
            }
        })

        $('body').on('click','#btn-update',function () {
            if($('#user_type').val() == 1){
                saveDailyAdmin($('#_date').val())
            }else{
                saveDaily($('#_date').val())
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


    function saveDailyAdmin(day) {
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
                        url:BASEURL+"/admin/editsale",
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
</script>
