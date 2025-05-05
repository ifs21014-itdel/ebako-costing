<div class="container-fluid">
    <table id="table_model_list" class="table table-striped table-bordered" cellspacing="0" style="width: 100%">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th width="12%">Model Code</th>
                <th width="25%">Description</th>
                <th width="12%">Customer Code</th>
                <th width="8%">Width</th>
                <th width="8%">Depth</th>
                <th width="8%">Height</th>
                <th width="10%">Input Date</th>
                <th width="9%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($models as $model) {
            ?>
                <tr>
                    <td align="right"><?php echo $counter++ ?></td>
                    <td><?php echo $model->no ?></td>
                    <td><?php echo $model->description ?></td>
                    <td><?php echo $model->custcode ?: '-' ?></td>
                    <td align="right"><?php echo number_format($model->dw, 2) ?></td>
                    <td align="right"><?php echo number_format($model->dd, 2) ?></td>
                    <td align="right"><?php echo number_format($model->dht, 2) ?></td>
                    <td><?php echo date('d-m-Y', strtotime($model->inputdate)) ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-success" 
                        onclick="choose_model(<?php echo $model->id ?>, '<?php echo addslashes($model->no) ?>', '<?php echo addslashes($model->dw) ?>','<?php echo addslashes($model->dd) ?>','<?php echo addslashes($model->dht) ?>','<?php echo addslashes($model->custcode) ?>','<?php echo addslashes($model->description) ?>')">
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
            $('#table_model_list').DataTable({
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
