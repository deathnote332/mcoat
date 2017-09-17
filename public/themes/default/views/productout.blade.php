<style>
    span.badge.badge-danger {
        position: relative;
        top: -8px;
        right: -3px;
        background: red;
    }
</style>
    <div class="panel-heading">
        MCOAT PRODUCTOUT
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" id="tab-productout">
            <li class="active"><a href="#stocks" data-toggle="tab" data-id="1">Stocks</a>
            </li>
            <li><a href="#cart" data-toggle="tab" data-id="2">
                    Cart
                    @if(\App\TempProductout::where('type',1)->count() != 0)
                        <span class="badge badge-danger">{{\App\TempProductout::where('type',1)->count()}}</span>

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
    getView(1)
    getView(2)
    $(document).ready(function () {
        $('#tab-productout li').on('click',function () {
            getView($(this).data('id'))
        })
    });
    
    function getView(view) {
        if(view  == 1){
            viewProductList()
        }else{
            viewCart()
        }
    }
    
    function viewProductList() {

        $.ajax({
            url:BASEURL + '/productoutList',
            type: 'GET',
            success: function (data){
                $('#stocks').html(data);
            }
        });

    }
    function viewCart(){

        $.ajax({
            url:BASEURL + '/cartList',
            type: 'GET',
            success: function (data){
                $('#cart').html(data);
            }
        });
    }

</script>