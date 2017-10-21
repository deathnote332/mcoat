<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;

    }

    #mcoat-list_wrapper .row:nth-child(1){
        display: none;
    }
    .search-inputs{
        padding-left: 15px;
        padding-bottom: 10px;
    }
    .pagination li{
        display: inline;
    }
    .container{
        width: 100% ;
        padding: 15px;
    }

</style>

<div class="card-container">
    <input type="hidden" id="user_type" value="{{ \Illuminate\Support\Facades\Auth::user()->user_type }}">
    <div class="row">
        <div class="col-md-2 col s5">
            <div class="search-inputs">
                <select class="form-control" id="searchBy">
                    <option>Brand</option>
                    <option>Category</option>
                    <option>Code</option>
                    <option>Description</option>
                    <option selected>All</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 col s6">
            <input type="text" id="search" name="search" class="form-control" placeholder="Search..">
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="mcoat-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th>Brand</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>

<script>

    $('document').ready(function(){
        var BASEURL = $('#baseURL').val();


        var product = $('#mcoat-list').DataTable({
            ajax: BASEURL + '/getProducts',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            bInfo: false,
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.childRowImmediate,
                }
            },
            columns: [

                { data: 'brand',"orderable": false },
                { data: 'category',"orderable": false},
                { data: 'code',"orderable": false },
                { data: 'description',"orderable": false },
                { data: 'unit',"orderable": false },
                { data: 'quantity',"orderable": false },
                { data: 'unit_price',"orderable": false }
            ],
            "createdRow": function ( row, data, index ) {
                if($('#user_type').val() != 3){
                    if (data.quantity == 0) {
                        $(row).css({
                            'background-color': '#e74c3c',
                            'color': '#fff'
                        });
                    }else if (data.quantity <= 3 && data.quantity >= 1){
                        $(row).css({
                            'background-color': '#95a5a6',
                            'color': '#fff'
                        });
                    }
                }


            }
        });

        if($('#user_type').val() == 3){
            product.columns(5).visible(false);
        }


        $('#searchBy').on('change',function () {
            $('#search').val('')
            product.search( '' )
                .columns().search( '' )
                .draw();

        })

        $('#search').on('input',function () {
            var searchBy = $('#searchBy option:selected').val();
            if(searchBy == 'All'){
                product.search(this.value).draw();
            }else if(searchBy == 'Brand'){
                product.column(0).search(this.value).draw();
            }else if(searchBy == 'Category'){

                product.column(1).search(this.value).draw();
            }else if(searchBy == 'Code'){

                product.column(2).search(this.value).draw();
            }else if(searchBy == 'Description'){

                product.column(3).search(this.value).draw();
            }

        })



    });

    //New error event handling has been added in Datatables v1.10.5
    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var mcoat = $('#mcoat-list').DataTable();
        mcoat.ajax.reload();
    };

</script>