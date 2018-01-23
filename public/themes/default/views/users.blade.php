{!! Theme::asset()->usePath()->add('users.js','/js/web/users.js') !!}
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
            <table id="user-list" class="table table-bordered dt-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>User Status</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

