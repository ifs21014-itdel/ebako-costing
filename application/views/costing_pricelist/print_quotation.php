<html>
    <style type="text/css">
        #content {
            display: table;
        }

        #pageFooter {
            display: table-footer-group;
        }

        #pageFooter:after {
            counter-increment: page;
            content: counter(page) " of " counter(pages);
        }

    </style>
    <?php
    //  var_dump($quotation);
    // echo "<hr>";
    //  var_dump($quo_item);
    //exit();
    //   $insurance=$_REQUEST['insurance'];

    $insurance = $quotation[0]->insurance;
    ?>
    <body style="margin-top: 10px">
        <div id="content">
            <table>
                <thead>
                    <tr>
                        <td>
                            <div style="text-align: left;">
                                <table celpadding="0" cellspacing="0" style="border:0px solid black;width:100%">
                                    <thead>
                                        <tr>
                                            <th style="border:0px solid #000;padding: 5px;max-width: 150px;width: 150px;word-wrap:break-word;" align="left">
                                                <b>PT EBAKO NUSANTARA</b><br>
                                                <font size="2" face="courier">Jl. Terboyo Industri Blok N-3C <br>
                                                Kawasan Industri Terboyo Semarang - Indonesia<br>
                                                Telp. 62.24.6593407 Fax. 62.24.6591732
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <table celpadding="0" cellspacing="0" style="border:0px solid black;width:100%;font-size: 12px;font-family:Verdana,Georgia,Serif;" ">
                                    <thead>
                                        <tr style="border-bottom:1px solid black;">
                                            <td style="border-bottom:1px solid black;width: 10%;" align="left">
                                                To
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 30%;" align="left">
                                                <?php echo $quotation[0]->to_cp; ?>
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 10%;" align="left">
                                                From
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 30%;" align="left">
                                                Costing Department
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom:1px solid black;width: 10%;" align="left">
                                                Company
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 30%;" align="left">
                                                <?php echo $quotation[0]->cust_name; ?>
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 20%;" align="left">
                                                Date
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 30%;" align="left">
                                                <?php
                                                echo date('d M Y', strtotime($quotation[0]->quo_date));
                                                if ($quotation[0]->prev_quo_date != null)
                                                    echo "<br><font color=red size=2>Prev date :" . date('d M Y', strtotime($quotation[0]->prev_quo_date)) . "</font>";
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-bottom:1px solid black;width: 10%;" align="left">
                                                Fax No
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 30%;" align="left">

                                            </td>
                                            <td style="border-bottom:1px solid black;width: 20%;" align="left">
                                                Total Page(<font size=3>s</font>)
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 30%;" align="left">
                                                <!--<div id="pageFooter"> </div>-->
                                                <?php
                                                $page = (int) (round(count($quo_item) / 3));
                                                if ($page == 0)
                                                    $page = 1;
                                                echo $page;
                                                ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="border-bottom:1px solid black;width: 10%;" align="left">
                                                Reference
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 10%;" align="left" >

                                                <?php
                                                //echo strip_tags($quotation[0]->reference); 
                                                $ref = strip_tags($quotation[0]->reference);
                                                $ref = str_replace("!=!", "&", $ref);
                                                $ref = str_replace("=!=", "#", $ref);
                                                print_r($ref);
                                                ?>
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 10%;" align="left">
                                                Payment Term
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 1%;" align="left">
                                                :
                                            </td>
                                            <td style="border-bottom:1px solid black;width: 30%;" align="left">
                                                <?php echo $quotation[0]->pterm; ?>
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <!--</div>-->
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <table celpadding="0" cellspacing="0" style="border:0px solid black;width:100%;font-size: 11px;font-family:Verdana,Georgia,Serif;" class="page">
                                <caption>
                                    <h2 onclick="show_hide_header()" style="cursor: pointer;">QUOTATION - No. 
                                        <?php echo $quotation[0]->quotation_number; ?></h2></caption>
                                <thead>
                                    <tr style="background-color: #dfdfe1;page-break-inside:avoid; page-break-after:auto;">
                                        <th style="border:1px solid black;"><b>No.</b></th>

                                        <th style="border:1px solid black;">Model / Sketch</th>
                                        <th style="border:1px solid #000;padding: 5px;max-width: 70px;width: 70px;word-wrap:break-word;">Finishes</th>
                                        <?php if (isset($quotation[0]->parent_sales_quotes_id) && (int) $quotation[0]->parent_sales_quotes_id !== 0): ?>
                                            <th style="border:1px solid black;">FOB Price Before</th>
                                        <?php endif; ?>
                                        <th style="border:1px solid #000;padding: 5px;max-width: 150px;width: 150px;word-wrap:break-word;" >Unit Price (USD, FOB Semarang)</th>
                                        <th style="border:1px solid black;">Quantity</th>
                                        <th style="border:1px solid black;">Remarks</th>

                                    </tr>
                                </thead>
                                <?php
                                //exit;
                                $no = 0;
                                $selected_model = array();
                                //var_dump($costing);
                                // echo count($costing);
                                foreach ($quo_item as $result) {
                                    $before = $this->model_costing->select_item_by_quotationid($quotation[0]->parent_sales_quotes_id, $result->costingid);
                                    // print_r($before);
                                    $no += 1;
                                    ?>
                                    <tr valign="top" style="background-color: <?php echo $no % 2 == 0 ? "#fbfbfb" : "#fff" ?>;">
                                        <td style="border:1px solid #000;padding: 5px;" align="center" valign="middle"><?php echo $no; ?></td>

                                        <td style="border:1px solid #000;padding: 5px;max-width: 390px;width: 390px;max-height: 150px;height: 150px;word-wrap:break-word;vertical-align: bottom;"> 
                                    <center><img src=" <?php echo base_url() ?>/files/<?php echo @$result->filename; ?>" class="miniaction" 
                                                 onclick="model_imageview('<?php echo @$result->filename; ?>')" 
                                                 style="max-width: 30%;"></center>
                                    <!--style="max-width: 150px;width: 150px;max-height: 150px;height: 150px;"></center>-->
                                    <?php
                                    echo "<font color=blue size=2><center>" . $result->custcode . "</center></font><font size=2><br> " . $result->code . "<br> " . $result->model_desc;
                                    echo '<br>W' . number_format(($result->dw / 25.4), 2) . '" x ';
                                    echo 'D' . number_format(($result->dd / 25.4), 2) . '" x ';
                                    echo 'H' . number_format(($result->dht / 25.4), 2) . '"';
                                    echo '<br>W' . number_format(($result->dw) / 10, 2) . ' x ';
                                    echo 'D' . number_format(($result->dd) / 10, 2) . ' x ';
                                    echo 'H' . number_format(($result->dht) / 10, 2) . ' cm';
                                    ?> 
                            </td>
                            <td style="border:1px solid #000;padding: 5px;width: 40px;max-width: 40px;" align="center" valign="middle"> 
                                <?php
                                if (count($before) > 0) {
                                    if ($before[0]->q_finishes != $result->q_finishes)
                                        echo "<font color=red>";
                                }
                                echo $result->q_finishes;
                                ?> 
                            </td>
                             <?php if (isset($quotation[0]->parent_sales_quotes_id) && (int) $quotation[0]->parent_sales_quotes_id !== 0): ?>      
                            <td style="border:1px solid #000;padding: 5px;" align="center" valign="middle"> 
                                <?php
                                if ($insurance > 0) {
                                    $result->  fob_price_before = ($result->  fob_price_before) / ((100 - $insurance) * 0.01);
                                }
                                echo number_format(round($result->  fob_price_before)) . ".00";
                                ?> 
                            </td>
                             <?php endif; ?>
                            <td style="border:1px solid #000;padding: 5px;" align="center" valign="middle"> 
                                <?php
                                if ($insurance > 0) {
                                    $result->fob_price = ($result->fob_price) / ((100 - $insurance) * 0.01);
                                }
                                echo number_format(round($result->fob_price)) . ".00";
                                ?> 
                            </td>
                            <td style="border:1px solid #000;padding: 5px;" align="center" valign="middle"> 
                                <?php
                                // Tampilkan quantity dari data result
                                echo $result->quantity;
                                ?> 
                            </td>
                            <td style="border:1px solid #000;padding: 5px;max-width: 450px;width: 450px;max-height: 230px;height: 230px;word-wrap:break-word;"  valign="middle"> 
                                <table width="100%" celpadding="0" cellspacing="0" style="border-collapse: collapse;border:0px solid black;font-size: 11px;font-family:Verdana,Georgia,Serif;page-break-inside:auto;word-wrap:break-word;">
                                    <thead style="word-wrap:break-word;">
                                        <?php
                                        if (count($before) > 0) {

                                            if ($before[0]->fob_price != $result->fob_price) {
                                                ?>
                                                <tr>
                                                    <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" ><font color=red>Previous Price</font></td>
                                                    <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                    <td style="border:0px solid #000;padding: 5px;max-width: 60%;width: 60%;word-wrap:break-word;" >
                                                        <font color=red><?php
                                                        if ($insurance > 0) {
                                                            $before[0]->fob_price = ($before[0]->fob_price) / ((100 - $insurance) * 0.01);
                                                        }
                                                        echo "USD ".round($before[0]->fob_price). ".00";
                                                        ?> </font>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        if ($_REQUEST['wood'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Wood</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 60%;width: 60%;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->q_wood != $result->q_wood)
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_wood;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['veneer'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Veneer</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->q_veneer != $result->q_veneer)
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_veneer . " - Veneer thickness: 0.6mm (not advisable for wirebrush/sandblast) ";
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['upstype'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Upholstery Type</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->q_upholstery_type != $result->q_upholstery_type)
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_upholstery_type;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['ship_conf'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Shipping Config</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->q_shipping_conf != $result->q_shipping_conf)
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_shipping_conf;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['fabric'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Fabric</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if (trim($before[0]->q_fabric) != trim($result->q_fabric))
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_fabric;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['leather'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Leather</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if (trim($before[0]->q_leather) != trim($result->q_leather))
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_leather;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['packing'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Packing</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->q_packing != $result->q_packing)
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_packing;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['qtypp'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Qty per Packing</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->q_qty_perbox != $result->q_qty_perbox)
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_qty_perbox;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['other'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 550px;width: 550px;word-wrap:break-word;" >Others</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
//                                                        echo "-".$before[0]->q_other_remarks."-=-".$result->q_other_remarks."-<hr>";
//                                                        if ($before[0]->q_other_remarks == $result->q_other_remarks)
//                                                            echo "sama";
//                                                        else
//                                                            echo "beda";
                                                        if (trim($before[0]->q_other_remarks) != trim($result->q_other_remarks))
                                                            echo "<font color=red>";
                                                    }
                                                    echo $result->q_other_remarks;
                                                    ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['box_dim'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Box Dimension</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->cw != $result->cw || $before[0]->cd != $result->cd || $before[0]->ch != $result->ch)
                                                            echo "<font color=red>";
                                                    }
                                                    ?> 
                                                    <?php echo 'W' . number_format(($result->cw / 25.4), 2) . '"'; ?> x
                                                    <?php echo 'D' . number_format(($result->cd / 25.4), 2) . '"'; ?> x
                                                    <?php echo 'H' . number_format(($result->ch / 25.4), 2) . '"'; ?> 
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        if ($_REQUEST['cube'] == 'true') {
                                            ?>
                                            <tr>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >Cube</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 50px;width: 50px;word-wrap:break-word;">:</td>
                                                <td style="border:0px solid #000;padding: 5px;max-width: 750px;width: 750px;word-wrap:break-word;" >
                                                    <?php
                                                    if (count($before) > 0) {
                                                        if ($before[0]->cw != $result->cw || $before[0]->cd != $result->cd || $before[0]->ch != $result->ch)
                                                            echo "<font color=red>";
                                                    }
                                                    ?> 
                                                    <?php echo number_format(((($result->ch / 25.4) * ($result->cw / 25.4) * ($result->cd / 25.4)) / 1728), 2) . ' CBF'; ?> 
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </thead>
                                </table>
                            </td>
                        </tr>
                        <?php
                        if ($no % 3 == 0 && $no > 3) {
                            // echo $no  . "=>" . ($no % 2)  . "<br>";
                            echo "<p style='page-break-before: always'>";
                        }
                    }
                    ?>

            </table>
        </td>
    </tr>
</tbody>

<!--<tfoot id="pageFooter"></tfoot>-->
</table>
</div>
</body>
<script>
    const parentSalesQuotesId = Number(<?= json_encode($quotation[0]->parent_sales_quotes_id) ?>);
    console.log("parent_sales_quotes_id:", parentSalesQuotesId);
    console.log("Apakah !== 0 ?", parentSalesQuotesId !== 0);
</script>


</html>