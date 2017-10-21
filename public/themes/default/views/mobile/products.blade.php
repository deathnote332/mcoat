
<style>
    .search{
        position: fixed;
        background: white;
        width: 100%;
        left: 0;
        padding: 20px 30px 0 30px;
        margin: 0;
    }
    .search .row{
        margin-bottom: 0;
    }
    .products{
        padding-top: 90px;
    }
    ul{
        margin: 0;
        padding: 0;
    }

    ul li{
        list-style-type: none;
    }

    .products ul .product-list li:last-child{
        padding-bottom: 5px;
        border-bottom: 1px solid #e7e7e7;
    }
    .products ul .product-list li span{
        padding-right: 40px;
    }

</style>
<div id="list">
    <div class="search">
        <div class="row">

            <div class="col s12">
                <input  type="text" class="form-control fuzzy-search" placeholder="Search...">
            </div>
        </div>

    </div>
    <div class="products">
        <ul id="list">
            @foreach($data as $key=>$val)
                <div class="product-list">
                    <li class="row">
                        <div class="col s4">Brand: </div>
                        <div class="col s8 brand">{{ $val->brand }}</div>
                    </li>
                    <li class=" row">
                        <div class="col s4">Category: </div>
                        <div class="col s8 category">{{ $val->category }}</div>
                    </li>
                    <li class=" row">
                        <div class="col s4">Code: </div>
                        <div class="col s8 code">{{ $val->code }}</div>
                    </li>
                    <li class=" row">
                        <div class="col s4">Description: </div>
                        <div class="col s8 description">{{ $val->description }}</div>
                    </li>
                    <li class=" row">
                        <div class="col s4">Quantity: </div>
                        <div class="col s8 quantity">{{ $val->quantity }}</div>
                    </li>
                    <li class=" row">
                        <div class="col s4">Unit: </div>
                        <div class="col s8 unit">{{ $val->unit }}</div>
                    </li>
                    <li class=" row">
                        <div class="col s4">Unit Price: </div>
                        <div class="col s8 unit_price">{{ $val->unit_price }}</div>
                    </li>

                </div>
            @endforeach

        </ul>
    </div>

</div>

<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {

        $('select').material_select();

        $('.caret').text('')

        $('.fuzzy-search').change( function () {
            var filter = $(this).val();
            if (filter) {
                $('#list').find("div.col.s8:not(:contains(" + filter + "))").parent().slideUp();
                $('#list').find("div.col.s8:contains(" + filter + ")").parent().slideDown();
            } else {
                $('#list').find("li").slideDown();
            }
        });

//        var options = {
//            valueNames: [ 'brand', 'category','code','description','quantity','unit','unit_price' ],
//            indexAsync: true
//        };
//
//        var userList = new List('list', options);
    })
</script>