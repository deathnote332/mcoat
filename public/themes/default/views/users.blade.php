<div class="row">
    <div class="col-md-12">
        <table id="user-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created at</th>

            </tr>
            </thead>

        </table>
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


        ]
    });
});

</script>