{!! Theme::asset()->usePath()->add('branches.js','/js/web/branches.js') !!}
<div class="card-container">
    <div class="container-fluid">
        <div class="row pad_top_20">
            <div class="col-md-6 table-search-input">
                <input type="text" id="search" name="search" class="form-control search-inputs" placeholder="Search..">
            </div>
            <div class="col-md-4 col-md-offset-2 table-search-input">
                <div class="btn-add">
                    <button type="button" class="btn btn-primary form-control add-new">Add new warehouse</button>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table id="branch-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Branch name</th>
                    <th>Address</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
@include('modal.branchmodal')
