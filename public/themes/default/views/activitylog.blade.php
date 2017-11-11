{!! Theme::asset()->usePath()->add('style','/css/web/style.css') !!}
<style>
    #notification-list_wrapper .row:nth-child(1){
        display: none;
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
            <table id="notification-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>

                    <th>Action</th>
                    <th>Date</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
<script>
    var BASEURL = $('#baseURL').val();
    $(document).ready(function () {

        var notification = $('#notification-list').DataTable({
            ajax: BASEURL + '/admin/notifications/0',
            order: [],
            iDisplayLength: 12,
            bLengthChange: false,
            deferRender: true,

            columns: [

                { data: 'message',"orderable": false },
                { data: 'created_at',"orderable": false},

            ],

        });

        $('#search').on('input',function () {

            notification.search(this.value).draw();
        })


    });





    $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        console.log(message);
        var notification = $('#notification-list').DataTable();
        notification.ajax.reload();
    };
</script>