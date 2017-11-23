{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}
<div class="panel-body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="tab-productout">
        <li class="active"><a href="#mcoat" data-toggle="tab" data-id="1">MCOAT</a>
        </li>
        <li><a href="#allied" data-toggle="tab" data-id="2">ALLIED</a>
        </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade in active" id="mcoat">

        </div>
        <div class="tab-pane fade" id="allied">

        </div>

    </div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {
        viewProductList()
        viewAlliedProductList()
    })
    function viewProductList() {

        $.ajax({
            url:BASEURL + '/admin/resetmcoat',
            type: 'GET',
            success: function (data){
                $('#mcoat').html(data);
            }
        });

    }


    function viewAlliedProductList() {

        $.ajax({
            url:BASEURL + '/admin/resetallied',
            type: 'GET',
            success: function (data){
                $('#allied').html(data);
            }
        });

    }
</script>