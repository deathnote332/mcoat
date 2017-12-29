{!! Theme::asset()->usePath()->add('reset.js','/js/web/reset.js') !!}
<div class="panel-body">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" id="tab-productout">
        <li class="active"><a href="#mcoat" data-toggle="tab" data-id="1">MCOAT</a>
        </li>
        <li><a href="#allied" data-toggle="tab" data-id="2">ALLIED</a>
        </li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content pad_top_30">
        <div class="tab-pane fade in active" id="mcoat">

        </div>
        <div class="tab-pane fade" id="allied">

        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <table id="reset-list" class="table table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Reset By</th>
                    <th>Message</th>
                    <th>Date resetted</th>
                    <th>Action</th>
                </tr>
                </thead>

            </table>
        </div>
    </div>
</div>
