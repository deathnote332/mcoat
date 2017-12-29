{!! Theme::asset()->usePath()->add('managemcoat','/js/web/managemcoat.js') !!}
<div class="card-container">
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-6 table-search-input">
                <input type="text" id="search" name="search" class="form-control search-inputs" placeholder="Search..">
            </div>
            <div class="col-md-4 col-md-offset-2 table-search-input">
                <div class="btn-add">
                    <button type="button" class="btn btn-primary form-control add-new"> Add new product</button>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="productout-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
@include('modal.managemcoatmodal')
