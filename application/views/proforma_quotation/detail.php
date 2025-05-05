<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td width="30%"><strong>Number</strong></td>
                        <td><?php echo $proforma_quotation->number ?></td>
                    </tr>
                    <tr>
                        <td><strong>Date</strong></td>
                        <td><?php echo date('d/m/Y', strtotime($proforma_quotation->date)) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Customer</strong></td>
                        <td><?php echo $proforma_quotation->customer_name ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <!-- Fitur pencarian untuk detail -->
                <div class="form-inline">
                    <input class="form-control" type="text" name="ebako_code_s" placeholder="Ebako Code" id="ebako_code_s" size="10" onkeypress="if (event.keyCode == 13) { detail_search(<?php echo $proforma_quotation->id ?>, 0); }" />
                    <input class="form-control" type="text" name="customer_code_s" placeholder="Customer Code" id="customer_code_s" size="15" onkeypress="if (event.keyCode == 13) { detail_search(<?php echo $proforma_quotation->id ?>, 0); }" />
                    <button class="btn btn-default" onclick="detail_search(<?php echo $proforma_quotation->id ?>, 0)">Search</button>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <h4>Detail Item</h4>
            </div>
            <div class="col-sm-12" style="padding-bottom:10px;">
                <button class="btn btn-labeled fa fa-plus btn-success" style="margin-right:5px;"
                    onclick="proforma_createnewdetail(<?php echo $proforma_quotation->id; ?>, <?php echo $proforma_quotation->customer_id; ?>)">
                    Create New Proforma Quotation Detail
                </button>
                <button class="btn btn-labeled fa fa-plus btn-success" style="margin-right:5px;"
                    onclick="proforma_createnewdetail_from_product_price(<?php echo $proforma_quotation->id; ?>, <?php echo $proforma_quotation->customer_id; ?>)">
                    Create New Proforma Quotation Detail From Product Price
                </button>
                <<button class="btn btn-labeled fa fa-print btn-info" style="margin-right:5px;"
    onclick="print_proforma_detail(<?php echo $proforma_quotation->id; ?>)">
    Print Proforma Quotation Detail
</button>
            </div>

            

        </div>
        
        <div id="detail_data" align="center" style="overflow-x: auto;width:auto;padding: 10px;">
            <!-- Detail dengan pagination -->
            <div style="margin-bottom: 5px;margin-top: 5px;" class="pull-right">
                <nav class="pagination pagination-sm">
                    <input type="hidden" id="detail_offset" value="<?php echo ($offset < 1 ? 0 : ($offset - 1) ) ?>" />
                    <ul class="pagination">
                        <li class="">
                            <a class="page-link-2" style="color: #167495;cursor: pointer;" onclick="detail_search(<?php echo $proforma_quotation->id ?>, 0)">
                                <strong><span class="fa fa-refresh"></span> Refresh</strong>
                            </a> 
                        </li>
                        <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>

                        <li class="page-item">
                            <a class="page-link" href="#" onclick="detail_search(<?php echo $proforma_quotation->id ?>, <?php echo $first ?>)">First</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous" onclick="detail_search(<?php echo $proforma_quotation->id ?>, <?php echo $prev ?>)">
                                <img src="images/prev.png" class="miniaction"/>
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link"><?php echo $page ?></a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next" onclick="detail_search(<?php echo $proforma_quotation->id ?>, <?php echo $next ?>)">
                                <img src="images/next.png" class="miniaction"/>
                            </a>
                        </li>

                        <li class="page-item">
                            <a class="page-link" href="#" onclick="detail_search(<?php echo $proforma_quotation->id ?>, <?php echo $last ?>)">Last</a>
                        </li>
                        <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>
                        <li class="">
                            <a class="page-link-2">
                                Total:  <strong><?php echo $num_page ?></strong> Page(s),
                                <strong><?php echo $num_rows ?></strong> Row(s)
                            </a> 
                        </li>
                    </ul>
                </nav>
            </div>

            <table id="table_detail" class="table table-striped table-bordered" cellspacing="0">
                <thead>
                    <tr style="border-top: 4px solid #ec9821;">
                        <th width="2%" align=center>No</th>
                        <th width="10%" align=center>Ebako Code</th>
                        <th width="10%" align=center>Customer Code</th>
                        <th width="10%" align=center>FOB Quotation</th>
                        <th width="10%" align=center>FOB Product Price</th>
                        <th width="10%" align=center>FOB Costing</th>
                        <th width="15%" align=center>Remark</th>
                        <th width="10%" align=center>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = $offset + 1;
                    $detail_data = isset($proforma_quotation_detail) ? $proforma_quotation_detail : array();
                    foreach ($detail_data as $detail) {
                    ?>
                        <tr>
                            <td align="right"><?php echo $counter++ ?></td>
                            <td><?php echo $detail->ebako_code ?></td>
                            <td><?php echo $detail->customer_code ?></td>
                            <td align="right"><?php echo number_format($detail->fob_quotation, 2) ?></td>
                            <td align="right"><?php echo number_format($detail->fob_product_price, 2) ?></td>
                            <td align="right"><?php echo number_format($detail->fob_costing, 2) ?></td>
                            <td><?php echo $detail->remark ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="<?php echo ($detail->type == 'Not From Product Price') ? 'proforma_detail_edit('.$detail->id.')' : 'proforma_detail_edit_from_product_price('.$detail->id.')'; ?>">
                                    <i class="fa fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="proforma_detail_delete(<?php echo $detail->id ?>, <?php echo $proforma_quotation->id ?>)">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table_detail').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            ordering: false,
            info: false,
            searching: false,
            autoWidth: true
        });
    });
</script>