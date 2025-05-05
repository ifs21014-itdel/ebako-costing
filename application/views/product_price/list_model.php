<div class="row" style="min-height: 300px;">
    <div align="left" style="padding: 7px 0;">
        <span style="font-style: italic;"><b>*Notes: Model list will show based on Customer selection</b></span>
        <br/><br/>
        <input type="hidden" id="temp" value="<?php echo $temp ?>" />
        <input type="hidden" id="id" value="<?php echo $id ?>" />
        <span class="labelelement">Model Code</span>
        <input type="text" name="code_s" id="code_sd" size="10" onkeypress="if(event.keyCode==13){model_search(0)}"/>    
        <span class="labelelement">Date From</span>
        <input type="date" name="date_from" id="date_from" onchange="model_search(0)"/>
        <span class="labelelement">Date To</span>
        <input type="date" name="date_to" id="date_to" onchange="model_search(0)"/>
        <input type="hidden" id="billto_s" value="<?php echo $billto ?>" />
        <button onclick="model_search(0)">Search</button>
    </div>

    <div id="searchmodeldata" style="padding: 10px;" class="row">
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
                            <a href="javascript:void(0)" onclick="view_model_detail(<?php echo $model->id ?>)">
                                <img src="images/view.png" title="View Detail" class="miniaction"/>
                            </a>
                            <a href="javascript:void(0)" onclick="edit_model(<?php echo $model->id ?>)">
                                <img src="images/edit.png" title="Edit" class="miniaction"/>
                            </a>
                            <a href="javascript:void(0)" onclick="delete_model(<?php echo $model->id ?>)">
                                <img src="images/delete.png" title="Delete" class="miniaction"/>
                            </a>
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

            function model_search(page) {
                var code = $('#code_sd').val();
                var dateFrom = $('#date_from').val();
                var dateTo = $('#date_to').val();
                var billto = $('#billto_s').val();
                
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url(); ?>index.php/product_price/search_model',
                    data: {
                        code: code,
                        date_from: dateFrom,
                        date_to: dateTo,
                        billto: billto,
                        page: page,
                        temp: $('#temp').val(),
                        id: $('#id').val()
                    },
                    success: function(data) {
                        $('#searchmodeldata').html(data);
                    }
                });
            }
        </script>
    </div>
</div>
