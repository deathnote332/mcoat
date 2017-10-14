<style>
    .search{
        margin-top: 20px;
    }
    .products{
        padding-top: 20px;
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
<div class="search">
<input  type="text" class="form-control" placeholder="Search...">
</div>
<div class="products">
    <ul>

    </ul>
</div>
<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {
        $.ajax({
            url:BASEURL + '/getProducts',
            type: 'GET',
            success: function (data){
                var json = JSON.parse(data);
                $.each(json['data'],function (name,val) {

                    $('.products ul').append($('' +
                        '<div class="product-list">' +
                        '<li class="brand">' +'<span>Brand: </span>'+ val['brand'] +'</li>' +
                        '<li class="category">' +'<span>Category: </span>'+ val['category'] +'</li>' +
                        '<li class="code">' +'<span>Code: <span>'+ val['code'] +'</li>' +
                        '<li class="description">' +'<span>Description: </span>'+ val['description'] +'</li>' +
                        '<li class="quantity">' +'<span>Quantity: </span>'+ val['quantity'] +'</li>' +
                        '<li class="unit">' +'<span>Unit: </span>'+ val['unit'] +'</li>' +
                        '<li class="unit_price">' +'<span>Price: </span>'+ val['unit_price'] +'</li>' +
                        '</div>' +
                        ''));
                })

            }
        });
    })
</script>