<div style="margin-bottom: 5px;margin-top: 5px;" class="pull-right">
    <nav class="pagination pagination-sm">
        <input type="hidden" id="offset" value="<?php echo ($offset < 1 ? 0 : ($offset - 1) ) ?>" />
        <ul class="pagination">
            <li class="">
                <a class="page-link-2" style="color: #167495;cursor: pointer;" onclick="productprice_search(0)">
                    <strong><span class="fa fa-refresh"></span> Refresh</strong>
                </a> 
            </li>
            <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="productprice_search(<?php echo $first ?>)">First</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous" onclick="productprice_search(<?php echo $prev ?>)">
                    <img src="images/prev.png" onclick="productprice_search(<?php echo $prev ?>)" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link"><?php echo $page ?></a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next" onclick="productprice_search(<?php echo $next ?>)">
                    <img src="images/next.png" onclick="productprice_search(<?php echo $next ?>)" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="productprice_search(<?php echo $last ?>)">Last</a>
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

<table id="table_product_price" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr style="border-top: 4px solid #ec9821;">
            <th width="2%" align=center>No</th>
            <th width="10%" align=center>Ebako Code</th>
            <th width="10%" align=center>Customer Code</th>
            <th width="10%" align=center>Description</th>
            <th width="10%" align=center>Customer Name</th>
            <th width="10%" align=center>Quotation Date</th>
            <th width="10%" align=center>Approval Date</th>
            <th width="5%" align=center>CW</th>
            <th width="5%" align=center>CD</th>
            <th width="5%" align=center>CH</th>
            <th width="10%" align=center>Q Finished</th>
            <th width="10%" align=center>FOB</th>
            <th width="15%" align=center>Action</th>
        </tr>
    </thead>
    <?php
$counter = $offset + 1;
$product_prices = isset($product_prices) ? $product_prices : array();
foreach ($product_prices as $result) {
        $colour_td = "white";
        if ($counter % 2 == 0)
            $colour_td = "#ccffff";
        ?>
        <tr>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)" align="right"><?php echo $counter++ ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)"><?php echo $result->ebako_code ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)"><?php echo $result->customercode ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)"><?php echo $result->description ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)"><?php echo $result->customer_name ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)"><?php echo date('d/m/Y', strtotime($result->quotation_date)) ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)">
                <?php echo !empty($result->approval_date) ? date('d/m/Y', strtotime($result->approval_date)) : '-' ?>
            </td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->cw ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->cd ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)" align="center"><?php echo $result->ch ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)"><?php echo $result->q_finished ?></td>
            <td onclick="product_price_viewdetail(<?php echo $result->id ?>)" align="right"><?php echo number_format($result->fob, 2) ?></td>
            <td>
                <div class="drop">
                    <?php
                    // if (in_array('view', $accessmenu)) {
                    //     echo '<a href="javascript:product_price_viewdetail(' . $result->id . ');"><button class="btn btn-sm btn-primary"> <i class="fa fa-eye fa-sm"></i> View</button></a>';
                    // }

                    if (in_array('edit', $accessmenu)) {
                        echo '<a href="javascript:product_price_edit(' . $result->id .
                        ');"><button class="btn btn-sm btn-success"> <i class="fa fa-edit fa-sm"></i> Edit </button></a>';
                    }

                    if (in_array('delete', $accessmenu)) {
                        echo "&nbsp;&nbsp;&nbsp;";
                        echo '<a href="javascript:product_price_delete(' . $result->id . ');"><button class="btn btn-sm btn-delete btn-danger"> Delete</button></a>';
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
        var table = $('#table_product_price').DataTable({
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