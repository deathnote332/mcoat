<style>
    .card-container{
        padding-top: 30px;
    }

    .stocks-report select,.stocks-report1 select{
        margin-top: 10px;
        margin-bottom: 10px;
    }

</style>
<div class="card-container">
    <div class="row"><div class="col-lg-6">
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
        <!-- /.panel -->
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    GENERATE STOCKS REPORT

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="stocks-report">
                        <select class="form-control" id="stock-brand1">
                            <option selected disabled>Choose Brand</option>
                            @foreach( \App\Product::select('brand')->distinct()->orderBy('brand','asc')->get() as $key=>$val)
                                <option value="{{ $val->brand }}">{{ $val->brand }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" id="category1">
                            <option selected disabled>Choose Category</option>
                            @foreach( \App\Product::select('category')->distinct()->orderBy('category','asc')->get() as $key=>$val)
                                <option value="{{ $val->category }}">{{ $val->category }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" id="description1">
                            <option selected disabled>Choose Description</option>
                            @foreach( \App\Product::select('description')->distinct()->orderBy('description','asc')->get() as $key=>$val)
                                <option value="{{ $val->description }}">{{ $val->description }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" id="unit1">
                            <option selected disabled>Choose Unit</option>
                            @foreach( \App\Product::select('unit')->distinct()->orderBy('unit','asc')->get() as $key=>$val)
                                <option value="{{ $val->unit }}">{{ $val->unit }}</option>
                            @endforeach
                        </select>
                        <select class="form-control" id="stocks-report">
                            <option selected disabled>Choose stocks range</option>
                            <option value="0"> OUT OF STOCKS</option>
                            <option value="0"> STOCKS FROM 1-3</option>
                            <option value="1"> ALL </option>
                        </select>
                        <button class="btn btn-primary form-control generate-stocks1">Generate</button>
                    </div>

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

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
                generatePriceList($('#stock-brand').val(),$('#category').val())
            }

        })
    });

    

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
                path= BASEURL+'/pricelist/'+ brand +'/' + category;
            }else{
                path= BASEURL+'/pricelist/'+ brand;
            }

            window.open(path);
            swal({
                title: "",
                text: "Pricelist successfully generated",
                type:"success"
            })
        });
    }
</script>