<div class="row" style="min-height: 300px;">
    <div align="left" style="padding-top: 2px;padding-bottom: 5px;padding-left: 7px;">
    	<span style="font-style: italic;"><b>*Notes: Sales Quotation Detail will show based on Customer and Model selection</b></span>
    	<br/>
    	<br/>
        <input type="hidden" id="temp" value="<?php echo $temp ?>" />
        <input type="hidden" id="id" value="<?php echo $id ?>" />
        <input type="hidden" id="billto_s" value="<?php echo $billto ?>" />
    </div>
    <div id="searchquotationdata" style="padding: 10px;" class="row">
    	<table id="table_quote_detail" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
		    <thead>
		        <tr>
                    <th width="3%">No</th>
                    <th width="10%">Rate Value</th>
                    <th width="10%">Profit Margin</th>
                    <th width="10%">FOB Price</th>                        
                    <th width="5%">Action</th>
                </tr>
			</thead>
			<tbody>
                <?php
                if (isset($salesQuotes) && !empty($salesQuotes)) {
                    if (is_object($salesQuotes)) {
                        // Jika hanya satu baris hasil
                        $salesId = isset($sales->id) ? $sales->id : 0;
                ?>
                    <tr>
                        <td align="right">1</td>
                        <td align="right"><?php echo number_format($salesQuotes->ratevalue, 2) ?></td>
                        <td align="right"><?php echo number_format($salesQuotes->profit_margin, 2) . ' %' ?></td>
                        <td align="right"><?php echo number_format($salesQuotes->fob_price, 2) ?></td>
                        <td>
                        <button type="button" class="btn btn-sm btn-success" 
                            onclick="select_quotation(<?php echo number_format($salesQuotes->fob_price, 2) ?>, <?php echo $salesQuotes->id  ?>)">
                            Pilih
                        </button>
                        </td>
                    </tr>
                <?php
                    } else if (is_array($salesQuotes) && isset($sales->id)) {
                        // Jika multiple hasil
                        $counter = 1;
                        foreach ($salesQuotes as $quote) {
                ?>
                    <tr>
                        <td align="right"><?php echo $counter++ ?></td>
                        <td align="right"><?php echo number_format($quote->ratevalue, 2) ?></td>
                        <td align="right"><?php echo number_format($quote->profit_margin, 2) . ' %' ?></td>
                        <td align="right"><?php echo number_format($quote->fob_price, 2) ?></td>
                        <td>
                        <button type="button" class="btn btn-sm btn-success" 
                            onclick="select_quotation(<?php echo number_format($quote->fob_price, 2) ?>, <?php echo $quote->id ?>)">
                            Pilih
                        </button>
                        </td>
                    </tr>
                <?php
                        }
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="10" align="center">Tidak ada data quotation yang tersedia</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
		</table>
		
		<script type="text/javascript">
            $(document).ready(function () {
                // Cek apakah tbody punya baris data selain pesan "tidak ada data"
                var rowCount = $('#table_quote_detail tbody tr').length;
                var isEmptyMessage = $('#table_quote_detail tbody tr td').first().text().includes("Tidak ada data quotation");

                if (rowCount > 0 && !isEmptyMessage) {
                    $('#table_quote_detail').DataTable({
                        scrollY: true,
                        scrollX: true,
                        scrollCollapse: true,
                        paging: true,
                        ordering: true,
                        info: true,
                        searching: true,
                        autoWidth: true,
                    });
                }
            });
        </script>

    </div>
</div>
