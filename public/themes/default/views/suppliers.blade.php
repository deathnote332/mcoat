{!! Theme::asset()->usePath()->add('supplier.js','/js/web/supplier.js') !!}
<div class="card-container">
    <div class="container-fluid">
        <div class="row pad_top_20">
            <div class="col-md-6 table-search-input">
                <input type="text" id="search" name="search" class="form-control search-inputs" placeholder="Search..">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="supplier-list" class="table table-bordered dt-responsive " cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Supplier name</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
@include('modal.suppliermodal')
