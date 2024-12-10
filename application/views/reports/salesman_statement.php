<div class="card card-block">
    <div class="card-body">
        <form method="post" id="product_action" class="form-horizontal">
            <div class="grid_3 grid_4">
                <h4>Salesman Statement</h4>
                <hr>
                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"
                           for="pay_cat">Salesman</label>

                    <div class="col-sm-6">
                        <select name="pay_acc" class="form-control">
                            <?php
                            foreach ($deliveryBoys as $row) {
                                $cid = $row['boy_id'];
                                $name = $row['boy_name'];
                                echo "<option value='$cid'>$name</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control required sameday"
                               placeholder="Start Date" name="sdate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control required"
                               placeholder="End Date" name="edate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="edate"><?php echo $this->lang->line('Group Products') ?></label>

                    <div class="col-sm-4">
                        <select name="isGroupedProducts" class="form-control">
                            <option value="no" selected>No</option>
                            <option value="yes">Yes</option>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"></label>

                    <div class="col-sm-9">
                        <input type="hidden" name="check" value="ok">
                        <input type="hidden" name="totalDue" value="yes">
                        <input type="submit" id="calculate_salesastatement" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Calculate') ?>"
                               data-loading-text="Calculating...">
                        <input type="submit" id="calculate_profitastatement" class="btn btn-success margin-bottom"
                               value="Calculate Profit"
                               data-loading-text="Calculating...">
                        <input type="submit" id="calculate_salesman_totaldue" class="btn btn-success margin-bottom"
                               value="Total Due"
                               data-loading-text="Calculating...">
                        <input type="submit" id="calculate_salesman_totaldue_inrange" class="btn btn-success margin-bottom"
                               value="Due In Range"
                               data-loading-text="Calculating...">
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
<div class="card card-block">
    <div class="card-body">
        <div id="param1">

        </div>
    </div>
</div>

<script type="text/javascript">
    $("#calculate_salesastatement").click(function (e) {
        e.preventDefault();
        var isGroupedProducts = $('select[name="isGroupedProducts"]').val() == "yes";
        var actionurl = baseurl + 'reports';
        if(isGroupedProducts) {
            actionurl += '/salesStatementCalcGrouped';
        } else {
            actionurl += '/salesStatementCalc';
        }
        actionCaculate(actionurl);
    });
    $("#calculate_profitastatement").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'reports/profitBySalesmanCalc';
        actionCaculate(actionurl);
    });
    $("#calculate_salesman_totaldue").click(function (e) {
        e.preventDefault();
        $('input[name="totalDue"]').val('yes');
        var actionurl = baseurl + 'reports/totalDueBySalesmanCalc';
        actionCaculate(actionurl);
    });
    $("#calculate_salesman_totaldue_inrange").click(function (e) {
        e.preventDefault();
        $('input[name="totalDue"]').val('no');
        var actionurl = baseurl + 'reports/totalDueBySalesmanCalc';
        actionCaculate(actionurl);
    });
</script>