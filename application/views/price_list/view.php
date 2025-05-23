<?php
/**
 * View file for Price List
 */
?>

<script src="<?php echo base_url(); ?>js/price_list.js"></script>

<div style="height: 50%; width: auto; border-bottom: 4px #ddd inset" class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">List Price</h3>
    </div>
    <div class="panel-body" id="menu_content_pricelist">
        <table width="100%" border="0">
            <tr>
                <td>
                    <div align="left" class="form-inline" style="padding-top: 2px; margin-bottom: 15px;">
                        <div class="col-sm-8">
                            <input type="hidden" id="pricelistid" value="0" /> <span class="labelelement">Find :</span> 
                            <input class="form-control" type="text" name="model_name_s" placeholder="Model Name" id="model_name_s" size="10" onkeypress="if (event.keyCode == 13) {
                                        pricelist_search(0);
                                    }" /> 
                            <input class="form-control" type="text" name="customer_name_s" placeholder="Customer Name" id="customer_name_s" size="15" onkeypress="if (event.keyCode == 13) {
                                        pricelist_search(0) }" /> 
                            <label for="customerid_search">Customer</label>
                            <select class="form-control" id="customerid_search" onchange="pricelist_search(0)" style="background-color: #f5faff; border: 1px solid #579ddb;">
                                <option value="0"></option>
                                <?php
                                foreach ($customer as $result) {
                                    echo "<option value='" . $result->id . "'>" . $result->name . "</option>";
                                }
                                ?>
                            </select>
                            <button class="btn btn-default" onclick="pricelist_search(0)">Search</button>
                        </div>
                       
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                <div id="pricelistdata" align="center" style="overflow-x: auto;width:auto;padding: 10px;">                    
                <?php
                // Pastikan $offset didefinisikan
                $offset = isset($offset) ? $offset : 0;
                $data = array('offset' => $offset);
                $this->load->view('price_list/search', $data);
                ?>
                </div>
                </td>
            </tr>
        </table>
    </div>
</div>



<script>
// Tambahkan base_url untuk digunakan dalam Javascript
var base_url = '<?php echo base_url(); ?>';

$(document).ready(function() {
    // Toggle kolom ketika tombol diklik
    $("#toggle_column_btn").click(function() {
        $("#column_selection").collapse('toggle');
    });
});
</script>