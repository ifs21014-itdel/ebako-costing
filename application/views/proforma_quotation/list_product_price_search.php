<div id="searchpricedata" style="padding: 10px;" class="row">
    <table id="table_price_list" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th width="12%">Quotation ID</th>
                <th width="12%">Ebako Code</th>
                <th width="20%">Description</th>
                <th width="10%">FOB Price</th>
                <th width="10%">Customer Code</th>
                <th width="10%">Quotation Date</th>
                <th width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            if (isset($salesQuotes) && is_array($salesQuotes) && count($salesQuotes) > 0) {
                foreach ($salesQuotes as $quote) {
            ?>
                <tr>
                    <td align="right"><?php echo $counter++ ?></td>
                    <td><?php echo $quote->quotation_id ?></td>
                    <td><?php echo $quote->ebako_code ?></td>
                    <td><?php echo $quote->description ?></td>
                    <td align="right"><?php echo number_format($quote->fob, 2) ?></td>
                    <td><?php echo $quote->customercode ?></td>
                    <td><?php echo date('d-m-Y', strtotime($quote->quotation_date)) ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" 
                        onclick="select_product_price('<?php echo $quote->fob ?>', '<?php echo $quote->id ?>')">
                            Pilih
                        </button>
                    </td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td align="center" colspan="8">No data available</td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#table_price_list').DataTable({
                scrollY: "450px",
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                ordering: true,
                info: true,
                searching: true,
                autoWidth: true,
                destroy: true
            });
        });
    </script>
</div>
