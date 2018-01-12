$('document').ready(function(){
    var BASEURL = $('#baseURL').val();

    var product = $('#allied-list').DataTable({
        ajax: BASEURL + '/getProducts',
        order: [],
        iDisplayLength: 10,
        bLengthChange: false,
        bDeferRender: true,
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.childRowImmediate,
            }
        },
        columns: [

            { data: 'brand',"orderable": false },
            { data: 'category',"orderable": false},
            { data: 'code',"orderable": false },
            { data: 'description',"orderable": false },
            { data: 'unit',"orderable": false },
            { data: 'quantity_1',"orderable": false },
            { data: 'unit_price',"orderable": false }
        ],
        "createdRow": function ( row, data, index ) {
            if($('#user_type').val() != 3){
                if (data.quantity_1 == 0) {
                    $(row).css({
                        'background-color': '#3498db',
                        'color': '#fff'
                    });
                }else if (data.quantity_1 <= 3 && data.quantity_1 >= 1){
                    $(row).css({
                        'background-color': '#95a5a6',
                        'color': '#fff'
                    });
                }
            }

        }
    });

    if($('#user_type').val() == 3){
        product.columns(5).visible(false);
    }


    $('#search').on('input',function () {
        product.search(this.value).draw();
    })
});

//New error event handling has been added in Datatables v1.10.5
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.log(message);
    var allied = $('#allied-list').DataTable();
    allied.ajax.reload();
};