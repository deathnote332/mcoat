

@for($i=1;$i<= $month_count ;$i++)
    <?php
    $datas = DB::table('month_sales')->where('branch_id',$branch)->where(DB::raw('YEAR(_date)'),$year)->where(DB::raw('MONTH(_date)'),$i)->get();

    $with_receipt_total = 0;
    $without_receipt_total = 0;
    $credit_total = 0;
    $expense_total = 0;
    $_total = 0;
    $cash_total = 0;
    $excess = 0;
    $loss = 0;

    if($datas != null || $datas != ''){
        foreach($datas as $key => $vals){

            $data = json_decode($vals->data,TRUE);


            if($data['with_receipt'] != null){
                foreach ($data['with_receipt']  as $key =>$val){

                    $with_receipt_total = $with_receipt_total + ($val['rec_amount'] == '' ? 0 : $val['rec_amount']);
                }
            }




            if($data['without_receipt'] != null){
                foreach ($data['without_receipt']  as $key =>$val){
                    $without_receipt_total = $without_receipt_total + ($val['amount'] == '' ? 0 : $val['amount']);
                }
            }


            if($data['credit'] != null){
                foreach ($data['credit']  as $key =>$val){
                    $credit_total = $credit_total + ($val['amount'] == '' ? 0 : $val['amount']);
                }
            }



            if($data['expense'] != null){
                foreach ($data['expense']  as $key =>$val){
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

    }

    ?>

    <div class="col-md-4 table-computation">
        <div class="text-center" style="padding-top: 10px">
            <h5 style="font-weight: 600;text-transform: uppercase">{{\App\Branches::find($branch)->name}} MONTHLY SALES REPORT</h5>
        </div>
        <div class="text-center">
            <h4>{{ date('F', mktime(0, 0, 0, $i, 1)) }} {{$year}}</h4>
        </div>

        <div class="">
            <button type="button" class="btn btn-primary view-details" data-month="{{ $i }}" data-branch="{{ $branch }}">View all</button>
        </div>

        <table width="100%" >
            <tbody>
            <tr >
                <td>TOTAL SALES</td>
                <td></span>{{ 'P '.number_format(($with_receipt_total + $without_receipt_total),2) }}</td>
            </tr>
            <tr>
                <td>CREDIT COLLECTION</td>
                <td>{{ 'P '.number_format($credit_total,2) }}</td>
            </tr>
            <tr>
                <td>FOR DEPOSIT</td>
                <td>{{ 'P '.number_format(0,2) }}</td>
            </tr>
            <tr>
                <td>EXPENSES</td>
                <td>{{ 'P '.number_format($expense_total,2) }}</td>
            </tr>
            <tr>
                <td>PURCHASE ORDER</td>
                <td>{{ 'P '.number_format(0,2) }}</td>
            </tr>
            <tr>
                <td>STOCK IN</td>
                <td>{{ 'P '.number_format(0,2) }}</td>
            </tr>
            <tr>
                <td>STOCK OUT</td>
                <td>{{ 'P '.number_format(0,2) }}</td>
            </tr>

            </tbody>
        </table>
    </div>
    @endfor
</div>
