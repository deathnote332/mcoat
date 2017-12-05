{!! Theme::asset()->usePath()->add('products','/css/web/products.css') !!}
{!! Theme::asset()->usePath()->add('mcoat','/js/web/mcoat.js') !!}

<div class="card-container">
    <input type="hidden" id="user_type" value="{{ \Illuminate\Support\Facades\Auth::user()->user_type }}">
    <div class="row">
        <div class="col-md-2 col-sm-6 col-lg-6">
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
        <div class="col-md-3 col-sm-6 col-lg-6">
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
</div>