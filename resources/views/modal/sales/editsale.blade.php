<style>
    .steps{
        float: left;
        width: 30%;
    }

    .content{
        display: inline;
        float: left;
        margin: 0 2.5% .5em 2.5%;
        width: 65%;
    }


    .wizard ul, .tabcontrol ul {
        list-style: none!important;
        padding: 0;
        margin: 0;
    }


    .wizard.vertical>.steps>ul>li {
        float: none;
        width: 100%;
    }



    .wizard>.steps .disabled a, .wizard>.steps .disabled a:hover, .wizard>.steps .disabled a:active {
        background: #eee;
        color: #aaa;
        cursor: default;
    }



    .wizard>.steps .current a, .wizard>.steps .current a:hover, .wizard>.steps .current a:active {
        background: #2184be;
        color: #fff;
        cursor: default;
    }

    .wizard>.steps .done a, .wizard>.steps .done a:hover, .wizard>.steps .done a:active {
        background: #9dc8e2;
        color: #fff;
    }



    .wizard>.steps a, .wizard>.steps a:hover, .wizard>.steps a:active {
        display: block;
        width: auto;
        margin: 0 .5em .5em;
        padding: 1em 1em;
        text-decoration: none;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }





    .wizard>.steps .current-info, .tabcontrol>.steps .current-info {
        position: absolute;
        left: -999em;
    }
    .number {
        font-size: 1.429em;
    }

    .wizard.vertical>.actions {
        display: inline;
        float: right;
        margin: 0 2.5%;
        width: 95%;
        position: relative;
        text-align: right;
    }

    .wizard>.actions>ul {
        display: inline-block;
        text-align: right;
    }
    
    .wizard.vertical>.actions>ul>li {
        margin: 0 0 0 1em;
        display: inline-block;
    }

    .wizard>.content>.title, .tabcontrol>.content>.title {
        position: absolute;
        left: -999em;
    }

    .wizard>.actions a, .wizard>.actions a:hover, .wizard>.actions a:active {
        background: #2184be;
        color: #fff;
        display: block;
        padding: .5em 1em;
        text-decoration: none;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }




    .wizard>.actions .disabled a, .wizard>.actions .disabled a:hover, .wizard>.actions .disabled a:active {
        background: #eee;
        color: #aaa;
    }

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
                    <h5 class="modal-title" id="myModalLabel">DATE: <strong> Jan 1, 2018</strong></h5>

                </div>

            </div>

            <form id="daily-edit-sale">
                <div class="modal-body">
                    <div id="steps">
                        <h3>With Receipt</h3>
                        <section>
                            <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                <button type="button" class="btn btn-primary">Add more</button>
                            </div>
                            @for($i=1;$i<=5;$i++)

                                    <div class="row margin_top">
                                        <div class="col-md-1 ">
                                            <div class="number-ctr">{{$i}}.</div>
                                        </div>
                                        <div class="col-md-6">

                                            <input type="text" class="form-control" name="rec_no" placeholder="Receipt no.">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                        </div>
                                    </div>
                                @endfor

                        </section>
                        <h3>Without Receipt</h3>
                        <section>
                            <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                <button type="button" class="btn btn-primary">Add more</button>
                            </div>

                            @for($i=1;$i<=5;$i++)

                                <div class="row margin_top">
                                    <div class="col-md-1 number-ctr">
                                        <span>{{$i}}.</span>
                                    </div>
                                    <div class="col-md-11">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                    </div>
                                </div>
                            @endfor
                        </section>
                        <h3>Credit Collection</h3>
                        <section>
                            <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                <button type="button" class="btn btn-primary">Add more</button>
                            </div>

                            @for($i=1;$i<=5;$i++)

                                <div class="row margin_top">
                                    <div class="col-md-1 number-ctr">
                                        <span>{{$i}}.</span>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Company">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Bank Number">
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                    </div>
                                </div>
                            @endfor
                        </section>
                        <h3>Expenses</h3>
                        <section>
                            <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                <button type="button" class="btn btn-primary">Add more</button>
                            </div>

                            @for($i=1;$i<=5;$i++)

                                <div class="row margin_top">
                                    <div class="col-md-1 number-ctr">
                                        <span>{{$i}}.</span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Details">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                    </div>
                                </div>
                            @endfor
                        </section>
                        <h3>Cash Breakdown</h3>
                        <section>
                            <div class="row margin_top">
                                <div class="col-md-1 number-ctr">
                                    <span>1000*</span>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                </div>
                            </div>
                            <div class="row margin_top">
                                <div class="col-md-1 number-ctr">
                                    <span>500*</span>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                </div>
                            </div>
                            <div class="row margin_top">
                                <div class="col-md-1 number-ctr">
                                    <span>100*</span>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                </div>
                            </div>
                            <div class="row margin_top">
                                <div class="col-md-1 number-ctr">
                                    <span>50*</span>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                </div>
                            </div>
                            <div class="row margin_top">
                                <div class="col-md-1 number-ctr">
                                    <span>20*</span>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                </div>
                            </div>
                            <div class="row margin_top">
                                <div class="col-md-1 number-ctr">
                                    <span>Coins*</span>
                                </div>
                                <div class="col-md-11">
                                    <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                </div>
                            </div>
                        </section>
                        <h3>Taken List</h3>
                        <section>
                            <div class="col-md-6 col-md-offset-6 margin_bottom text-right">
                                <button type="button" class="btn btn-primary">Add more</button>
                            </div>
                            @for($i=1;$i<=5;$i++)

                                <div class="row margin_top">
                                    <div class="col-md-1 number-ctr">
                                        <span>{{$i}}.</span>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Name">
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="rec_no" placeholder="Amount">
                                    </div>
                                </div>
                            @endfor
                        </section>
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
            headerTag: "h3",
            bodyTag: "section",
            stepsOrientation: "vertical",
            enableAllSteps: true,
            onFinished: function (event, currentIndex)
            {

                alert()
            }
        });
    })
</script>