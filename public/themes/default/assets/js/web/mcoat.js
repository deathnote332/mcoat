$('document').ready(function(){
    var BASEURL = $('#baseURL').val();


    var product = $('#mcoat-list').DataTable({
        ajax: BASEURL + '/getProducts',
        order: [],
        iDisplayLength: 10,
        bLengthChange: false,
        bInfo: false,
        deferRender: true,
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
            { data: 'quantity',"orderable": false },
            { data: 'unit_price',"orderable": false }
        ],
        "createdRow": function ( row, data, index ) {
            if($('#user_type').val() != 3){
                if (data.quantity == 0) {
                    $(row).css({
                        'background-color': '#3498db',
                        'color': '#fff'
                    });
                }else if (data.quantity <= 3 && data.quantity >= 1){
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
    var mcoat = $('#mcoat-list').DataTable();
    mcoat.ajax.reload();
};