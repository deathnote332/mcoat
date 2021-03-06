{!! Theme::asset()->usePath()->add('receipts','/css/web/receipts.css') !!}
<div class="card-container">
    <div class="row">
        @if(\Illuminate\Support\Facades\Auth::user()->user_type == 1)
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        GENERATE PRICE LIST

                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="stocks-report1">
                            <select class="form-control" id="stock-brand">
                                <option selected disabled>Choose Brand</option>
                                @foreach( \App\Product::select('brand')->distinct()->orderBy('brand','asc')->get() as $key=>$val)
                                    <option value="{{ $val->brand }}">{{ $val->brand }}</option>
                                @endforeach
                            </select>
                            <select class="form-control" id="category" disabled>
                                <option selected disabled>Choose Category</option>
                            </select>

                            <button class="btn btn-primary form-control generate-stocks">Generate</button>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        @endif
        <!-- /.panel -->
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    GENERATE STOCKS REPORT
                    <span class="reset-stock pull-right">RESET</span>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <form id="generate-stocks">
                        <div class="stocks-report">
                            <select class="form-control" id="stock-brand1" name="brand">
                                <option selected disabled>Choose Brand</option>
                                @foreach( \App\Product::select('brand')->distinct()->orderBy('brand','asc')->get() as $key=>$val)
                                    <option value="{{ $val->brand }}">{{ $val->brand }}</option>
                                @endforeach
                            </select>
                            <select class="form-control" id="category1" name="category">
                                <option selected disabled>Choose Category</option>
                                @foreach( \App\Product::select('category')->distinct()->orderBy('category','asc')->get() as $key=>$val)
                                    <option value="{{ $val->category }}">{{ $val->category }}</option>
                                @endforeach
                            </select>

                            <select class="form-control" id="stocks-type" name="stocks">
                                <option selected disabled>Choose stocks range</option>
                                <option value="0"> OUT OF STOCKS</option>
                                <option value="1"> STOCKS FROM 1-3</option>
                                <option value="2"> ALL </option>
                            </select>
                            <select class="form-control" id="warehouse" name="warehouse">
                                <option selected disabled>Choose Warehouse</option>
                                <option value="1">MCOAT WAREHOUSE</option>
                                <option value="2">ALLIED WAREHOUSE</option>

                            </select>
                            <button type="button" class="btn btn-primary form-control generate-stocks1">Generate</button>
                        </div>
                    </form>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <input type="hidden" value="{{ ceil(\App\Product::count()/300) }}" id="total">
    </div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {
        $('#stock-brand').on('change',function () {
            $.ajax({
                url:BASEURL+'/brandCategory',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    brand: $('#stock-brand option:selected').val()
                },
                success: function(data){
                    $('#category').prop('disabled',false)
                    $('#category').html(data)
                }
            });
        })

        $('#stock-brand1').on('change',function () {
            $.ajax({
                url:BASEURL+'/brandCategory',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    brand: $('#stock-brand1 option:selected').val()
                },
                success: function(data){
                    $('#category1').html(data)
                }
            });
        })
        
        $('.generate-stocks').on('click',function () {
            if($('#stock-brand option:selected').val() == 'Choose Brand'){
                swal({
                    title: "",
                    text: "Please choose from the field",
                    type:"error"
                })
            }else{
                generatePriceList($('#stock-brand').val(),$('#category option:selected').val())
            }

        })

        $('.generate-stocks1').on('click',function () {
            if($('#stock-brand1 option:selected').val() == 'Choose Brand' && $('#category1 option:selected').val() =='Choose Category' && $('#description1 option:selected').val() =='Choose Description' && $('#unit1 option:selected').val() =='Choose Unit' && $('#stocks-type option:selected').val() == 2){

                generatePriceListAll()

            }else if($('#stock-brand1 option:selected').val() == 'Choose Brand' && $('#category1 option:selected').val() =='Choose Category' && $('#description1 option:selected').val() =='Choose Description' && $('#unit1 option:selected').val() =='Choose Unit' || $('#stocks-type option:selected').val() == 'Choose stocks range' || $('#warehouse option:selected').val() == 'Choose Warehouse') {
                $('#stocks-type').focus();
                swal({
                    title: "",
                    text: "Please choose from the field / Stock range.",
                    type: "error"
                })


            }else{
                generateStockReport($('#stock-brand1 option:selected').val(),$('#category1 option:selected').val(),$('#description1 option:selected').val(),$('#unit1 option:selected').val(),$('#stocks-type option:selected').val());
            }

        })


    });


    function generatePriceListAll() {
        var pages = $('#total').val();

        swal({
            title: "Are you sure?",
            text: "You want to generate this pricelist.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {

            var path = '';
            path= BASEURL+'/stocklists/'+ 1 +'/'+ 2;
            window.open(path);

            for(var i=1;i<=pages;i++){
                path= BASEURL+'/stocklists/'+ 300 * i +'/'+ 2;
                window.open(path);
            }


            swal({
                title: "",
                text: "Pricelist successfully generated",
                type:"success"
            })
        });
    }


    function generatePriceList(brand,category) {
        swal({
            title: "Are you sure?",
            text: "You want to generate this pricelist.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {

            var path = '';
            if(category == 'Choose Category') {

                path= BASEURL+'/pricelist?brand='+ brand;
            }else{
                path= BASEURL+'/pricelist?brand='+ brand +'&category=' + category;
            }

            window.open(path);
            swal({
                title: "",
                text: "Pricelist successfully generated",
                type:"success"
            })
        });
    }

    function generateStockReport(brand,category,description,unit,stock) {

        swal({
            title: "Are you sure?",
            text: "You want to generate this stock report.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Okay',
            closeOnConfirm: false
        }).then(function () {

            var path=BASEURL+'/stocklist/'+ $('#warehouse').val()+'?stock=' + $('#stocks-type').val()
            if(brand != 'Choose Brand'){
                path += '&brand='+brand
            }
            if(category != 'Choose Category'){
                path += '&category='+category
            }
           window.open(path);
            swal({
                title: "",
                text: "Stock report successfully generated",
                type:"success"
            })

        });


    }

</script>