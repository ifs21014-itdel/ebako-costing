<?php
/**
 * Detail view for price list
 */
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Detail Price List</h3>
    </div>
    <div class="panel-body">
        <?php if ($price_list === null): ?>
            <div class="alert alert-warning">
                <strong>Perhatian!</strong> Data price list tidak ditemukan atau telah dihapus.
            </div>
            <div class="form-group text-center">
                <button class="btn btn-default" onclick="pricelist_search(0)">
                    <i class="fa fa-arrow-left"></i> Kembali
                </button>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Model ID</th>
                            <td><?php echo isset($price_list->model_no) ? $price_list->model_no : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Model Description</th>
                            <td><?php echo isset($price_list->type)? $price_list->model_description : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td><?php echo isset($price_list->customer_name) ? $price_list->customer_name : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td><?php echo isset($price_list->quantity) ? $price_list->quantity : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Last Costing Price</th>
                            <td><?php echo isset($price_list->last_costing_price) ? number_format($price_list->last_costing_price, 2) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Last Quotation Price</th>
                            <td><?php echo isset($price_list->last_quotation_price) ? number_format($price_list->last_quotation_price, 2) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Target Price</th>
                            <td><?php echo isset($price_list->target_price) ? number_format($price_list->target_price, 2) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Picklist Markup</th>
                            <td><?php echo isset($price_list->picklist_markup) ? $price_list->picklist_markup . '%' : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Picklist Rate</th>
                            <td><?php echo isset($price_list->picklist_rate) ? number_format($price_list->picklist_rate, 2) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th width="30%">Status</th>
                            <td><?php echo isset($price_list->status) ? $price_list->status : '-'; ?></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Rate</th>
                            <td><?php echo isset($price_list->rate) ? $price_list->rate : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Price Rate</th>
                            <td><?php echo isset($price_list->price_rate) ? number_format($price_list->price_rate, 2) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Profit Percentage</th>
                            <td><?php echo isset($price_list->profit_percentage) ? $price_list->profit_percentage . '%' : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Fixed Cost</th>
                            <td>
                                <?php echo isset($price_list->fixed_cost) ? number_format($price_list->fixed_cost, 2) . ' %' : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Variable Cost</th>
                            <td>
                            <?php echo isset($price_list->variable_cost) ? number_format($price_list->variable_cost, 2) . ' %' : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Port Origin Cost</th>
                            <td>
                            <?php echo isset($price_list->port_origin_cost) ? number_format($price_list->port_origin_cost, 2) . ' %' : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Insurance</th>
                            <td>
                            <?php echo isset($price_list->insurance) ? number_format($price_list->insurance, 2) . ' %' : '-'; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Cost</th>
                            <td><?php echo isset($price_list->fixed_cost) && isset($price_list->variable_cost) ? 
                                    number_format(($price_list->fixed_cost + $price_list->variable_cost), 2) : '-'; ?></td>
                        </tr>
                        <tr>
                            <th> Type</th>
                            <td><?php echo isset($price_list->type)? $price_list->type : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Approval Price</th>
                            <td> <?php echo isset($price_list->approval_price) ? number_format($price_list->approval_price, 2) . ' %' : '-'; ?></td>
                        </tr>
                        <tr>
                            <th>Approval Date</th>
                            <td><?php echo isset($price_list->approval_date) ? date('d-m-Y ', strtotime($price_list->approval_date)) : '-'; ?></td>
                        </tr>
                      
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group text-center">
                        <button class="btn btn-default" onclick="pricelist_search(0)">
                            <i class="fa fa-arrow-left"></i> Back
                        </button>
                        <!-- <?php if (in_array('edit', $accessmenu)) { ?>
                            <button class="btn btn-success" onclick="price_list_edit(<?php echo $price_list->id; ?>)">
                                <i class="fa fa-edit"></i> Edit
                            </button>
                        <?php } ?>
                        <?php if (in_array('delete', $accessmenu)) { ?>
                            <button class="btn btn-sm btn-delete btn-danger" onclick="price_list_delete(<?php echo $price_list->id; ?>)">
                                <i class="fa fa-trash fa-sm"></i> Delete
                            </button>
                        <?php } ?> -->
                    </div>
                </div>
            </div>
            
            <!-- Additional Information Section (if available) -->
            <?php if (isset($price_list->notes) && !empty($price_list->notes)) { ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">Catatan</h4>
                        </div>
                        <div class="panel-body">
                            <?php echo nl2br($price_list->notes); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            
            <!-- History Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">Information</h4>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th width="200">Created Date</th>
                                    <td><?php echo isset($price_list->price_list_date) ? date('d-m-Y ', strtotime($price_list->price_list_date)) : '-'; ?></td>
                                    <th width="200">Created By</th>
                                    <td><?php echo isset($price_list->created_by) ? $price_list->created_by : '-'; ?></td>
                                </tr>
                                <tr>
                                    <th>Last Updated</th>
                                    <td><?php echo isset($price_list->updated_at) ? date('d-m-Y ', strtotime($price_list->updated_at)) : '-'; ?></td>
                                    <th>Updated By</th>
                                    <td><?php echo isset($price_list->updated_by) ? $price_list->updated_by : '-'; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>