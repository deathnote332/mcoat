{!! Theme::asset()->usePath()->add('receipts','/js/web/receipts.js') !!}
<div class="card-container">
    <div class="container-fluid">
        <div class="row pad_top_20">
            <div class="col-md-6 table-search-input">
                <div class="range-selection">
                    <select id="range" class="form-control">
                        <option selected value="today">Today</option>
                        <option  value="week">Week</option>
                        <option  value="month">Month</option>
                        <option value="all">All</option>
                    </select>
                </div>

            </div>
            <div class="col-md-4 col-md-offset-2 table-search-input">
                <input type="text" id="search" name="search" class="form-control" placeholder="Search..">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <table id="receipt-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Receipt no.</th>
                    <th>Delivered to</th>
                    <th>Total</th>
                    <th>Created by</th>
                    <th>Date created</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
