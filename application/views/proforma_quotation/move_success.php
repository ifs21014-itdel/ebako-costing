<div class="modal-header">
    <h4 class="modal-title">Migration Result</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <?php if (isset($success) && $success): ?>
        <div class="alert alert-success">
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <p>Data successfully migrated to Sales Quotation.</p>
            <p>Sales Quotation Number: <strong><?php echo $quotation_number; ?></strong></p>
        </div>
        
        <div class="text-center">
            <a href="<?php echo site_url('sales_quotes/view/' . $sales_quotes_id); ?>" class="btn btn-primary">
                <i class="fa fa-eye"></i> View Sales Quotation
            </a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
            <p><?php echo isset($error_message) ? $error_message : 'An error occurred during migration.'; ?></p>
        </div>
        
        <div class="text-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    <?php endif; ?>
</div>