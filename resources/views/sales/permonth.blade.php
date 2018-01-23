
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
<table id="sales" class="table table-bordered dt-responsive" cellspacing="0" width="100%">
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
            $datas =\Illuminate\Support\Facades\DB::table('month_sales')->where('_date',$date)->first();

            ?>
            <tr>
                <td>{{$i}}</td>
                <td>{{ ($datas != null) ? 'P '.number_format(json_decode($datas->data,TRUE)['receipt_no'],2) : 0 }}</td>
                <td>{{ ($datas != null) ? 'P '.number_format(json_decode($datas->data,TRUE)['total_amount'],2) : 0 }}</td>
                <td>{{ ($datas != null) ? 'P '.number_format(json_decode($datas->data,TRUE)['deposit_amount'],2) : 0 }}</td>
                <td>{{ ($datas != null) ? 'P '.number_format(json_decode($datas->data,TRUE)['taken_amount'],2) : 0 }}</td>
                <td>{{ ($datas != null) ? 'P '.number_format(json_decode($datas->data,TRUE)['expenses_amount'],2) : 0 }}</td>

                <td>
                    <button class="btn btn-primary">Edit</button>
                </td>

            </tr>
        @endfor
    </tbody>
</table>
<script>
    $(document).ready(function () {
        var sales = $('#sales').DataTable({
            iDisplayLength: 12,
            bLengthChange: false,
            bDeferRender:    true,
            ordering:false
        });
    })
</script>
