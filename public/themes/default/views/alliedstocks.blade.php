{!! Theme::asset()->usePath()->add('allied','/js/web/allied.js') !!}
<div class="card-container">
    <input type="hidden" id="user_type" value="{{ \Illuminate\Support\Facades\Auth::user()->user_type }}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-6 table-search-input">
                <input type="text" id="search" name="search" class="form-control" placeholder="Search..">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="allied-list" class="table table-bordered dt-responsive no-wrap" cellspacing="0" width="100%">
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
</div>
