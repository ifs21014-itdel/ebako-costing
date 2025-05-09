<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="3%"><input type="checkbox" onclick="toggle_all_quotations(this)" /></th>
                <th>No. Quotation</th>
                <th>Customer</th>
                <th>Customer code</th>
                <th>Model Code</th>
                <th>Description</th>
                <th>FOB Price</th>
                <th>Date</th>
                <th>Dimensions (W × D × H)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($quotations)): ?>
                <?php foreach ($quotations as $qd): ?>
                <tr>
                    <td><input type="checkbox" name="quotation_detail_checkbox" value="<?= $qd->id ?>" /></td>
                    <td><?= $qd->quotation_number ?></td>
                    <td><?= $qd->customer_name ?></td>
                    <td><?= $qd->custcode ?></td>
                    <td><?= $qd->model_code ?></td>
                    <td><?= $qd->description ?></td>
                    <td><?= number_format($qd->fob_price, 2) ?></td>
                    <td><?= date('Y-m-d', strtotime($qd->quo_date)) ?></td>
                    <td><?= $qd->cw . ' × ' . $qd->cd . ' × ' . $qd->ch ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">No Quotation data available</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>