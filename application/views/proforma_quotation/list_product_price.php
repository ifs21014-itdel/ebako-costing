<div class="container-fluid">
    <div align="left" style="padding: 7px 0;">
        <span style="font-style: italic;"><b>*Notes: Select product price from the list</b></span>
        <br/><br/>
        <input type="hidden" id="temp" value="<?php echo $temp ?>" />
        <span class="labelelement">Ebako Code</span>
        <input type="text" name="model_code" id="model_code" size="10" onkeypress="if(event.keyCode==13){price_search(0)}"/>
        <span class="labelelement">Price Range</span>
        <input type="text" name="price_from" id="price_from" size="10" placeholder="From" onkeypress="if(event.keyCode==13){price_search(0)}"/>
        <input type="text" name="price_to" id="price_to" size="10" placeholder="To" onkeypress="if(event.keyCode==13){price_search(0)}"/>    
        <span class="labelelement">Date From</span>
        <input type="date" name="date_from" id="date_from" onchange="price_search(0)"/>
        <span class="labelelement">Date To</span>
        <input type="date" name="date_to" id="date_to" onchange="price_search(0)"/>
        <button onclick="price_search(0)">Search</button>
    </div>

    <div id="searchpricedata" style="padding: 10px;" class="row">
        <table id="table_price_list" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
            <thead>
                <tr>
                    <th width="2%">No</th>
                    <th width="12%">Quotation ID</th>
                    <th width="12%">Ebako Code</th>
                    <th width="20%">Description</th>
                    <th width="10%">FOB Price</th>
                    <th width="10%">Customer</th>
                    <th width="10%">Quotation Date</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                if (isset($salesQuotes) && is_array($salesQuotes)) {
                    foreach ($salesQuotes as $quote) {
                ?>
                    <tr>
                        <td align="right"><?php echo $counter++ ?></td>
                        <td><?php echo $quote->quotation_id ?></td>
                        <td><?php echo $quote->ebako_code ?></td>
                        <td><?php echo $quote->description ?></td>
                        <td align="right"><?php echo number_format($quote->fob, 2) ?></td>
                        <td><?php echo isset($quote->customer_name) ? $quote->customer_name : '-' ?></td>

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
                        <td colspan="8" align="center">No data available</td>
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
                });
            });

            function price_search(page) {
                console.log("gelas");
                var modelCode = $('#model_code').val();
                var priceFrom = $('#price_from').val();
                var priceTo = $('#price_to').val();
                var dateFrom = $('#date_from').val();
                var dateTo = $('#date_to').val();
                
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url(); ?>index.php/proforma_quotation/search_product_price',
                    data: {
                        model_code: modelCode,
                        price_from: priceFrom,
                        price_to: priceTo,
                        date_from: dateFrom,
                        date_to: dateTo,
                        temp: $('#temp').val()
                    },
                    success: function(data) {
                        $('#searchpricedata').html(data);
                    }
                });
            }
        </script>
    </div>
</div>
