
$(document).ready(function () {
    var BASEURL = $('#baseURL').val();
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