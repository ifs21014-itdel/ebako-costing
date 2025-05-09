<script src="js/global.js"></script>
<script src="js/product_price.js"></script>
<script src="js/item.js"></script>

<div style="height: 50%; width: auto; border-bottom: 4px #ddd inset" class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">List Product Price</h3>
    </div>
    <div class="panel-body" id="menu_content_productprice">
        <table width="100%" border="0">
            <tr>
                <td>
                    <div align="left" class="form-inline" style="padding-top: 2px;">
                        <?php
                        if (in_array('add', $accessmenu)) {
                            echo '<div class="col-sm-12" style="padding-bottom:10px;">';
                            echo "<button class='btn btn-labeled fa fa-plus btn-success' style='margin-right:5px;' onclick='productprice_createnew()'>Create New Product Price</button>";
                            echo "<button class='btn btn-labeled fa fa-list-alt btn-info' style='margin-right:5px;' onclick='open_sales_quotation_list()'>Daftar Sales Quotation</button>";
                            echo '</div>';
                        }
                        ?>
                        <div class="col-sm-12">
                            <input type="hidden" id="productpriceid" value="0" /> <span class="labelelement">Find :</span>
                            <input class="form-control" type="text" name="ebako_code_s" placeholder="Ebako Code" id="ebako_code_s" size="10" onkeypress="if (event.keyCode == 13) {
                                        productprice_search(0);
                                    }" />
                            <input class="form-control" type="text" name="customer_code_s" placeholder="Customer Code" id="customer_code_s" size="15" onkeypress="if (event.keyCode == 13) {
                                        productprice_search(0) }" />
                            <label for="customerid_search">Customer</label>
                            <select class="form-control" id="customerid_search" onchange="productprice_search(0)" style="background-color: #f5faff; border: 1px solid #579ddb;">
                                <option value="0"></option>
                                <?php
                                foreach ($customer as $result) {
                                    echo "<option value='" . $result->id . "'>" . $result->name . "</option>";
                                }
                                ?>
                            </select>
                            <button class="btn btn-default" onclick="productprice_search(0)">Search</button>
                        </div>
                        </div>
                </td>
            </tr>
            <tr>
                <td>
                <div id="productpricedata" align="center" style="overflow-x: auto;width:auto;padding: 10px;">
                    <?php // Pastikan $offset didefinisikan 
                    $offset = isset($offset) ? $offset : 0; 
                    $data = array('offset' => $offset); 
                    $this->load->view('product_price/search', $data); 
                    ?>
                </div>
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- Modal untuk menampilkan daftar sales_quotation_detail -->
<div class="modal fade" id="salesQuotationModal" tabindex="-1" role="dialog" aria-labelledby="salesQuotationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="salesQuotationModalLabel">List of Approved Sales Quotations</h4>
            </div>
            <div class="modal-body">
                <div class="form-inline" style="margin-bottom: 15px;">
                    <div class="form-group">
                        <label for="search_customer">Customer:</label>
                        <select class="form-control" id="search_customer" style="background-color: #f5faff; border: 1px solid #579ddb;">
                            <option value="0">-- Semua Customer --</option>
                            <?php
                            foreach ($customer as $result) {
                                echo "<option value='" . $result->id . "'>" . $result->name . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button class="btn btn-primary" onclick="search_approved_quotations()">Filter</button>
                </div>
                <div id="approved_quotations_list" style="max-height: 400px; overflow-y: auto;">
                    <!-- Data akan diisi melalui Ajax -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="import_selected_quotations()">Import to Product Price</button>
            </div>
        </div>
    </div>
</div>