$('document').ready(function(){
    var BASEURL = $('#baseURL').val();

    var product = $('#allied-list').DataTable({
        ajax: BASEURL + '/getProducts',
        order: [],
        iDisplayLength: 12,
        bLengthChange: false,
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
            { data: 'quantity_1',"orderable": false },
            { data: 'unit_price',"orderable": false }
        ],
        "createdRow": function ( row, data, index ) {
            if($('#user_type').val() != 3){
                if (data.quantity_1 == 0) {
                    $(row).css({
                        'background-color': '#e74c3c',
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

    $('#searchBy').on('change',function () {
        $('#search').val('')
        product.search( '' )
            .columns().search( '' )
            .draw();

    })

    $('#search').on('input',function () {
        var searchBy = $('#searchBy option:selected').val();
        if(searchBy == 'All'){
            product.search(this.value).draw();
        }else if(searchBy == 'Brand'){

            product.column(0).search(this.value).draw();
        }else if(searchBy == 'Category'){

            product.column(1).search(this.value).draw();
        }else if(searchBy == 'Code'){

            product.column(2).search(this.value).draw();
        }else if(searchBy == 'Description'){

            product.column(3).search(this.value).draw();
        }

    })
});

//New error event handling has been added in Datatables v1.10.5
$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
    console.log(message);
    var allied = $('#allied-list').DataTable();
    allied.ajax.reload();
};