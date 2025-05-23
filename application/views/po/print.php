<html>
    <head>
        <title>Print PO</title>
        <?php if ($st == 3 || $st == 2) { ?>
            <STYLE>                
                <!-- 
                @media all {
                    *{
                        padding: 1px;margin: 1px;
                    }
                }

                body,table{
                    font-family:Courier;font-size:13px;
                    ///font-family:sans-serif;font-size:12px;
                }                
                -->        
                @page {
                    size: A4 portrait;
                    margin: 2cm;
                    /*                    size: 9.5in 11in;
                                            size: portrait;
                                            margin: 2cm;*/
                }
            </STYLE>
        <?php } ?>
    </head>
    <body>
        <?php
        if ($st == 3) {
            ?>
            <span style="width: 100%;">
                <?php
            } else {
                ?>
                <span style="width: 800px;">
                    <?php
                }
                ?>
                <table width="100%" border="0">
                    <tr>
                        <td style="border-bottom: 1px #000000 double;">
                            <?php
                            echo $company->name . "<br/>" . nl2br($company->address);
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align='center'>
                            <B><u><FONT SIZE=5 face="Lucida Sans">PURCHASE ORDER</FONT></u><br/><span style="font-style: italic;">ORDER PEMBELIAN<i/></B>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td width="100%">
                            <table width="98%" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr valign="top">
                                    <td width="50%" valign="top">
                                        <table width="100%">
                                            <tr valign="top">
                                                <td width="35%" style="font-weight: bold;">To<br/><i style="font-size: 12px;">Kepada</i></td>
                                                <td width="1%" style="font-weight: bold;">:</td>
                                                <td width="64%" style="font-weight: bold;"><?php echo $po->vendorname ?></td>
                                            </tr>
                                            <tr valign="top">
                                                <td style="font-weight: bold;">Address<br/><i style="font-size: 12px;">Alamat</i></td>
                                                <td>:</td>
                                                <td style="font-weight: bold;"><?php echo nl2br($po->address1) ?></td>
                                            </tr>
                                            <tr valign="top">
                                                <td style="font-weight: bold;">Phone No.<br/><i style="font-size: 12px;">No.Telephone</i></td>
                                                <td style="font-weight: bold;">:</td>
                                                <td style="font-weight: bold;"><?php echo nl2br($po->phone) ?></td>
                                            </tr>
                                            <tr valign="top">
                                                <td colspan="3">
                                                    Please send us the following items: <br/>
                                                    Mohon dikirim barang-barang seperti tersebut dibawah ini:
                                                </td>

                                            </tr>
                                        </table>
                                    </td>
                                    <td width="50%">
                                        <table width="100%">
                                            <tr valign="top">
                                                <td width="35%" style="font-weight: bold;">Order No.<br/><i style="font-size: 12px;">No. Order</i></td>
                                                <td width="1%" style="font-weight: bold;">:</td>
                                                <td width="64%" style="font-weight: bold;"><?php echo $po->ponumber ?></td>
                                            </tr>
                                            <tr valign="top">
                                                <td style="font-weight: bold;">Order Date<br/><i style="font-size: 12px;">Tanggal Order</i></td>
                                                <td style="font-weight: bold;">:</td>
                                                <td style="font-weight: bold;"><?php echo date('d/m/Y', strtotime($po->dates)) ?></td>
                                            </tr>
                                            <tr valign="top">
                                                <td style="font-weight: bold;">Delivery Date.<br/><i style="font-size: 12px;">Tanggal Pengiriman</i></td>
                                                <td style="font-weight: bold;">:</td>
                                                <td style="font-weight: bold;"><?php echo ((!empty($po->deliveryterm) && preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $po->deliveryterm)) ? date('d/m/Y', strtotime($po->deliveryterm)) : $po->deliveryterm); ?></td>
                                            </tr>
                                            <tr valign="top">
                                                <td style="font-weight: bold;">Terms Of Payment.<br/><i style="font-size: 12px;">Pembayaran</i></td>
                                                <td style="font-weight: bold;">:</td>
                                                <td style="font-weight: bold;"><?php echo ((!empty($po->payterm) && preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $po->payterm)) ? date('d/m/Y', strtotime($po->payterm)) : $po->payterm); ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style:"border-collapse:unset;">
                    <thead>
                        <tr>                                
                            <td STYLE="border: 1px solid #000000;" ALIGN=CENTER widtd="1%"><B>NO.<BR><i>No.</i></B></td>
                            <td STYLE="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;padding: 2px;" ALIGN=CENTER widtd="8%"><B>NO. PP<BR><i>No. PP</i></B></td>
                            <td STYLE="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;padding: 2px;" ALIGN=CENTER widtd="8%"><B>Code<BR><i>Kode</i></B></td>
                            <td STYLE="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;padding: 2px;" ALIGN=CENTER widtd="30%"><B>DESCRIPTION<br/><i>Nama Barang</i></B></td>
                            <td STYLE="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;padding: 2px;" ALIGN=CENTER widtd="10%"><B>Qty</B></td>
                            <td STYLE="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;padding: 2px;" ALIGN=CENTER widtd="5%"><B>Unit</B></td>
                            <td STYLE="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;padding: 2px;" ALIGN=CENTER widtd="10%"><B>U/Price</B></td>
                            <td STYLE="border-top: 1px solid #000000;border-bottom: 1px solid #000000;border-right: 1px solid #000000;padding: 2px;" ALIGN=CENTER widtd="28%"><B>Amount<br/>Harga Total</B></td>                                 
                        </tr>                                
                    </thead>
                    <!--<tbody>-->
                        <?php
                        $qtytotal = 0;
                        $row = 10;
                        if (!empty($poitem)) {
                            $counter = 1;
                            foreach ($poitem as $pritem) {
                                $class_ = "";
                                if ($counter % 10 == 0) {
                                    $class_ = 'class="page-break"';
                                    //$class_="style='page-break-after:always;'";
                                }
                                ?>
                                <tr valign="top" <?php echo $class_ ?>>                                        
                                    <td STYLE="border-right: 1px solid #000000;border-left: 1px solid #000000;padding: 1px;" ALIGN=CENTER><?php echo $counter++; ?></td>
                                    <td STYLE="border-right: 1px solid #000000;padding: 1px;" ALIGN=CENTER><?php echo $pritem->mat_req_number . $pritem->sr_number ?>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;padding: 1px;" ALIGN=CENTER><?php echo $pritem->itempartnumber; ?>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;padding: 1px;"><?php echo $pritem->itemdescription; ?></td>
                                    <td STYLE="border-right: 1px solid #000000;padding: 1px;" ALIGN=CENTER><?php echo number_format($pritem->qty); ?></td>
                                    <td STYLE="border-right: 1px solid #000000;padding: 1px;" ALIGN=CENTER><?php echo $pritem->unitcode; ?></td>
                                    <td STYLE="border-right: 1px solid #000000;text-align: right;padding: 1px;">
                                        <?php
                                        if (in_array('hide_price', $accessmenu)) {
                                            echo '-';
                                        } else {
                                            echo $pritem->currency . " " . number_format($pritem->price, 2);
                                        }
                                        ?>
                                    </td>
                                    <td STYLE="border-right: 1px solid #000000;text-align: right;padding: 1px;">
                                        <?php
                                        if (in_array('hide_price', $accessmenu)) {
                                            echo '-';
                                        } else {
                                            echo number_format($pritem->total, 2);
                                        }
                                        ?>
                                    </td>

                                </tr>
                                <?php
                                $qtytotal += $pritem->qty;
                                $row--;
                            }
                        }
                        if ($row > 0) {
                            for ($i = 0; $i < $row; $i++) {
                                ?>
                                <tr>                                        
                                    <td STYLE="border-left: 1px solid #000000;border-right: 1px solid #000000" ALIGN=CENTER>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;" ALIGN=LEFT>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;padding-left: 3px" ALIGN=CENTER>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;padding-left: 3px" ALIGN=LEFT>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                                    <td STYLE="border-right: 1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        <tr>                                        
                            <td STYLE="border-left: 1px solid #000000;border-right: 1px solid #000000;border-bottom:1px solid #000000;" ALIGN=CENTER>&nbsp;</td>
                            <td STYLE="border-right: 1px solid #000000;border-bottom:1px solid #000000;" ALIGN=LEFT>&nbsp;</td>
                            <td STYLE="border-right: 1px solid #000000;border-bottom:1px solid #000000;padding-left: 3px" ALIGN=CENTER>&nbsp;</td>
                            <td STYLE="border-right: 1px solid #000000;border-bottom:1px solid #000000;padding-left: 3px" ALIGN=LEFT>&nbsp;</td>
                            <td STYLE="border-right: 1px solid #000000;border-bottom:1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                            <td STYLE="border-right: 1px solid #000000;border-bottom:1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                            <td STYLE="border-right: 1px solid #000000;border-bottom:1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                            <td STYLE="border-right: 1px solid #000000;border-bottom:1px solid #000000;" ALIGN=RIGHT>&nbsp;</td>
                        </tr>
                    <!--</tbody>-->
                </table>

                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>                                        
                        <td STYLE="border:none;">&nbsp;</td>
                        <td STYLE="border:none;">&nbsp;</td>
                        <td STYLE="border:none;">&nbsp;</td>
                        <td STYLE="border:none;">&nbsp;</td>
                        <td STYLE="border:none;" colspan="4" align="right">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" align="right" style="font-weight: bold;">Disc 
                                        <?php
                                        if (in_array('hide_price', $accessmenu)) {
                                            echo '-';
                                        } else {
                                            echo $po->discount_percentage;
                                        }
                                        ?> % </td>
                                    <td width="5%" align="center" style="font-weight: bold;">:</td>
                                    <td width="50%" align="right" style="padding-right: 2px;font-weight: bold;"><?php
                                        if (in_array('hide_price', $accessmenu)) {
                                            echo '-';
                                        } else {
                                            echo number_format($po->discount, 2, '.', ',') . "";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="font-weight: bold;">Sub Total(<?php echo $po->currency; ?>) </td>
                                    <td align="center" style="font-weight: bold;">:</td>
                                    <td align="right" style="padding-right: 2px;font-weight: bold;">
                                        <?php
                                        if (in_array('hide_price', $accessmenu)) {
                                            echo '-';
                                        } else {
                                            echo number_format($po->grandtotal, 2, '.', ',') . "";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="font-weight: bold;">PPn 
                                        <?php
                                        if (in_array('hide_price', $accessmenu)) {
                                            echo '-';
                                        } else {
                                            echo $po->ppn_percentage;
                                        }
                                        ?> % </td>
                                    <td align="center" style="font-weight: bold;">:</td>
                                    <td align="right" style="padding-right: 2px;font-weight: bold;">
                                        <?php
                                        if (in_array('hide_price', $accessmenu)) {
                                            echo '-';
                                        } else {
                                            echo number_format($po->ppn, 2, '.', ',') . "";
                                        }
                                        ?>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>                                        
                        <th STYLE="border-width:1px 0px 1px 1px; border-style: solid;border-color: #000000;" ALIGN=CENTER widtd="1%">&nbsp;</th>
                        <td STYLE="border-width:1px 0px 1px 0px; border-style: solid;border-color: #000000;" ALIGN=CENTER width="8%">&nbsp;</td>
                        <td STYLE="border-width:1px 0px 1px 0px; border-style: solid;border-color: #000000;" ALIGN=CENTER width="8%">&nbsp;</td>
                        <td STYLE="border-width:1px 0px 1px 0px; border-style: solid;border-color: #000000;" ALIGN=CENTER width="31%">GRAND TOTAL</td>
                        <td STYLE="border-width:1px 0px 1px 0px; border-style: solid;border-color: #000000;" width="11%">&nbsp;</td>
                        <td STYLE="border-width:1px 0px 1px 0px; border-style: solid;border-color: #000000;"  width="7%"ALIGN=CENTER><?php echo $qtytotal; ?>&nbsp;</td>
                        <td STYLE="border-width:1px 0px 1px 0px; border-style: solid;border-color: #000000;" ALIGN=CENTER width="7%">&nbsp;</td>
                        <td STYLE="border-width:1px 1px 1px 0px; border-style: solid;border-color: #000000;font-weight: bold;" width="28%" align="right">
                            <?php
                            if (in_array('hide_price', $accessmenu)) {
                                echo '-';
                            } else {
                                echo $po->currency . "&nbsp;&nbsp; " . number_format($po->all_total_price, 2, '.', ',');
                            }
                            ?>&nbsp;
                        </td>
                    </tr>
<!--                    <tr>                                        
                        <td STYLE="border-width:1px 1px 1px 1px; border-style: solid;border-color: #000000;">&nbsp;</td>
                        <td STYLE="border-width:1px 1px 1px 1px; border-style: solid;border-color: #000000;font-weight: bold;" colspan="3" width="50%">GRAND TOTAL </td>
                        <td STYLE="border-width:1px 1px 1px 1px; border-style: solid;border-color: #000000;font-weight: bold;" >&nbsp;<?php echo $qtytotal; ?></td>
                        <td STYLE="border-width:1px 1px 1px 1px; border-style: solid;border-color: #000000;font-weight: bold;" colspan="3" align="right"><?php echo $po->currency . "&nbsp;&nbsp; " . number_format($po->all_total_price, 2, '.', ',') ?>&nbsp;</td>
                    </tr>-->
                </table>

                <table width="100%" cellpadding="0" cellspacing="0">
                    <TR>
                        <td STYLE="border-width:1px 1px 1px 1px; border-style: solid;border-color: #000000;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="30%" align="center" style="font-weight: bold;">
                                        Order By<br/>
                                        Dipesan Oleh<br/>
                                        <?php
                                        $approval = $this->model_approval->selectApprovalPr($po->prid);
                                        $myfile = "./signature/" . $approval[0]->employeeid . ".png";
                                        //echo $myfile;
                                        if (file_exists($myfile)) {
                                            if ($st == 3) {
                                                ?>
                                                <img src="<?php echo $_SERVER["DOCUMENT_ROOT"] . '/signature/' . $approval[0]->employeeid . '.png' ?>" style='max-height:30px;max-width:90px;'/><br/>
                                                <?php
                                            } else {
                                                echo "<img src='" . base_url() . "/signature/" . $approval[0]->employeeid . ".png' style='max-height:40px;max-width:90px;'/><br/>";
                                            }
                                        } else {
                                            ?>
                                            <b><br/><i>Submitted at </i>: <br/><br/>
                                            </b>
                                            <?php
                                        }
                                        echo "<span style='font-size:9px'>" . date('d/m/Y h:i', strtotime($approval[0]->timeapprove)) . "</span><br/>";
                                        echo strtoupper($approval[0]->name);
                                        ?>

                                    <td width="40%">&nbsp;</td>
                                    <td width="30%" align="center" style="font-weight: bold;">
                                        Accepted & Agreed By<br/>
                                        Diterima &amp; disetujui oleh<br/><br/><br/>
                                        (............................)
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="100%" cellpadding="0" cellspacing="0" style="padding: 5px;">
                    <tr>
                        <td width="40%" rowspan="2" style="border-width:1px 0px 1px 1px; border-style: solid;border-color: #000000;">&nbsp;</td>
                        <td width="20%" style="border-width:1px 0px 1px 1px; border-style: solid;border-color: #000000;text-align: center;font-weight: bold;">Aknowledge<BR>Diketahui</td>
                        <td width="20%" style="border-width:1px 0px 1px 1px; border-style: solid;border-color: #000000;text-align: center;font-weight: bold;">Checked<BR>Diperiksa</td>
                        <td width="20%" style="border-width:1px 1px 1px 1px; border-style: solid;border-color: #000000;text-align: center;font-weight: bold;">Approved<BR>Disetujui</td>
                    </tr>
                    <tr>
                        <td style="border-width:0px 0px 1px 1px; border-style: solid;border-color: #000000;text-align: center;font-weight: bold;">
                            <?php
//print_r($approval[2]);
                            $myfile = "./signature/" . $approval[2]->employeeid . ".png";
//echo $myfile;
                            if (file_exists($myfile)) {
                                if ($st == 3) {
                                    echo "<img src='" . $_SERVER["DOCUMENT_ROOT"] . "/signature/" . $approval[2]->employeeid . ".png' style='max-height:90px;max-width:90px;'/>";
                                } else {
                                    echo "<img src='" . base_url() . "/signature/" . $approval[2]->employeeid . ".png' style='max-height:90px;max-width:90px;'/>";
                                }
                            } else {
                                echo "<b><i>Aknowledge at </i></b>: <br/><br/><br/>";
                            }
                            echo "<br/><span style='font-size:9px'>" . date('d/m/Y h:i', strtotime($approval[2]->timeapprove)) . "</span><br/>";
                            echo strtoupper($approval[2]->name);
//echo date('d/m/Y h:i', strtotime($approval[3]->timeapprove)); 
                            ?>

                        </td>
                        <td style="border-width:0px 0px 1px 1px; border-style: solid;border-color: #000000;text-align: center;font-weight: bold;">
                            <?php
//print_r($approval);
                            $myfile = "./signature/" . $approval[1]->employeeid . ".png";
//echo $myfile;
                            if (file_exists($myfile)) {
                                if ($st == 3) {
                                    echo "<img src='" . $_SERVER["DOCUMENT_ROOT"] . "/signature/" . $approval[1]->employeeid . ".png' style='max-height:90px;max-width:90px;'/>";
                                } else {
                                    echo "<img src='" . base_url() . "/signature/" . $approval[1]->employeeid . ".png' style='max-height:100px;max-width:100px;'/>";
                                }
                            } else {
                                echo "<b><i>Checked at </i></b>: <br/><br/><br/>";
                            }
                            echo "<br/><span style='font-size:9px'>" . date('d/m/Y h:i', strtotime($approval[1]->timeapprove)) . "</span><br/>";
                            echo strtoupper($approval[1]->name);
//echo date('d/m/Y h:i', strtotime($approval[3]->timeapprove)); 
                            ?>
                        </td>
                        <td align="center" style="border-width:0px 1px 1px 1px; border-style: solid;border-color: #000000;text-align: center;font-weight: bold;">
                            <?php
                            $myfile = "./signature/" . $approval[3]->employeeid . ".png";
//echo $myfile;
                            if (file_exists($myfile)) {
                                if ($st == 3) {
                                    echo "<img src='" . $_SERVER["DOCUMENT_ROOT"] . "/signature/" . $approval[3]->employeeid . ".png' style='max-height:90px;max-width:80px;'/>";
                                } else {
                                    echo "<img src='" . base_url() . "/signature/" . $approval[3]->employeeid . ".png' style='max-height:90px;max-width:100px;'/>";
                                }
                            } else {
                                echo "<b><i>Approved at </i>: <br/><br/><br/></b>";
                            }
                            echo "<br/><span style='font-size:9px'>" . date('d/m/Y h:i', strtotime($approval[3]->timeapprove)) . "</span><br/>";
                            echo "<b>" . strtoupper($approval[3]->name) . "<b/>";
//echo date('d/m/Y h:i', strtotime($approval[3]->timeapprove)); 
                            ?>
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="30%">Original for supplier</td>
                        <td>Copy for purchasing (1)</td>
                        <td width="30%" align="right">copy for accounting (2 & 3)</td>
                    </tr>
                </table>
                <?php
                if ($st == 3) {
                    ?>
                    <table width="100%">
                        <tr>
                            <td>
                                <i style="font-size: 10px">
                                    <?php
                                    if ($po->printed == 0) {
                                        echo "Original";
                                    } else {
                                        echo "Copied " . ($po->printed);
                                    }
                                    ?>
                                </i>
                            </td>
                        </tr>
                    </table>
                    <?php
                }

                if ($st == 0) {
                    ?>
                    <a href="<?php echo base_url() ?>index.php/po/printpo/<?php echo $po->id ?>/3" target="blank"><button onclick="$('#po_s_td_action<?php echo $po->id ?>').attr('bgcolor', '#80dcaf')">print</button></a>
                <?php } else if ($st == 3) { ?>
                    <script>window.print();</script>
                <?php } ?>
            </span>
    </body>
</html>
