{!! Theme::asset()->usePath()->add('employee.js','/js/web/employee.js') !!}
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
            <table id="user-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Date Hired</th>
                    <th>Branch Hired</th>
                    <th>Action</th>

                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
