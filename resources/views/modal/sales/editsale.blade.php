<style>


    .margin_top{
        margin-top: 8px;
    }
    .margin_bottom{
        margin-bottom: 8px;
        padding-right: 0;
    }

    .number-ctr{
        padding: 10px;
        font-weight: 600;
    }


    /*steps*/

    #steps{
        padding-bottom: 20px;
    }

    .step-steps{
        width: 30%;
        float: left;
        display: block !important;
    }

    .step-app > .step-content{
        width: 65%;
        float: left;
        border: none;
    }

    .step-footer{
        position: absolute;
        bottom: 0;
        right:30px;
    }



    .step-app > .step-steps > li > a{
        padding: 15px;
        font-size: 14px;
    }
</style>
<!-- Modal -->
<div class="modal fade" id="edit-day-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div class="col-md-12">
                    <h4 class="modal-title" id="myModalLabel"><strong>DAILY SALES REPORT</strong> </h4>

                </div>
                <div class="col-md-12">
                    <h5 class="modal-title" id="myModalLabel">BRANCH: <strong> CDJ PASIG</strong></h5>

                </div>
                <div class="col-md-8">
                    <h5 class="modal-title" id="myModalLabel">ADDRESS: <strong> 108 R. Jabson St. Bambang, Pasig City</strong></h5>

                </div>
                <div class="col-md-4">
                    <h5 class="modal-title" id="myModalLabel">DATE: <strong id="_date"> Jan 1, 2018</strong></h5>

                </div>

            </div>

            <form id="daily-edit-sale">
                <div class="modal-body">
                    <div id="steps">
                        <div class="step-app clearfix" >
                            <ul class="step-steps clearfix">
                                <li><a href="#step1">1. With Receipt</a></li>
                                <li><a href="#step2">2. Without Receipt</a></li>
                                <li><a href="#step3">3. Credit Collection</a></li>
                                <li><a href="#step4">4. Expenses</a></li>
                                <li><a href="#step5">5. Item Returns</a></li>
                                <li><a href="#step6">6. Cash Breakdown</a></li>
                                <li><a href="#step7">7. Taken</a></li>
                            </ul>
                            <div class="step-content clearfix">
                                <div class="step-tab-panel" id="step1">
                                    <div class="col-md-6 margin_bottom"><h4>Total: <span class="total">123</span></h4></div>
                                    <div class="col-md-6 margin_bottom text-right">
                                        <button type="button" class="btn btn-primary" id="add-w-rec">Add more</button>
                                    </div>
                                    <div class="row margin_top">

                                        <div class="col-md-1 ">
                                            <div class="number-ctr">1.</div>
                                        </div>
                                        <div class="col-md-6">

                                            <input type="text" class="form-control" name="with_receipt[0][rec_no]" placeholder="Receipt no.">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="with_receipt[0][rec_amount]" placeholder="Amount">
                                        </div>

                                    </div>
                                </div>
                                <div class="step-tab-panel" id="step2">
                                    <div class="col-md-6 margin_bottom"><h4>Total: <span class="total">123</span></h4></div>

                                    <div class="col-md-6 margin_bottom text-right">
                                        <button type="button" class="btn btn-primary" id="add-wo-rec">Add more</button>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-1">
                                            <div class="number-ctr">1.</div>
                                        </div>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control" name="without_receipt[0][amount]" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-tab-panel" id="step3">
                                    <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                        <button type="button" class="btn btn-primary" id="add-credit">Add more</button>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-1">
                                            <div class="number-ctr">1.</div>
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="credit[0][company]" placeholder="Company">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="credit[0][bank_name]" placeholder="Bank Name">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" name="credit[0][bank]" placeholder="Bank Number">
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" class="form-control" name="credit[0][amount]" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-tab-panel" id="step4">
                                    <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                        <button type="button" class="btn btn-primary" id="add-expense">Add more</button>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-1">
                                            <div class="number-ctr">1.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="expense[0][details]" placeholder="Details">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="expense[0][amount]" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-tab-panel" id="step5">
                                    <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                        <button type="button" class="btn btn-primary" id="add-return">Add more</button>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-1">
                                            <div class="number-ctr">1.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="return[0][name]" placeholder="Name">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="return[0][amount]" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="step-tab-panel" id="step6">
                                    <div class="row margin_top">
                                        <div class="col-md-2">
                                            <div class="number-ctr">1000*</div>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="amount_1000" placeholder="Pieces">
                                        </div>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-2">
                                            <div class="number-ctr">500*</div>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="amount_500" placeholder="Pieces">
                                        </div>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-2">
                                            <div class="number-ctr">100*</div>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="amount_100" placeholder="Pieces">
                                        </div>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-2">
                                            <div class="number-ctr">50*</div>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="amount_50" placeholder="Pieces">
                                        </div>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-2">
                                            <div class="number-ctr">20*</div>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="amount_20" placeholder="Pieces">
                                        </div>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-2">
                                            <div class=" number-ctr">Coins* </div>
                                        </div>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="amount_coins" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="step-tab-panel" id="step7">
                                    <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                        <button type="button" class="btn btn-primary" id="add-taken">Add more</button>
                                    </div>
                                    <div class="row margin_top">
                                        <div class="col-md-1 ">
                                            <div class="number-ctr">1.</div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="taken[0][name]" placeholder="Name">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="taken[0][amount]" placeholder="Amount">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="step-footer clearfix">
                                <button data-direction="prev" class="btn btn-primary">Previous</button>
                                <button data-direction="next" class="btn btn-primary">Next</button>
                                <button data-direction="finish" class="btn btn-primary">Finish</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    $(document).ready(function () {




        $("#steps").steps({
            onInit: function () {

            },
            onFinish: function () {
                saveDailyAdmin($('#_date').text())

            }
        });


        $('.close').on('click',function () {
            $("#steps").steps().destroy;
        })




        function saveDailyAdmin(day) {
            var BASEURL = $('#baseURL').val();

            swal.queue([{
                title: 'Are you sure',
                text: "You want to save this record.",
                type:'warning',
                showLoaderOnConfirm: true,
                showCancelButton: true,
                allowOutsideClick: false,
                closeOnConfirm: false,
                confirmButtonText: 'Okay',
                confirmButtonColor: "#DD6B55",
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        var data_save = $('#daily-edit-sale').serializeArray();
                        data_save.push({ name : "_token", value: $('meta[name="csrf_token"]').attr('content')})
                        data_save.push({ name : "_date", value: day })
                        data_save.push({ name : "branch_id", value: $('#branch_id').val() })
                        $.ajax({
                            url:BASEURL+"/admin/editsale",
                            type:'POST',
                            data: data_save,
                            success: function(data){
                                swal.insertQueueStep(data)
                                resolve()
                                $('#edit-day-modal').modal('hide')
                                location.reload()
                            }
                        });
                    })
                }
            }])
        }


        //add with receipt
        $('body').delegate('#add-w-rec','click',function () {


            var ctr = $('#step1').find('.margin_top').length + 1

            $('#step1').append('<div class="row margin_top">' +
                '<div class="col-md-1 ">' +
                '<div class="number-ctr">'+ ctr +'.</div>' +
                '</div>' +
                '<div class="col-md-6">' +
                '<input type="text" class="form-control" name="with_receipt['+ (ctr - 1)+'][rec_no]" placeholder="Receipt no."></div>' +
                '<div class="col-md-5">' +
                '<input type="text" id="w-amount" class="form-control" name="with_receipt['+ (ctr - 1)+'][rec_amount]" placeholder="Amount"></div>' +
                '</div>');


            //numeric input
            $('#taken-amount,#return-amount,#expense-amount,#credit-amount,#w-amount,#wo-amount').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

        })
        //add wo receipt
        $('body').delegate('#add-wo-rec','click',function () {
            var ctr = $('#step2').find('.margin_top').length + 1
            $('#step2').append('<div class="row margin_top">' +
                '<div class="col-md-1">' +
                '<div class="number-ctr">'+ ctr +'.</div></div>' +
                '<div class="col-md-11">' +
                '<input type="text" class="form-control" id="wo-amount" name="without_receipt['+ (ctr - 1)+'][amount]" placeholder="Amount"></div>' +
                '</div>')
            //numeric input
            $('#taken-amount,#return-amount,#expense-amount,#credit-amount,#w-amount,#wo-amount').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

        })
        //add credit
        $('body').delegate('#add-credit','click',function () {
            var ctr = $('#step3').find('.margin_top').length + 1
            $('#step3').append('<div class="row margin_top">' +
                '<div class="col-md-1">' +
                '<div class="number-ctr">' + ctr +'.</div></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="credit['+ (ctr - 1)+'][company]" placeholder="Company"></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="credit['+ (ctr - 1)+'][bank_name]" placeholder="Bank Name"></div>' +
                '<div class="col-md-3"><input type="text" class="form-control" name="credit['+ (ctr - 1)+'][bank]" placeholder="Bank Number"></div>' +
                '<div class="col-md-2"><input type="text" id="credit-amount" class="form-control" name="credit['+ (ctr - 1)+'][amount]" placeholder="Amount"></div>' +
                '</div>')
            //numeric input
            $('#taken-amount,#return-amount,#expense-amount,#credit-amount,#w-amount,#wo-amount').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

        })
        //add expense
        $('body').delegate('#add-expense','click',function () {
            var ctr = $('#step4').find('.margin_top').length + 1
            $('#step4').append('<div class="row margin_top">' +
                '<div class="col-md-1 "><div class="number-ctr">' + ctr +'.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="expense['+ (ctr - 1)+'][details]" placeholder="Details"></div>' +
                '<div class="col-md-5"><input type="text" id="expense-amount" class="form-control" name="expense['+ (ctr - 1)+'][amount]" placeholder="Amount"></div>' +
                '</div>')
            //numeric input
            $('#taken-amount,#return-amount,#expense-amount,#credit-amount,#w-amount,#wo-amount').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});


        })

        //add return
        $('body').delegate('#add-return','click',function () {
            var ctr = $('#step5').find('.margin_top').length + 1
            $('#step5').append('<div class="row margin_top">' +
                '<div class="col-md-1 "><div class="number-ctr">' + ctr +'.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="return['+ (ctr - 1)+'][name]" placeholder="Name"></div>' +
                '<div class="col-md-5"><input type="text" id="return-amount" class="form-control" name="return['+ (ctr - 1)+'][amount]" placeholder="Amount"></div>' +
                '</div>')
            //numeric input
            $('#taken-amount,#return-amount,#expense-amount,#credit-amount,#w-amount,#wo-amount').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});


        })

        //add taken
        $('body').delegate('#add-taken','click',function () {
            var ctr = $('#step7').find('.margin_top').length + 1
            $('#step7').append('<div class="row margin_top">' +
                '<div class="col-md-1"><div class="number-ctr">'+ctr+'.</div></div>' +
                '<div class="col-md-6"><input type="text" class="form-control" name="taken['+ (ctr - 1)+'][name]" placeholder="Name"></div>' +
                '<div class="col-md-5"><input type="text" id="taken-amount" class="form-control" name="taken['+ (ctr - 1)+'][amount]" placeholder="Amount"></div>' +
                '</div>')
            //numeric input
            $('#taken-amount,#return-amount,#expense-amount,#credit-amount,#w-amount,#wo-amount').on('keydown', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});

        })



    })
</script>