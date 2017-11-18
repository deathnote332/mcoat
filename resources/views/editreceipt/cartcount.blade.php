Cart
@if(\Illuminate\Support\Facades\DB::table('temp_product_out')->where('type',5)->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->where('rec_no',$receipt_no)->count() != 0)
    <span class="badge badge-danger">{{\Illuminate\Support\Facades\DB::table('temp_product_out')->where('type',5)->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->where('rec_no',$receipt_no)->count()}}</span>
@endif