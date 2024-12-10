<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #<?php echo $invoice['tid'] ?></title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
        }

        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 8pt;
        }

        #printbox {
            width: 280px;
            margin: 5pt;
            padding: 5px;
            text-align: justify;
        }

        #printBox p {
            margin: 0pt;
            padding: 0px 0px 20px 0px;
            font-size: 8pt;
            text-align: center;
        }

        #printBox .header {
            margin: 0pt;
            text-align: center;
        }

        .inv_info {
            width: 100%;
        }

        .inv_info tr td {
            padding-right: 10pt;
        }

        .product_row {
            margin: 15pt;
        }

        .stamp {
            margin: 5pt;
            padding: 3pt;
            border: 3pt solid #111;
            text-align: center;
            font-size: 20pt;
            
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .cname{
            font-weight: bold;
            margin: 0;
        }
    </style>
</head>
<body dir="<?= LTR ?>">
<!-- <h3 id="logo" class="text-center"><br><img style="max-height:50px;" src='<?php $loc = location($invoice['loc']);
    echo FCPATH . 'userfiles/company/' . $loc['logo'];
    ?>' alt='Logo'></h3> -->
    
<div id='printbox'>
    <!-- <h2 class="header"><?= $loc['cname'] ?></h2> -->
    <h3 class="cname text-center"><?= $loc['cname'] ?></h3>
    <div class="text-center">freshkaka.com | +918114408411</div>
    <!-- <div class="text-center"><?= $loc['address'] ?>, <?= $loc['city'] ?>, <?= $loc['country'] ?></div> -->
    <br/>
    <table class="inv_info">
        <?php   if ($loc['taxid']) {      ?> <tr>
            <td><?php echo ' GSTIN '  ?></td>
            <td><?php echo $loc['taxid'] ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td><?php echo $this->lang->line('Invoice') ?></td>
            <td><?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] ?></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('Inv Date') ?></td>
            <td><?php date_default_timezone_set('Asia/Kolkata');
            echo dateformat($invoice['invoicedate']) . ' ' . date('h:i:s A') ?><br></td>
        </tr>
        <tr>
            <td><?php echo $this->lang->line('Customer') ?></td>
            <td><?php echo $invoice['name']; ?></td>
        </tr>
        <?php if(!empty(trim($invoice['address']))) { 
            echo '<tr><td>Shipping Address</td><td>' . $invoice['address'] . '</td></tr>'; 
        }
        ?>
        
        <?php if(!empty(trim($invoice['phone']))) { 
            echo '<tr><td>Phone</td><td>' . $invoice['phone'] . '</td></tr>'; 
        }
        ?>
        
    </table>
    <hr>
    <table id="products">
        <tr class="product_row">
            <td><b> <?php echo $this->lang->line('Description') ?></b></td>
            <td><b><?php echo $this->lang->line('Qty') ?>&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            <td><b><?php echo $this->lang->line('Rate') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
            <td><b><?php ?>GST%&nbsp;</b></td>
            <td><b><?php echo $this->lang->line('Tax') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
        </tr>
        <tr>
            <td colspan="5">
                <hr>
            </td>
        </tr>
        <?php
        $this->pheight = 0;
        foreach ($products as $row) {
            // $keys = array_keys($row);
            // foreach($keys as $key){
            //     echo '<tr> <td>' . $key . '</td> </tr>';
            // }
            // foreach ($row as $item) {
            //     echo '<tr> <td>' . $item . '</td> </tr>';
            // }

            // loc
            //             id/cname/address/city/regio
            // n/country/postbox/phone/email/ta
            // xid/logo/curwareext


    /* <h2 style="margin-top:0" class="text-center"><?=  $keys = array_keys($loc);
    // foreach($keys as $key){
    //     echo '<span>' . $key . '</span>';
    // } ?></h2>*/

            
            $this->pheight = $this->pheight + 8;
            $proName = str_replace('-'.$row['code'], '' ,$row['product']);
            echo '<tr>
            <td >' . $proName . '</td>
             <td>' . +$row['qty'] . ' ' . $row['unit'] . '</td>
            <td>' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
            <td> ' . $row['tax'] . '</td>
            <td> ' . amountExchange($row['totaltax']) . '</td>
        </tr><tr><td colspan="3">&nbsp;</td></tr>';
        } ?>
    </table>
    <?php   
        if (!empty($taxgrp)) {    
        echo '<hr>';
        }
    ?>
    <table class="inv_info">
        <?php   
            if (!empty($taxgrp)) {    
            echo '<tr class="product_row"><td><b> Rate</b></td><td><b>Taxable Amount</b></td><td class="text-right"><b>Tax</b></td></tr>';
            }
        ?>
        <?php
        $kyy = array_keys($taxgrp); 
        foreach($kyy as $key){
            $row_line =  '<tr> <td>' . $key . '</td>';
            $summ = 0;
            $taxablesumm = 0;
            foreach($taxgrp[$key] as $val){
                $summ += $val['tax'];
                $taxablesumm += $val['taxable'];
            }
            $row_line .= '<td>' . amountExchange($taxablesumm, $invoice['multi'], $invoice['loc']) . '</td><td class="text-right">' . amountExchange($summ, $invoice['multi'], $invoice['loc']). '</td> </tr>';
            if($summ != 0){
                echo $row_line;
            }
        }
        ?>
    </table>
    <hr>
    <table class="inv_info">
        <?php if ($invoice['taxstatus'] == 'cgst') {
            $gst = $row['totaltax'] / 2;
            $rate = $row['tax'] / 2;
            ?>
            <tr>
                <td><b><?php echo $this->lang->line('CGST') ?></b></td>
                <td class="text-right"><b><?php echo amountExchange($gst, $invoice['multi'], $invoice['loc']) ?></b> (<?= $rate ?>%)</td>
            </tr>
            <tr>
                <td><b><?php echo $this->lang->line('SGST') ?></b></td>
                <td class="text-right"><b><?php echo amountExchange($gst, $invoice['multi'], $invoice['loc']) ?></b> (<?= $rate ?>%)</td>
            </tr>
        <?php } else if ($invoice['taxstatus'] == 'igst') {
            ?>
            <tr>
                <td><b><?php echo $this->lang->line('IGST') ?></b></td>
                <td class="text-right"><b><?php echo amountExchange($invoice['tax'], $invoice['multi']) ?></b>
                    (<?= amountFormat_general($row['tax']) ?>%)
                </td>
            </tr>
        <?php } ?>
        <tr>
            <td><b><?php echo $this->lang->line('Total Tax') ?></b></td>
            <td class="text-right"><b><?php echo amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) ?></b></td>
        </tr>
        <?php if($invoice['discount'] != 0){ ?>
            <tr>
            <td><b><?php echo $this->lang->line('Total Discount') ?></b></td>
            <td class="text-right"><b><?php echo amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) ?></b></td>
        </tr>
        <?php } ?>
        

        <?php if($invoice['shipping'] != 0) { 
            echo '<tr><td><b>Shipping</b></td><td class="text-right"><b>' . amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) . '</b></td></tr>'; 
        }
        ?>
        <tr>
            <td><b><?php echo $this->lang->line('Total') ?></b></td>
            <td class="text-right"><b><?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?></b></td>
        </tr>

        <?php
        if ($round_off['other']) {
            $final_amount = round($invoice['total'], $round_off['active'], constant($round_off['other']));
            ?>
            <tr>
                <td><b><?php echo $this->lang->line('Total') ?></b>(<?php echo $this->lang->line('Round Off') ?>)</td>
                <td class="text-right"><b><?php echo amountExchange($final_amount, $invoice['multi'], $invoice['loc']) ?></b></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <hr>
    <div class="text-center">  <?php echo $this->lang->line('Thank you') ?></div>
    <?php if (@$qrc AND $invoice['status'] != 'paid') {

        $this->pheight = $this->pheight + 40;
        ?>
         <div class="text-center">
            <small><?php echo $this->lang->line('Scan & Pay')?></small>
    </div>
        <div class="text-center">
            <img width="140px" height="140px" src='<?php echo base_url('userfiles/pos_temp/qrcode/qrcode.jpeg') ?>' alt='QR'></div>
    <?php } else {
        echo '<div class="stamp">' . $this->lang->line(ucwords($invoice['status'])) . '</div>';
    } ?>
</div>
</body>
</html>
