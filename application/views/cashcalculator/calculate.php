<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4>Cash Calcultor</h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">


                    
                    <div id="customerpanel" class="form-group pb-1 row">

                        


                        <div class="col-sm-4"><label class="col-form-label"
                                                     for="opening_bal">Opening Balance</label>
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="opening_bal" value="<?= $closing_bal ?>"
                                   onkeypress="return isNumber(event)">
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label" for="payment_gateway">Cashfree</label>
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="payment_gateway" value="0"
                                   onkeypress="return isNumber(event)">

                            <label class="col-form-label" for="wallet">Paytm</label>
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="wallet" value="0"
                                   onkeypress="return isNumber(event)">

                            <label class="col-form-label" for="bank">Bank</label>
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="bank" value="0"
                                   onkeypress="return isNumber(event)">
                        </div>
                        <div class="col-sm-4">
                            <label class="col-form-label" for="income">Income</label>
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="income" value="<?= $todayinexp['credit'] ?>"
                                   onkeypress="return isNumber(event)">
                            <label class="col-form-label" for="expense">Expense</label>
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="expense" value="<?= $todayinexp['debit'] ?>"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label class="col-form-label" for="expected_cash">Expected Cash</label>
                            <input type="number" disabled class="form-control margin-bottom" name="expected_cash" value="0">
                            <input type="number" class="hidden form-control margin-bottom" name="hide_expected_cash" value="0">
                        </div>
                        <div class="col-sm-1 d-flex align-items-end justify-content-center"> 
                            <h2>-</h2>
                        </div>
                        <div class="col-sm-3">
                            <label class="col-form-label" for="actual_cash">Actual Cash</label>
                            <input type="number" id="actual_cash" class="form-control margin-bottom required" name="actual_cash" onkeypress="return isNumber(event)">
                        </div>
                        <div class="col-sm-1"> 
                            
                        </div>
                        <div class="col-sm-4 d-flex align-items-end">
                            <h2 id="risk"></h2>
                            <input type="text" class="d-none form-control margin-bottom" name="risk_type">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <button id="calculate_btn" class="btn btn-success btn-lg margin-bottom">Calculate</button>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <div class="col-sm-3">
                            <label class="col-form-label" for="home_cash">Taken Home</label>
                            <input type="number" id="home_cash" class="form-control margin-bottom" name="home_cash" value="0">
                        </div>
                        <div class="col-sm-3">
                            <label class="col-form-label" for="closing_bal">Closing Cash Balance</label>
                            <input type="number"  disabled class="form-control margin-bottom" name="closing_bal" value="0">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success btn-lg margin-bottom"
                                   value="Save Balance"
                                   data-loading-text="Saving...">
                            <input type="hidden" value="CashCalculator/save_cash" id="action-url">
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        </div>
        <div class="card">
        <div class="card-header">
            <h4>Cash Records</h4>
        </div>
        <div class="card-content">
            <table class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Cash Entry Date</th>
                    <th>Opening Bal</th>
                    <th>Payment Gateway</th>
                    <th>Wallet</th>
                    <th>Bank</th>
                    <th>Income</th>
                    <th>Expense</th>
                    <th>Expected Cash</th>
                    <th>Actual Cash</th>
                    <th>Home Taken</th>
                    <th>Tomorrow Opening Bal</th>
                </tr>
                </thead>
                <tbody id="entries">
                </tbody>


            </table>
        </div>
        <script type="text/javascript">

            $("#calculate_btn").click(function(){
                var opening_bal = $('input[name ="opening_bal"]').val() ? parseInt($('input[name ="opening_bal"]').val()) : 0;
                var payment_gateway = $('input[name ="payment_gateway"]').val() ? parseInt($('input[name ="payment_gateway"]').val()) : 0;
                var wallet = $('input[name ="wallet"]').val() ? parseInt($('input[name ="wallet"]').val()) : 0;
                var bank = $('input[name ="bank"]').val() ? parseInt($('input[name ="bank"]').val()) : 0;
                var income = $('input[name ="income"]').val() ? parseInt($('input[name ="income"]').val()) : 0;
                var expense = $('input[name ="expense"]').val() ? parseInt($('input[name ="expense"]').val()) : 0;
                var totalCash = (opening_bal + income) - (payment_gateway + wallet + bank + expense);
                $('input[name ="expected_cash"]').val(totalCash);
                $('input[name ="hide_expected_cash"]').val(totalCash);
                $('input[name ="actual_cash"]').focus();
                return false;
            });

            $("#actual_cash").on("change paste keyup focus", function() {
                var actual_cash = $(this).val() ? parseInt($(this).val()) : 0; 
                var home_cash = parseInt($('input[name ="home_cash"]').val());
                var diff = actual_cash - home_cash;
                $('input[name ="closing_bal"]').val(diff);

                var expected_cash = parseInt($('input[name ="expected_cash"]').val());
                var diff = expected_cash - actual_cash;
                if(diff > 0) {
                    $('#risk')
                    .removeClass("text-info")
                    .removeClass("text-success")
                    .addClass("text-danger")
                    .text("LOSS by ( Rs. " + (diff) + " )");
                    $('input[name ="risk_type"]').val("LOSS by ( Rs. " + (diff) + " )");
                } else if(diff == 0){
                    $('#risk')
                    .removeClass("text-success")
                    .removeClass("text-danger")
                    .addClass("text-info")
                    .text("Nil");
                    $('input[name ="risk_type"]').val("Nil");
                } else {
                $('#risk')
                    .removeClass("text-info")
                    .removeClass("text-danger")
                    .addClass("text-success")
                    .text("Profit of ( Rs. " + (diff * -1) + " )");
                    $('input[name ="risk_type"]').val("Profit of ( Rs. " + (diff * -1) + " )");
                }
                
            });

            $("#home_cash").on("change paste keyup", function() {
                var actual_cash = parseInt($('input[name ="actual_cash"]').val());
                var home_cash = parseInt($(this).val());
                var diff = actual_cash - home_cash;
                $('input[name ="closing_bal"]').val(diff);
            });
            
            $.ajax({

                url: baseurl + 'CashCalculator/getCash',
                type: 'GET',
                data: '',
                dataType: 'html',
                success: function (data) {
                    $('#entries').html(data);
                },
                error: function (data) {
                }

            });
        </script>
