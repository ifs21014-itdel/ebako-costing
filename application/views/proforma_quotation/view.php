<?php
/**
 * View file for Proforma Quotation
 */
?>

<script src="<?php echo base_url(); ?>js/proforma_quotation.js"></script>

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Proforma Quotation</h3>
    </div>
    <div class="panel-body" id="menu_content_proforma_quotation">
        <table width="100%" border="0">
            <tr>
                <td>
                    <div align="left" class="form-inline" style="padding-top: 2px; margin-bottom: 15px;">
                    <?php
                        if (in_array('add', $accessmenu)) {
                            echo '<div class="col-sm-12" style="padding-bottom:10px;">';
                            echo "<button class='btn btn-labeled fa fa-plus btn-success' style='margin-right:5px;' onclick = 'proforma_createnew()'>Create New Proforma Quotation</button>";
                            echo '</div>';
                        }
                        ?>
                        <div class="col-sm-8">
                            <input type="hidden" id="proforma_quotation_id" value="0" />
                            <span class="labelelement">Find :</span>
                            <input class="form-control" type="text" name="model_name_s" placeholder="Model Name" id="model_name_s" size="10" onkeypress="if (event.keyCode == 13) {
                                    proforma_quotation_search(0);
                                }" />
                            <input class="form-control" type="text" name="customer_name_s" placeholder="Customer Name" id="customer_name_s" size="15" onkeypress="if (event.keyCode == 13) {
                                    proforma_quotation_search(0) }" />
                            <label for="customerid_search">Customer</label>
                            <select class="form-control" id="customerid_search" onchange="proforma_quotation_search(0)" style="background-color: #f5faff; border: 1px solid #579ddb;">
                                <option value="0"></option>
                                <?php
                                foreach ($customer as $result) {
                                    echo "<option value='" . $result->id . "'>" . $result->name . "</option>";
                                }
                                ?>
                            </select>
                            <button class="btn btn-default" onclick="proforma_quotation_search(0)">Search</button>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="proforma_quotation_data" align="center" style="overflow-x: auto;width:auto;padding: 10px;">
                        <?php
                        // Pastikan $offset didefinisikan
                        $offset = isset($offset) ? $offset : 0;
                        $data = array('offset' => $offset);
                        $this->load->view('proforma_quotation/search', $data);
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- Detail section - akan ditampilkan ketika item di klik -->
<div id="detail_section" class="panel" style="display: none; margin-top: 20px;">
    <div class="panel-heading">
        <h3 class="panel-title">Proforma Quotation Detail</h3>
    </div>
    <div class="panel-body">
        <div id="proforma_quotation_detail_content">
            <!-- Detail content will be loaded here -->
        </div>
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