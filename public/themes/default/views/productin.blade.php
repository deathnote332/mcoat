{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}

<div class="panel-heading">
    MCOAT PRODUCTIN
</div>
<!-- /.panel-heading -->
<div class="panel-body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="tab-productout">
        <li class="active"><a href="#stocks" data-toggle="tab" data-id="1">Stocks</a>
        </li>
        <li><a href="#cart" data-toggle="tab" data-id="2">
                Cart
                @if(\App\TempProductout::where('type',2)->count() != 0)
                    <span class="badge badge-danger">{{\App\TempProductout::where('type',2)->count()}}</span>
                @else
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

    function getView() {

        viewProductList()
        viewCart()

    }

    function viewProductList() {

        $.ajax({
            url:BASEURL + '/productinList',
            type: 'GET',
            success: function (data){
                $('#stocks').html(data);
            }
        });

    }
    function viewCart(){

        $.ajax({
            url:BASEURL + '/cartListIn',
            type: 'GET',
            success: function (data){
                $('#cart').html(data);
            }
        });
    }

</script>