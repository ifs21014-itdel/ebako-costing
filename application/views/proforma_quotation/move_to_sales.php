<div class="modal-header">
    <h4 class="modal-title">Move to Sales Quotation</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="form_move_to_sales" onsubmit="do_move_to_sales(); return false;">
        <input type="hidden" id="proforma_quotation_id" name="proforma_quotation_id" value="<?php echo $proforma_quotation->id; ?>">
        
        <div class="form-group">
            <label>Proforma Quotation: <b><?php echo $proforma_quotation->number; ?></b></label>
        </div>
        
        <div class="form-group">
            <label>Customer: <b><?php echo $proforma_quotation->customer_name; ?></b></label>
            <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $proforma_quotation->customer_id; ?>">
        </div>

        <div class="form-group">
            <label for="quotation_number">Sales Quotation Number*</label>
            <input type="text" class="form-control" id="quotation_number" name="quotation_number" value="<?php echo $proforma_quotation->number; ?>" required>
        </div>

        <div class="form-group">
            <label for="quo_date">Date*</label>
            <input type="date" class="form-control" id="quo_date" name="quo_date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <label>Items to move</label>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="2%"><input type="checkbox" id="select_all" onclick="toggleSelectAll()"></th>
                        <th width="15%">Ebako Code</th>
                        <th width="15%">Customer Code</th>
                        <th width="15%">FOB Value Selection</th>
                        <th width="10%">FOB Quotation</th>
                        <th width="10%">FOB Product Price</th>
                        <th width="10%">FOB Costing</th>
                        <th width="15%">Remark</th>
                        <th width="15%">Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proforma_quotation_detail as $detail) { ?>
                    <tr>
                        <td><input type="checkbox" name="selected_items[]" value="<?php echo $detail->id; ?>" class="item-checkbox"></td>
                        <td><?php echo $detail->ebako_code; ?></td>
                        <td><?php echo $detail->customer_code; ?></td>
                        <td>
                            <select name="fob_selection_<?php echo $detail->id; ?>" class="form-control">
                                <option value="fob_quotation">FOB Quotation</option>
                                <option value="fob_product_price">FOB Product Price</option>
                                <option value="fob_costing">FOB Costing</option>
                            </select>
                        </td>
                        <td><?php echo number_format($detail->fob_quotation, 2); ?></td>
                        <td><?php echo number_format($detail->fob_product_price, 2); ?></td>
                        <td><?php echo number_format($detail->fob_costing, 2); ?></td>
                        <td><?php echo $detail->remark; ?></td>
                        <td>
                            <input type="number" 
                                name="quantity_<?php echo $detail->id; ?>" 
                                class="form-control form-control-sm" 
                                min="1" 
                                value="<?php echo $detail->quantity; ?>" 
                                style="width: 80px;">
                        </td>

                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-success">Process Migration</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </form>
</div>

<script>
function toggleSelectAll() {
    const checked = $('#select_all').prop('checked');
    $('.item-checkbox').prop('checked', checked);
}

function do_move_to_sales() {
    // Validasi form
    if ($('input[name="selected_items[]"]:checked').length === 0) {
        bootbox.alert('Please select at least one item to move.');
        return false;
    }

    if (!$('#quotation_number').val()) {
        bootbox.alert('Please enter a Sales Quotation Number.');
        return false;
    }

    // Kumpulkan data
    const formData = {
        proforma_quotation_id: $('#proforma_quotation_id').val(),
        customer_id: $('#customer_id').val(),
        quotation_number: $('#quotation_number').val(),
        quo_date: $('#quo_date').val(),
        items: []
    };

    // Ambil detail item yang dipilih
    $('input[name="selected_items[]"]:checked').each(function () {
        const itemId = $(this).val();
        const fobSelection = $(`select[name="fob_selection_${itemId}"]`).val();
        const quantity = $(`input[name="quantity_${itemId}"]`).val();
        formData.items.push({
            detail_id: itemId,
            fob_selection: fobSelection,
            quantity: quantity
            });
        });

    // Kirim data ke server
    $.ajax({
        url: 'proforma_quotation/process_move_to_sales', // diperbaiki, tanpa PHP echo
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        beforeSend: function () {
            $('#form_move_to_sales button[type="submit"]').prop('disabled', true).text('Processing...');
        },
        success: function (response) {
            if (response.success) {
                bootbox.alert('Data successfully moved to Sales Quotation!', function () {
                    $('#modal_move_to_sales').modal('hide');
                    location.reload();
                });
            } else {
                bootbox.alert('Error: ' + response.msg);
                $('#form_move_to_sales button[type="submit"]').prop('disabled', false).text('Process Migration');
            }
        },
        error: function (xhr, status, error) {
            bootbox.alert('Error: ' + error);
            $('#form_move_to_sales button[type="submit"]').prop('disabled', false).text('Process Migration');
        }
    });

    return false;
}
</script>
