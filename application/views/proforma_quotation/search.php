<div style="margin-bottom: 5px;margin-top: 5px;" class="pull-right">
    <nav class="pagination pagination-sm">
        <input type="hidden" id="offset" value="<?php echo ($offset < 1 ? 0 : ($offset - 1) ) ?>" />
        <ul class="pagination">
            <li class="">
                <a class="page-link-2" style="color: #167495;cursor: pointer;" onclick="proforma_quotation_search(0)">
                    <strong><span class="fa fa-refresh"></span> Refresh</strong>
                </a> 
            </li>
            <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="proforma_quotation_search(<?php echo $first ?>)">First</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous" onclick="proforma_quotation_search(<?php echo $prev ?>)">
                    <img src="images/prev.png" onclick="proforma_quotation_search(<?php echo $prev ?>)" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link"><?php echo $page ?></a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next" onclick="proforma_quotation_search(<?php echo $next ?>)">
                    <img src="images/next.png" onclick="proforma_quotation_search(<?php echo $next ?>)" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="proforma_quotation_search(<?php echo $last ?>)">Last</a>
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

<table id="table_proforma_quotation" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="border-top: 4px solid #ec9821;">
            <th width="2%" align=center>No</th>
            <th width="10%" align=center>Number</th>
            <th width="10%" align=center>Date</th>
            <th width="15%" align=center>Customer</th>
            <th width="10%" align=center>Created By</th>
            <th width="10%" align=center>Created At</th>
            <th width="15%" align=center>Action</th>
        </tr>
    </thead>
    <?php
    $counter = $offset + 1;
    $proforma_quotation_data = isset($proforma_quotation) ? $proforma_quotation : array();
    foreach ($proforma_quotation_data as $result) {
        $colour_td = "white";
        if ($counter % 2 == 0)
            $colour_td = "#ccffff";
        ?>
        <tr class="clickable-row" data-id="<?php echo $result->id ?>">
            <td align="right"><?php echo $counter++ ?></td>
            <td><?php echo $result->number ?></td>
            <td><?php echo date('d/m/Y', strtotime($result->date)) ?></td>
            <td><?php echo $result->customer_name ?></td>
            <td><?php echo $result->created_by ?></td>
            <td><?php echo date('d/m/Y H:i', strtotime($result->created_at)) ?></td>
            <td>
                <div class="drop">
                    <?php
                    if (in_array('view', $accessmenu)) {
                        echo '<a href="javascript:proforma_quotation_view_detail(' . $result->id . ');"><button class="btn btn-sm btn-primary"> <i class="fa fa-eye fa-sm"></i> View</button></a>';
                    }

                    if (in_array('edit', $accessmenu)) {
                        echo '&nbsp;<a href="javascript:proforma_quotation_edit(' . $result->id .
                        ');"><button class="btn btn-sm btn-success"> <i class="fa fa-edit fa-sm"></i> Edit </button></a>';
                    }

                    if (in_array('delete', $accessmenu)) {
                        echo "&nbsp;";
                        echo '<a href="javascript:proforma_quotation_delete(' . $result->id . ');"><button class="btn btn-sm btn-delete btn-danger"> Delete</button></a>';
                    }
                    ?>                                    
                </div>
            </td>
        </tr>
    <?php
    }
    ?>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table_proforma_quotation').DataTable({
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
        
        // Ketika baris di klik, tampilkan detail
        $('#table_proforma_quotation tbody').on('click', 'tr.clickable-row td:not(:last-child)', function () {
            var id = $(this).parent().data('id');
            console.log("dedi");
            proforma_quotation_view_detail(id);
            detail_search(id, 0);
        });
    });
</script>