<div class="card-container">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                RESET SPECIFIC
                <span style="float: right;color: #337ab7;cursor: pointer" id="clear1">Clear</span>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="stocks-report1">
                    <select class="form-control" id="brand1">
                        <option selected disabled>Choose Brand</option>
                        @foreach( \App\Product::select('brand')->where('status',1)->distinct()->orderBy('brand','asc')->get() as $key=>$val)
                            <option value="{{ $val->brand }}">{{ $val->brand }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="category-list" value="{{ json_encode(\App\Product::select('category')->where('status',1)->distinct()->orderBy('category','asc')->get()) }}">
                    <select class="form-control" id="category1" style="margin: 15px 0">
                        <option selected disabled>Choose Category</option>
                        @foreach( \App\Product::select('category')->where('status',1)->distinct()->orderBy('category','asc')->get() as $key=>$val)
                            <option value="{{ $val->category }}">{{ $val->category }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary form-control reset-specific1">Reset</button>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                RESET ALL

            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <button class="form-control btn-primary btn reset-all1">RESET ALL</button>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
<script>

    $(document).ready(function () {

        $('#brand1').on('change',function () {
            $.ajax({
                url:BASEURL+'/brandCategory',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    brand: $('#brand option:selected').val()
                },
                success: function(data){
                    $('#category1').html(data)
                }
            });
        })

        $('.reset-specific1').on('click',function () {
            if($('#brand1 option:selected').val() == 'Choose Brand' && $('#category1 option:selected').val() == 'Choose Category'){
                swal({
                    title: "",
                    text: "Please choose from the field",
                    type:"error"
                })
            }else{
                resetProduct($('#brand1 option:selected').val(),$('#category1 option:selected').val(),1)

            }

        })

        $('.reset-all1').on('click',function () {
            resetProduct('Choose Brand','Choose Category',2)
        })


        $('#clear1').on('click',function () {
            $('#brand1').prop('selectedIndex',0);
            $('#category1').prop('selectedIndex',0);
            $.each(JSON.parse($('#category-list').val()),function (index,val) {

                console.log(val.category)
                $('#category1').append($('<option value="'+ val.category +'">' + val.category +'</option>'))
            })
        })
    })

    function resetProduct(brand,category,type) {
        var message = (type == 1) ? 'this specific' : 'all this';
        swal.queue([{
            title: 'Are you sure',
            text: "You want to reset "+ message +" product.",
            type:'warning',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            allowOutsideClick: false,
            closeOnConfirm: false,
            confirmButtonText: 'Okay',
            confirmButtonColor: "#DD6B55",
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url:BASEURL+'/admin/resetproduct',
                        type:'POST',
                        data: {
                            _token : $('meta[name="csrf_token"]').attr('content'),
                            brand: brand,
                            category: category,
                            quantity: 'quantity_1'
                        },
                        success: function(data){
                            swal.insertQueueStep(data)
                            resolve()
                            $('#brand1').prop('selectedIndex',0);
                            $('#category1').prop('selectedIndex',0);

                            $.each(JSON.parse($('#category-list').val()),function (index,val) {
                                console.log(val.category)
                                $('#category1').append($('<option value="'+ val.category +'">' + val.category +'</option>'))
                            })

                        }
                    });
                })
            }
        }])

    }
</script>