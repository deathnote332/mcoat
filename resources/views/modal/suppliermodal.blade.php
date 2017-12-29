<!-- Modal -->
<div class="modal fade" id="addToCartModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Supplier</h4>
            </div>
            <form id="supplier">
                <div class="modal-body">
                    <input type="hidden" id="supplier_id" name="id"  value="">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" id="name" name="name"/>
                            </div>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" id="address" name="address"/>
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