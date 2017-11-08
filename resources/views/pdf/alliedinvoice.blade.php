
<style>

    @page {
        margin: 160px 15px 0px 20px;

    }


    h1,h3{
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
        text-align: center;
        border: 1px solid black;
        font-size: 13px;
        margin: 0px;
    }

    thead tr th {
        border: 1px solid black;
        padding: 10px 0px;
        text-transform: uppercase;

        color: white;

        background-color: black;
    }

    table tbody tr td{
        padding: 3px 0px;
    }

    .page-break {
        page-break-after: always;
    }


    .header{
        text-align: center;
        position: fixed;
        top: -150px;
        margin: 0;
        background-color: white;
    }
    .header h1{
        text-transform: uppercase;
        font-size: 16px;
    }
    .header .sub-header{
        margin-top: 5px;
    }
    .header .sub-header h3{
        font-weight: normal;
        text-transform: capitalize;
        font-size: 11px;
    }




    .branch-name{
        position: fixed;
        left: 0;
        top: -60px;
        font-size: 20px;
        text-transform: uppercase;
        padding: 8px 5px 0px 5px;
        background-color: white;
        font-weight: bolder;
    }

    .inv-number{
        position: fixed;
        right: 0;
        top: -85px;
        border: 1px solid black;
        height: 30px;
        font-size: 16px;
        width: 200px;
        text-align: center;
        padding: 8px 5px 0px 5px;
        font-weight: bold;
        background-color: white;
        border-radius: 5px;
    }
    .inv-number span{
        color: red;
    }

    .deliver-receipt{
        position: fixed;
        right: 0;
        top: -125px;
        background-color: black;
        color: #fff;
        height: 30px;
        font-size: 16px;
        width: 200px;
        text-align: center;
        padding: 8px 5px 0px 5px;
        font-weight: bold;
        border-radius: 5px;
    }

    .page-copy{
        position: absolute;
        text-align: left;
        bottom: 60px;
        font-size: 12px;
        font-style: italic;
    }
    .warehouse{
        position: absolute;
        text-align: right;
        bottom: 60px;
        font-size: 12px;
        font-style: italic;

    }

    .date{
        position: fixed;
        text-align: right;
        top: -30px;
        background-color: white;
        font-size: 13px;
        font-weight: bold;
    }

    .date1{
        position: relative;
        text-align: right;
        top: 0px;
        font-size: 13px;
        font-weight: bold;
    }

    .delivered_to{
        position: absolute;
        top: -20px;
        padding-left: 8px;

    }
    .address{

        padding-left: 8px;
        padding-bottom: 20px;
    }
    .address span{
        margin-left: 20px;
    }
    .received-goods{
        text-align: right;
        font-style: italic;
    }
    .delivered_to,.address,.print-info,.received-goods{
        font-size: 13px;
    }
    .delivered_to span,.address span{
        text-transform: uppercase;
        border-bottom: 1px solid black;
    }
    table tr th{border-right: 1px solid white !important}
    table tr th:last-child{border-right: 1px solid black !important;}
    table tr td{ border-right: 1px solid black !important; }
    table tbody tr td:nth-child(3),table tbody tr td:nth-child(2),table tbody tr td:nth-child(1),table tbody tr td:nth-child(4),table tbody tr td:nth-child(5){ text-align: left;padding-left: 15px }
    #total td{
        border-top: 1px solid black !important;

    }
    #total td:nth-child(4),#total td:nth-child(1) span,#total td:nth-child(5){
        font-weight:700;
    }
    #total td:nth-child(2),#total td:nth-child(3){
        border-right: 0 !important;
    }
    .print-info{
        padding-top: 20px;

    }
    .print-info div:nth-child(1) span{
        margin-left: 20px;

    }
    .print-info div:nth-child(2){
        padding-top: 10px;

    }
    .print-info div:nth-child(2) span{
        margin-left: 10px;
        border-bottom: 1px solid black;
    }
    .print-info div:nth-child(3){
        font-style: italic;
    }

    .received-by{
        font-style: normal;
        position: relative;
        text-align: right;
        top:-45px;

    }
    .signature{
        margin-right: 50px;
    }
    .date-received{
        position: relative;
        top:-55px;
    }
    .prepared-by{
        position: relative;
        top:0px;
    }
    .prepared-by span{
        margin-left: 10px;
        text-transform: capitalize;
        font-weight: bold;
    }

    .checked-by span{
        background: white;
    }
    .invoice-follow{
        position: relative;
        top:-25px;
        font-style: italic;
    }
    table tbody tr:nth-of-type(5n) td {
        border-bottom: 1px dashed red;

    }

</style>
<title>MCOAT - {!! $invoice['receipt_no'] !!}</title>

@for($i = 1;$i <= 3;$i++)

    <div class="header">
        <h1>ALLIED PAINT COMMERCIAL & GENERAL MERCHANDISE</h1>
        <div class="sub-header">
            <h3>320 KM Caranglaan Dagupan Pangasinan</h3>
            <h3>Ludilyn De Jesus - Prop.</h3>
            <h3>Tel: (075)515-6259</h3>
            <h3>Vat. Reg. TIN: 146-286-510-001</h3>
        </div>
    </div>
    <div class="deliver-receipt">
        DELIVERY RECEIPT

    </div>

    <div class="branch-name">
        {!! $invoice['branch_name'] !!}
    </div>
    <div class="inv-number">
        NO. <span>{!! $invoice['receipt_no'] !!}</span>
    </div>
    <div class="date">
        Date printed: {!! $invoice['created_at'] !!}
    </div>
    @if($invoice['view'] == 1)
        <div class="date1">
            Date Reprinted: {!! date('M d,Y') !!}
        </div>
    @endif

    <div class="delivered_to">
        Delivered To: <span>{!! $invoice['branch_name'] !!}</span>
    </div>
    <div class="address">
        Address: <span>{!! $invoice['address'] !!}</span>
    </div>

    <div class="table-location">
        <table class="table" id="sample" width="100%">
            <thead>
            <tr>
                <th>Qty/Unit</th>
                <th>Code</th>
                <th>Description</th>


                <th>unit price</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice['products'] as $key=>$val)
                <tr>
                    <td>{!! $val->product_qty !!}   {!!  $val->unit !!}</td>
                    <td>{!! $val->code !!} </td>
                    <td>{!! $val->brand.' '.$val->category.' '.$val->description  !!}</td>
                    <td>{!! 'P '.number_format($val->unit_price , 2) !!}</td>
                    <td>{!! 'P '.number_format($val->unit_price * $val->product_qty, 2) !!}</td>
                </tr>
            @endforeach
            <tr id="total">
                <td>TOTAL ITEMS:<span>{{ count($invoice['products']) }}</span> </td>
                <td></td>
                <td></td>
                <td>TOTAL</td>
                <td>{!! 'P '.number_format($invoice['total'], 2) !!}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="received-goods">
        Received the above goods in good order and condition
    </div>
    <div class="print-info">
        <div class="prepared-by">
            Prepared by: <span>{!!  $invoice['name'] !!}</span>
        </div>

        <div class="checked-by">
            Checked by: ______________________________________
        </div>
        <div class="received-by">
            Received by: <span>______________________________________</span>

        </div>
        <div class="received-by signature">
            Name & Authorized Signature

        </div>


        <div class="invoice-follow">
            Invoice to follow
        </div>
        <div class="received-by date-received">
            Date received: <span>______________________________________</span>

        </div>
    </div>


    <div class="page-copy">
        @if( $i == 1 )
            <p>*This is the original copy</p>

        @elseif( $i == 2 )
            <p>**This is the duplicate copy</p>

        @else
            <p>***This is the triplicate copy</p>

        @endif
    </div>
    <div class="warehouse">
        @if( $i == 1 )
            <p>*Dagupan Warehouse</p>
        @elseif( $i == 2 )
            <p>*Dagupan Warehouse</p>
        @else
            <p>*Dagupan Warehouse</p>
        @endif
    </div>
    <div class="page-break"></div>

@endfor



