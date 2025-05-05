<div style="margin-bottom: 5px;margin-top: 5px;" class="pull-right">
    <nav class="pagination pagination-sm">
        <input type="hidden" id="offset" value="<?php echo ($offset < 1 ? 0 : ($offset - 1) ) ?>" />
        <ul class="pagination">
            <li class="">
                <a class="page-link-2" style="color: #167495;cursor: pointer;" onclick="sales_quotes_search(0)">
                    <strong><span class="fa fa-refresh"></span> Refresh</strong>
                </a> 
            </li>
            <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="sales_quotes_search(<?php echo $first ?>)">First</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous" onclick="sales_quotes_search(<?php echo $prev ?>)">
                    <img src="images/prev.png" onclick="sales_quotes_search(<?php echo $prev ?>)" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link"><?php echo $page ?></a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next" onclick="sales_quotes_search(<?php echo $next ?>)">
                    <img src="images/next.png" onclick="sales_quotes_search(<?php echo $next ?>)" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="sales_quotes_search(<?php echo $last ?>)">Last</a>
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

<table id="table_sales_quotes" class="table table-striped table-bordered" cellspacing="0" >

    <tr>
        <td colspan="12"> <font color="blue" size="3">Select tu Print: </font>
            <input type="checkbox" name=wood id="wood_id" value="1" checked="true">Wood &nbsp;&nbsp;
            <input type="checkbox" name="veneer" id="veneer_id" value="1" checked="true">Veneer &nbsp;&nbsp;
            <input type="checkbox" name="upstype" id="upstype_id" value="1" checked="true">Upholstery Type &nbsp;&nbsp;
            <input type="checkbox" name="ship_conf" id="ship_conf_id" value="1" checked="true">Shipping Config &nbsp;&nbsp;
            <input type="checkbox" name="fabric" id="fabric_id" value="1" checked="true">Fabric &nbsp;&nbsp;
            <input type="checkbox" name="leather" id="leather_id" value="1" checked="true">Leather &nbsp;&nbsp;
            <input type="checkbox" name="packing" id="packing_id" value="1" checked="true">Packing &nbsp;&nbsp;
            <input type="checkbox" name="qtypp" id="qtypp_id" value="1" checked="true">Qty Per Packing &nbsp;&nbsp;
            <input type="checkbox" name="other" id="other_id" value="1" checked="true">Other Remarks &nbsp;&nbsp;
            <input type="checkbox" name="box_dim" id="box_dim_id" value="1" checked="true">Box Dimension &nbsp;&nbsp;
            <input type="checkbox" name="cube" id="cube_id" value="1" checked="true">Cube &nbsp;&nbsp;
        </td>
    </tr>
    <thead>
        <tr style="border-top: 4px solid #ec9821;">
            <th width="2%" align=center>No</th>
            <th width="8%" align=center>No Quotation</th>
            <th width="10%" align=center>Customer</th>
            <th width="6%" align=center>Quotation Date</th>
            <th width="6%" align=center>Original Date</th>
            <th width="8%" align=center>To</th>
            <th width="8%" align=center>Reference</th>
            <th width="6%" align=center>Fixed Cost</th>
            <th width="6%" align=center>Port Original Cost</th>
            <th width="6%" align=center>Revision</th>
            <th width="6%" align=center>Valid Date</th>
            <th width="6%" align=center>Payment Term</th>
            <th width="6%" align=center>Approved Date</th>
            <th width="6%" align=center>Approval Price</th>
            <th width="10%" align=center>Actions</th>
        </tr>
    </thead>
    <?php
    $counter = $offset + 1;
    foreach ($sq as $result) {
        $colour_td = "white";
        if ($counter % 2 == 0)
            $colour_td = "#ccffff";
        ?>
        <tr>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="right"><?php echo $counter++ ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)"  ><?php echo $result->quotation_number ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" ><?php echo $result->name ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" ><?php echo $result->quo_date ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" >
                <?php
                if ($result->prev_quo_date == null)
                    echo 'no revision';
                else
                    echo $result->prev_quo_date;
                ?>
            </td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" ><?php echo $result->to_cp ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" ><?php echo $result->reference ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->fixed_cost ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->port_origin_cost ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->revision ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->valid_date ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->pterm ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->approved_date ?></td>
            <td onclick="sales_quotes_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo ($result->approve_price ? number_format($result->approve_price, 2) : '-') ?></td>
            <td>
                <div class="drop">
                    <?php
                    $isApproved = strtolower($result->status) === 'approved';

                    if (!$isApproved) {
                        echo '<a href="javascript:showApprovalModal(' . $result->id . ');">
                                <button class="btn btn-sm btn-info">
                                    <i class="fa fa-check-circle fa-sm"></i> Approve Price
                                </button>
                            </a>';
                        echo '&nbsp;&nbsp;&nbsp;';
                    } else {
                        echo '<button class="btn btn-sm btn-secondary" disabled>
                                <i class="fa fa-check-circle fa-sm"></i> Approved
                            </button>';
                        echo '&nbsp;&nbsp;&nbsp;';
                    }

                    // Tombol print tetap aktif
                    echo '<a href="javascript:print_quotation(' . $result->id . ');">
                            <button class="btn btn-sm btn-success">
                                <i class="fa fa-print fa-sm"></i> Quo.
                            </button>
                        </a>';
                    echo '&nbsp;&nbsp;&nbsp;';
                    echo '<a href="javascript:print_quotation(' . $result->id . ');">
                            <button class="btn btn-sm btn-success">
                                <i class="fa fa-print fa-sm"></i> Project
                            </button>
                        </a>';

                    if (!$isApproved) {
                        echo '&nbsp;&nbsp;&nbsp;';
                        echo '<a href="javascript:sales_quotes_delete(' . $result->id . ');">
                                <button class="btn btn-sm btn-delete btn-danger">Delete</button>
                            </a>';
                    } else {
                        echo '&nbsp;&nbsp;&nbsp;';
                        echo '<button class="btn btn-sm btn-secondary" disabled>Cannot Delete</button>';
                    }
                    ?>
                </div>
            </td>

        </tr>
        <?php
    }
    ?>
</table>

<!-- Modal untuk Approval Price -->
<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #48c9e2; color: white;">
                <h5 class="modal-title" id="approvalModalLabel">Approve Price List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="approvalForm">
                    <input type="hidden" id="sales_quotes_id" name="sales_quotes_id">
                    
                    <div class="form-group">
                        <label for="approval_date">Approval Date <span class="required">*</span></label>
                        <input type="date" class="form-control" id="approval_date" name="approval_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="select_price">Select Price <span class="required">*</span></label>
                        <select class="form-control" id="select_price" name="select_price" required>
                            <option value="">-- Select Price --</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="approval_price">Approval Price <span class="required">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="approval_price" name="approval_price" required>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveApproval">Save Approval</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function showApprovalModal(id) {
    $('#sales_quotes_id').val(id);
    $('#approval_date').val('<?php echo date('Y-m-d'); ?>');
    
    // Reset form
    $('#select_price').empty().append('<option value="">-- Select Price --</option>');
    $('#approval_price').val('');
    
    // Ambil data fob price dari quotation_detail berdasarkan sales_quotes_id
    $.ajax({
        url: '<?php echo base_url('sales_quotes/get_fob_prices'); ?>',
        method: 'POST',
        data: {sales_quotes_id: id},
        dataType: 'json',
        success: function(data) {
            if (data.status === 'success') {
                // Isi dropdown dengan data fob_quotation
                $.each(data.prices, function(index, item) {
                    $('#select_price').append('<option value="' + item.fob_quotation + '">' + 
                        item.ebako_code + ' - ' + item.customer_code + ' ($' + item.fob_quotation + ')</option>');
                });
            } else {
                alert('Failed to get price data');
            }
        },
        error: function() {
            alert('Error fetching price data from server');
        }
    });
    
    $('#approvalModal').modal('show');
}

$(document).ready(function() {
    // Event handler untuk dropdown select_price
    $(document).on('change', '#select_price', function() {
        $('#approval_price').val($(this).val());
    });
    
    // Event handler untuk tombol saveApproval
    $(document).on('click', '#saveApproval', function() {
        // Validasi form
        if (!$('#approval_date').val() || !$('#approval_price').val()) {
            alert('Please fill all required fields');
            return false;
        }
        
        // Kirim data untuk update
        $.ajax({
            url: '<?php echo base_url('sales_quotes/update_approval'); ?>',
            method: 'POST',
            data: {
                id: $('#sales_quotes_id').val(),
                approval_date: $('#approval_date').val(),
                approval_price: $('#approval_price').val()
            },
            success: function(response) {
                if (response === 'success') {
                    alert('Approval data saved successfully');
                    $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('padding-right', ''); // Reset padding body

                    sales_quotes_search(0);
                } else if (response === 'unauthorized') {
                    alert('You are not authorized to perform this action');
                } else {
                    alert('Failed to save approval data');
                }
            },
            error: function() {
                alert('Error sending data to server');
            }
        });
    });
    
    // Inisialisasi tabel jika belum
    if ($.fn.DataTable.isDataTable('#table_sales_quotes')) {
        $('#table_sales_quotes').DataTable().destroy();
    }
    
    var table = $('#table_sales_quotes').DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        ordering: false,
        info: false,
        searching: false,
        autoWidth: true,
        select: true,
    });
});
</script>