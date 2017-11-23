<style>
    span.badge.badge-danger {
        position: relative;
        top: -8px;
        right: -3px;
        background: red;
    }
    h2 span{
        color:red;
    }
</style>
<div class="panel-heading">
    <h2>Edit receipt no: <span>{{$receipt_no}}</span></h2>
    <input type="hidden" id="receipt_no" value="{{$receipt_no}}">
    <input type="hidden" id="type" value="{{$type}}">
</div>
<!-- /.panel-heading -->
<div class="panel-body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="tab-productout">
        <li class="active"><a href="#stocks" data-toggle="tab" data-id="1">Stocks</a>
        </li>
        <li><a href="#cart" data-toggle="tab" data-id="2">
                Cart
                @if(\Illuminate\Support\Facades\DB::table('temp_product_out')->where('type',5)->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->where('rec_no',$receipt_no)->count() != 0)
                    <span class="badge badge-danger">{{\Illuminate\Support\Facades\DB::table('temp_product_out')->where('type',5)->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->where('rec_no',$receipt_no)->count()}}</span>
                @endif
            </a>
        </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="stocks">
        </div>
        <div class="tab-pane fade" id="cart">

        </div>

    </div>
</div>
<!-- /.panel-body -->
</div>
<script>
    var BASEURL = $('#baseURL').val();


    $(document).ready(function () {
        getView()
    });

    function getView(view) {
        viewProductList()
        viewCart()
    }

    function viewProductList() {

        $.ajax({
            url:BASEURL + '/editProductList/'+$('#type').val(),
            type: 'GET',
            success: function (data){
                $('#stocks').html(data);
            }
        });

    }

    function viewCart(){

        $.ajax({
            url:BASEURL + '/editCartList',
            type: 'POST',
            data:{
                _token: $('meta[name="csrf_token"]').attr('content'),
                receipt_no: $('#receipt_no').val(),
            },
            success: function (data){
                $('#cart').html(data);
            }
        });
    }

</script>