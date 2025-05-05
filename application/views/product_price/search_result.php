<!-- File: views/product_price/lists.php atau yang serupa -->
<div class="container-fluid">
    <table id="table_costing_list" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th width="12%">Model Code</th>
                <th width="25%">Description</th>
                <th width="8%">FOB Price</th>
                <th width="8%">Sell Price</th>
                <th width="8%">Profit %</th>
                <th width="8%">Status</th>
                <th width="8%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($quotation_detail as $result) {
            ?>
                <tr>
                    <td align="right"><?php echo $counter++ ?></td>
                    <td><?php echo (isset($result->modelno) && $result->modelno) ? $result->modelno : '-' ?></td>
                    <td><?php echo (isset($result->item_costing_desc) && $result->item_costing_desc) ? $result->item_costing_desc : '-' ?></td>
                    <td align="right"><?php echo number_format($result->fob_price, 2) ?></td>
                    <td align="right"><?php echo number_format($result->sellprice, 2) ?></td>
                    <td align="right"><?php echo number_format($result->profit_percentage, 2) . ' %' ?></td>
                    <td align="center">
                        <?php 
                        if($result->approve) {
                            echo '<span class="badge badge-success">Approved</span>';
                        } else if($result->needmodify) {
                            echo '<span class="badge badge-warning">Need Modify</span>';
                        } else if($result->submit_to_check) {
                            echo '<span class="badge badge-info">Submitted</span>';
                        } else {
                            echo '<span class="badge badge-secondary">Draft</span>';
                        }
                        ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" 
                        onclick="choose_costing(<?php echo $result->id ?>, '<?php echo addslashes($result->modelno) ?>', <?php echo $result->fob_price ?>, '<?php echo addslashes($result->item_costing_desc) ?>')">
                            Pilih
                        </button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#table_costing_list').DataTable({
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
    </script>
</div>