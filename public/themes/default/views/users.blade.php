<style>
    tr th{
        background: #2980b9;
        color: #fff;
        text-transform: uppercase;
    }

    .card-container{
        padding-top: 30px;
    }

    #user-list_wrapper .row:nth-child(1){
        display: none;
    }
    #user-list_wrapper tbody tr td:nth-child(4){
        text-align: center;
    }
    .search-inputs{
        margin-left: 15px;
        margin-bottom: 10px;
    }
    #add-to-cart{
        cursor: pointer;
    }

    label.alert{
        margin: 0;
        padding: 5px 30px;
        margin-left: 20px;
        cursor: pointer;
    }
</style>
<div class="card-container">
    <div class="row">

        <div class="col-md-3">
            <input type="text" id="search" name="search" class="form-control search-inputs" placeholder="Search..">
        </div>
    </div>
<div class="row">
    <div class="col-md-12">
        <table id="user-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>
                <th>Action</th>

            </tr>
            </thead>

        </table>
    </div>
</div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
$(document).ready(function () {
    var users = $('#user-list').DataTable({
        ajax: BASEURL + '/getusers',
        order: [],
        iDisplayLength: 12,
        bLengthChange: false,
        deferRender:    true,
        columns: [

            { data: 'name',"orderable": false },
            { data: 'email',"orderable": false},
            { data: 'created_at',"orderable": false },
            { data: 'action',"orderable": false },


        ]
    });
});

</script>