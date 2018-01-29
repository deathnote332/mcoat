<!-- Modal -->
<div class="modal fade" id="edit-day-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <form id="daily-edit-sale">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">

                                <label><h3 id="day"></h3></label>
                                <input type="hidden" name="_date" id="_date" value="">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Receipt no.</label>
                                <input class="form-control" id="receipt_no" name="receipt_no"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Total Sales</label>
                                <input class="form-control" id="total_amount" name="total_amount"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Bank Deposit</label>
                                <input class="form-control" id="deposit_amount" name="deposit_amount"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Taken</label>
                                <input class="form-control" id="taken_amount" name="taken_amount"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Expense Total</label>
                                <input class="form-control" id="expenses_amount" name="expenses_amount"/>
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="form-group">
                                <label>Expense Description</label>
                                <input class="form-control" id="expenses_description" name="expenses_description"/>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btn-update">Update</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
