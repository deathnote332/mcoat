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
                        <select class="form-control">
                            <option selected disabled>Choose Brand</option>
                            @foreach( \App\Product::select('brand')->distinct()->orderBy('brand','asc')->get() as $key=>$val)
                                <option value="{{ $val->brand }}">{{ $val->brand }}</option>
                            @endforeach
                        </select>
                        <select class="form-control">
                            <option selected disabled>Choose Category</option>
                            <option> OUT OF STOCKS</option>
                            <option> 1-3 STOCKS</option>
                        </select>
                        <select class="form-control" id="stocks-report">
                            <option selected disabled>Choose stocks range</option>
                            <option value="0"> OUT OF STOCKS</option>
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
        
        $('.generate-stocks').on('click',function () {
            generatePriceList($('#stock-brand').val(),$('#category').val())
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

            var path = BASEURL+'/pricelist/'+ brand +'/' + category;
            window.open(path);

            swal({
                title: "",
                text: "Pricelist successfully generated",
                type:"success"
            })
        });
    }
</script>