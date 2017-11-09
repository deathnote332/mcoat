
<div class="card-container">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                RESET SPECIFIC
                <span style="float: right;color: #337ab7;cursor: pointer" id="clear">Clear</span>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="stocks-report">
                    <select class="form-control" id="brand">
                        <option selected disabled>Choose Brand</option>
                        @foreach( \App\Product::select('brand')->where('status',1)->distinct()->orderBy('brand','asc')->get() as $key=>$val)
                            <option value="{{ $val->brand }}">{{ $val->brand }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" id="category-list" value="{{ json_encode(\App\Product::select('category')->where('status',1)->distinct()->orderBy('category','asc')->get()) }}">
                    <select class="form-control" id="category" style="margin: 15px 0">
                        <option selected disabled>Choose Category</option>
                        @foreach( \App\Product::select('category')->where('status',1)->distinct()->orderBy('category','asc')->get() as $key=>$val)
                            <option value="{{ $val->category }}">{{ $val->category }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary form-control reset-specific">Reset</button>
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
                <button class="form-control btn-primary btn reset-all">RESET ALL</button>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
</div>
<script>

    $(document).ready(function () {

        $('#brand').on('change',function () {
            $.ajax({
                url:BASEURL+'/brandCategory',
                type:'POST',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    brand: $('#brand option:selected').val()
                },
                success: function(data){
                    $('#category').html(data)
                }
            });
        })

        $('.reset-specific').on('click',function () {
            if($('#brand option:selected').val() == 'Choose Brand' && $('#category option:selected').val() == 'Choose Category'){
                swal({
                    title: "",
                    text: "Please choose from the field",
                    type:"error"
                })
            }else{
                resetProducts($('#brand option:selected').val(),$('#category option:selected').val(),1)

            }

        })

        $('.reset-all').on('click',function () {
            resetProducts('Choose Brand','Choose Category',2)
        })


        $('#clear').on('click',function () {
            $('#brand').prop('selectedIndex',0);
            $('#category').prop('selectedIndex',0);
            $.each(JSON.parse($('#category-list').val()),function (index,val) {

                console.log(val.category)
                $('#category').append($('<option value="'+ val.category +'">' + val.category +'</option>'))
            })
        })
    })

    function resetProducts(brand,category,type) {
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
                            quantity: 'quantity'
                        },
                        success: function(data){
                            swal.insertQueueStep(data)
                            resolve()
                            $('#brand').prop('selectedIndex',0);
                            $('#category').prop('selectedIndex',0);

                            $.each(JSON.parse($('#category-list').val()),function (index,val) {
                                console.log(val.category)
                                $('#category').append($('<option value="'+ val.category +'">' + val.category +'</option>'))
                            })

                        }
                    });
                })
            }
        }])

    }
</script>