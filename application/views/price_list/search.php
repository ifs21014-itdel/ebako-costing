<?php
/**
 * Search file for Price List
 */
?>

<!-- Panel pemilihan kolom yang diperbaiki -->
<div class="panel panel-default mb-3" id="column_selection_panel">
  
    <div style="margin-bottom: 5px;margin-top: 5px;" class="pull-right">
        <nav class="pagination pagination-sm">
            <input type="hidden" id="offset" value="<?php echo ($offset < 1 ? 0 : ($offset - 1) ); ?>" />
            <ul class="pagination">
                <li class="">
                    <a class="page-link-2" style="color: #167495;cursor: pointer;" onclick="pricelist_search(0)">
                        <strong><span class="fa fa-refresh"></span> Refresh</strong>
                    </a> 
                </li>
                <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>

                <li class="page-item">
                    <a class="page-link" href="#" onclick="pricelist_search(<?php echo $first; ?>)">First</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous" onclick="pricelist_search(<?php echo $prev; ?>)">
                        <img src="<?php echo base_url(); ?>images/prev.png" class="miniaction"/>
                    </a>
                </li>

                <li class="page-item">
                    <a class="page-link"><?php echo $page; ?></a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next" onclick="pricelist_search(<?php echo $next; ?>)">
                        <img src="<?php echo base_url(); ?>images/next.png" class="miniaction"/>
                    </a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="#" onclick="pricelist_search(<?php echo $last; ?>)">Last</a>
                </li>
                <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>
                <li class="">
                    <a class="page-link-2">
                        Total:  <strong><?php echo $num_page; ?></strong> Page(s),
                        <strong><?php echo $num_rows; ?></strong> Row(s)
                    </a> 
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Tambahkan header kolom selection -->
<table id="table_price_list_header" class="table table-striped table-bordered" cellspacing="0">
    <thead>
        <tr style="border-top: 4px solid #ec9821;">
            <th width="2%" align="center">No</th>
            <th width="10%" align="center">Customer Name</th>
            <th width="10%" align="center">Price List Date</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $counter = $offset + 1;
    $price_list = isset($price_list) ? $price_list : array();
    foreach ($price_list as $result) {
        $colour_td = ($counter % 2 == 0) ? "#ccffff" : "white";
    ?>
        <tr id="row_<?php echo $result->id; ?>" data-id="<?php echo $result->id; ?>" style="background-color: <?php echo $colour_td; ?>; cursor: pointer;" class="clickable-row">
            <td><?php echo $counter++; ?></td>
            <td><?php echo $result->customer_name; ?></td>
            <td><?php echo $result->price_list_date; ?></td>
        </tr>
    <?php
    }

    // Jika tidak ada data
    if (count($price_list) == 0) {
        echo '<tr><td colspan="3" align="center">No data found</td></tr>';
    }
    ?>
    </tbody>
</table>
<div id="detail_section" class="panel" style="display: none; margin-top: 20px;">
    <div class="panel-heading">
        <h3 class="panel-title"> Detail</h3>
    </div>
    <div class="panel-body">
        <div id="price_list_detail_content">
            <!-- Detail content will be loaded here -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var table = $('#table_price_list_header').DataTable({
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
        $('#table_price_list_header tbody').on('click', 'tr.clickable-row', function () {
            var id = $(this).data('id');
            price_list_view_detail(id);
        });
    });
</script>