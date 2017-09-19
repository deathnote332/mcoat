Cart
@if(\Illuminate\Support\Facades\DB::table('product_out_items')->where('receipt_no',$receipt_no)->count() != 0)
    <span class="badge badge-danger">{{\Illuminate\Support\Facades\DB::table('product_out_items')->where('receipt_no',$receipt_no)->count()}}</span>
@endif