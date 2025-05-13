<?php
// Di awal file search_detail.php

?>

<!-- Menambahkan panel pencarian -->
<div class="panel-body" id="menu_content_pricelist">
    <table width="100%" border="0">
        <tr>
            <td>
                <div align="left" class="form-inline" style="padding-top: 2px; margin-bottom: 15px;">
                    <div class="col-sm-8">
                        <input type="hidden" id="current_price_list_id" value="<?php echo isset($price_list_id) ? $price_list_id : 0; ?>">
                        <input type="hidden" id="pricelistid" value="0" /> <span class="labelelement">Find :</span> 
                        <input class="form-control" type="text" name="model_name_s" placeholder="Model Name" id="model_name_s" size="10" onkeypress="if (event.keyCode == 13) {
                                    pricelist_search_detail(document.getElementById('current_price_list_id').value,0);
                                }" /> 
                        <button class="btn btn-default" onclick="pricelist_search_detail(document.getElementById('current_price_list_id').value,0)">Search</button>
                    </div>
                    <div class="col-sm-4 text-right">
                        <button class="btn btn-primary" id="toggle_column_btn">
                            <i class="fa fa-columns"></i> Select Column
                        </button>
                        <button class="btn btn-info btn-print-selected" onclick="printSelectedRows('standard')">
                            <i class="fa fa-print"></i> Print Selected
                        </button>
                        <button class="btn btn-success btn-print-project" onclick="printSelectedRows('project')">
                            <i class="fa fa-file-text"></i> Print as Project
                        </button>
                        <?php if (in_array('create', $accessmenu)) { ?>
                            <button class="btn btn-primary" onclick="window.location.href='<?php echo base_url(); ?>index.php/price_list/create'">
                                <i class="fa fa-plus"></i> Add New
                            </button>
                        <?php } ?>
                    </div>    
                </div>
            </td>
        </tr>
    </table>
</div>

<!-- Panel pemilihan kolom yang diperbaiki -->
<div class="panel panel-default mb-3" id="column_selection_panel">
  
    <div style="margin-bottom: 5px;margin-top: 5px;" class="pull-right">
    <!-- Sisa kode Anda tetap sama -->
    <nav class="pagination pagination-sm">
        <input type="hidden" id="offset" value="<?php echo ($offset < 1 ? 0 : ($offset - 1) ); ?>" />
        <ul class="pagination">
            <li class="">
                <a class="page-link-2" style="color: #167495;cursor: pointer;" onclick="pricelist_search_detail(document.getElementById('current_price_list_id').value,0)">
                    <strong><span class="fa fa-refresh"></span> Refresh</strong>
                </a> 
            </li>
            <li class="">&nbsp;&nbsp;&nbsp;&nbsp;</li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="pricelist_search_detail(document.getElementById('current_price_list_id').value,<?php echo $first; ?>)">First</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous" onclick="pricelist_search_detail(document.getElementById('current_price_list_id').value,<?php echo $prev; ?>)">
                    <img src="<?php echo base_url(); ?>images/prev.png" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link"><?php echo $page; ?></a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next" onclick="pricelist_search_detail(document.getElementById('current_price_list_id').value,<?php echo $next; ?>)">
                    <img src="<?php echo base_url(); ?>images/next.png" class="miniaction"/>
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="#" onclick="pricelist_search_detail(document.getElementById('current_price_list_id').value,<?php echo $last; ?>)">Last</a>
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
    <div id="column_selection" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="date" id="col_date" checked>
                        <label class="form-check-label" for="col_date">Date</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="model_id" id="col_model_id" checked>
                        <label class="form-check-label" for="col_model_id">Model ID</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="customer_name" id="col_customer_name" checked>
                        <label class="form-check-label" for="col_customer_name">Customer Name</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox print-option-standard" type="checkbox" value="quantity" id="col_quantity" checked>
                        <label class="form-check-label" for="col_quantity">Quantity</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="last_costing_price" id="col_last_costing_price" checked>
                        <label class="form-check-label" for="col_last_costing_price">Last Costing Price</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="total_last_costing" id="col_total_last_costing" checked>
                        <label class="form-check-label" for="col_total_last_costing">Total Last Costing</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="last_quotation_price" id="col_last_quotation_price" checked>
                        <label class="form-check-label" for="col_last_quotation_price">Last Quotation Price</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="total_last_quotation" id="col_total_last_quotation" checked>
                        <label class="form-check-label" for="col_total_last_quotation">Total Last Quotation</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="target_price" id="col_target_price" checked>
                        <label class="form-check-label" for="col_target_price">Target Price</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="total_target_price" id="col_total_target_price" checked>
                        <label class="form-check-label" for="col_total_target_price">Total Target Price</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="rate" id="col_rate" checked>
                        <label class="form-check-label" for="col_rate">Rate</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="price_rate" id="col_price_rate" checked>
                        <label class="form-check-label" for="col_price_rate">Price Rate</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="total_price_rate" id="col_total_price_rate" checked>
                        <label class="form-check-label" for="col_total_price_rate">Total Price Rate</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="profit_percentage" id="col_profit_percentage" checked>
                        <label class="form-check-label" for="col_profit_percentage">Profit %</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="fixed_cost" id="col_fixed_cost" checked>
                        <label class="form-check-label" for="col_fixed_cost">Fixed Cost</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="variable_cost" id="col_variable_cost" checked>
                        <label class="form-check-label" for="col_variable_cost">Variable Cost</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input column-checkbox" type="checkbox" value="status" id="col_status" checked>
                        <label class="form-check-label" for="col_status">Status</label>
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <button class="btn btn-primary btn-sm" id="select_all_columns">Select All Column</button>
                <button class="btn btn-secondary btn-sm" id="unselect_all_columns">Cancel All Column</button>
            </div>
        </div>
    </div>
</div>
<!-- Tambahkan header kolom selection -->
<table id="table_price_list" class="table table-striped table-bordered" cellspacing="0">
    <thead>
        <tr style="border-top: 4px solid #ec9821;">
            <th width="2%" align="center">
                <input type="checkbox" id="select_all" onclick="toggleSelectAll()">
            </th>
            <th width="2%" align="center">No</th>
            <!-- <th width="2%" align="center">Date</th> -->
            <th width="8%" align="center">Model ID</th>
            <th width="10%" align="center">Customer Name</th>
            <th width="5%" align="center">Quantity</th>
            <th width="8%" align="center">Last Costing Price</th>
            <th width="8%" align="center">Total Last Costing</th>
            <th width="8%" align="center">Last Quotation Price</th>
            <th width="8%" align="center">Total Last Quotation</th>
            <th width="8%" align="center">Target Price</th>
            <th width="8%" align="center">Total Target Price</th>
            <th width="5%" align="center">Rate</th>
            <th width="5%" align="center">Price Rate</th>
            <th width="8%" align="center">Total Price Rate</th>
            <th width="5%" align="center">Profit %</th>
            <th width="6%" align="center">Fixed Cost</th>
            <th width="6%" align="center">Variable Cost</th>
            <th width="6%" align="center">Status</th>
            <th width="6%" align="center">Approval</th>
            <th width="8%" align="center">Action</th>
        </tr>
    </thead>
    <?php
    $counter = $offset + 1;
    $price_list = isset($price_list) ? $price_list : array();
    foreach ($price_list as $result) {
        $colour_td = "white";
        if ($counter % 2 == 0)
            $colour_td = "#ccffff";
        
        // Hitung total untuk kolom baru
        $total_last_costing = $result->quantity * $result->last_costing_price;
        $total_last_quotation = $result->quantity * $result->last_quotation_price;
        $total_target_price = $result->quantity * $result->target_price;
        $total_price_rate = $result->quantity * $result->price_rate;

        // Status styling berdasarkan nilai status
        $status_class = '';
        $status_text = isset($result->status) ? $result->status : 'Draft';

        
        if (strtolower($status_text) == 'final') {
            $status_class = 'badge bg-success text-white';
        } else {
            $status_class = 'badge bg-warning text-dark';
        }
        ?>
        <tr>
            <td align="center">
                <input type="checkbox" class="print_checkbox" value="<?php echo $result->id; ?>" data-row="<?php echo $counter-1; ?>">
            </td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo $counter++; ?></td>
            <!-- <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)"><?php echo $result->price_list_date; ?></td> -->
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)"><?php echo $result->model_no; ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)"><?php echo $result->customer_name; ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="center"><?php echo $result->quantity; ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($result->last_costing_price, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($total_last_costing, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($result->last_quotation_price, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($total_last_quotation, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($result->target_price, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($total_target_price, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="center"><?php echo $result->rate; ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($result->price_rate, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($total_price_rate, 2); ?></td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="center"><?php echo $result->profit_percentage; ?>%</td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($result->fixed_cost, 2); ?>%</td>
            <td onclick="price_list_viewdetail(<?php echo $result->id; ?>)" align="right"><?php echo number_format($result->variable_cost, 2); ?>%</td>
            <td align="center">
                <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                <?php if (strtolower($status_text) != 'final' && in_array('edit', $accessmenu)): ?>
                    <br/>
                    <button class="btn btn-sm btn-primary mt-1" onclick="price_list_update_status(<?php echo $result->id; ?>, 'Final')">
                        <i class="fa fa-check fa-sm"></i> Set Final
                    </button>
                <?php endif; ?>
            </td>
            <!-- Kolom Approval -->
            <td align="center">
                <?php if (isset($result->approval_date) && isset($result->approval_price) && !empty($result->approval_date) && !empty($result->approval_price)): ?>
                    <span class="badge bg-success text-white">Approved</span><br>
                    <small><?php echo date('d-m-Y', strtotime($result->approval_date)); ?></small><br>
                    <small><?php echo number_format($result->approval_price, 2); ?></small>
                <?php else: ?>
                    <?php if (in_array('edit', $accessmenu)): ?>
                    <button class="btn btn-sm btn-info" onclick="openApprovalModal(<?php echo $result->id; ?>, 
                        <?php echo $result->target_price; ?>, 
                        <?php echo isset($result->picklist_rate) ? $result->picklist_rate : 0; ?>, 
                        <?php echo $result->price_rate; ?>)">
                        <i class="fa fa-check-circle fa-sm"></i> Approve
                    </button>
                    <?php else: ?>
                    <span class="badge bg-warning text-dark">Pending</span>
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td>
                <div class="drop">
                    <?php
                    if (in_array('edit', $accessmenu)) {
                        echo '<a href="javascript:price_list_edit(' . $result->id .
                        ');"><button class="btn btn-sm btn-success"> <i class="fa fa-edit fa-sm"></i> Edit </button></a>';
                    }
                    
                    if (in_array('delete', $accessmenu)) {
                        echo "&nbsp;&nbsp;&nbsp;";
                        echo '<a href="javascript:price_list_delete(' . $result->id . ');"><button class="btn btn-sm btn-delete btn-danger"> <i class="fa fa-trash fa-sm"></i> Delete</button></a>';
                    }
                    ?>                                    
                </div>
            </td>
        </tr>
    <?php
    }
    
    // Jika tidak ada data
    if (count($price_list) == 0) {
        echo '<tr><td colspan="21" align="center">No data found</td></tr>';
    }
    ?>
</table>

<div class="modal fade" id="approvalModal" tabindex="-1" role="dialog" aria-labelledby="approvalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="approvalModalLabel">Approve Price List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="approvalForm">
                    <input type="hidden" id="pricelist_id" name="pricelist_id">
                    
                    <div class="form-group">
                        <label for="approval_date">Approval Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="approval_date" name="approval_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price_selection">Select Price <span class="text-danger">*</span></label>
                        <select class="form-control" id="price_selection" name="price_selection" required>
                            <option value="">-- Select Price --</option>
                            <option value="target_price">Target Price</option>
                            <option value="picklist_rate">Picklist Rate</option>
                            <option value="price_rate">Price Rate</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="approval_price">Approval Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="approval_price" name="approval_price"  required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitApproval">Save Approval</button>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk fungsi update status -->
<script type="text/javascript">
    function price_list_update_status(id, status) {
        if (confirm("Are you sure you want to change the status to " + status + "?")) {
            $.ajax({
                url: base_url + "index.php/price_list/update_status/" + id,
                type: "POST",
                data: {
                    status: status
                },
                success: function(data) {
                    if (data === 'success') {
                        alert("Status successfully updated to " + status);
                        pricelist_search(<?php echo $offset; ?>); // Refresh tampilan
                    } else {
                        alert("Failed to update status");
                    }
                },
                error: function() {
                    alert("An error occurred on the server");
                }
            });
        }
    }

    // Fungsi untuk toggle semua checkbox baris
    function toggleSelectAll() {
        var isChecked = $('#select_all').prop('checked');
        $('.print_checkbox').prop('checked', isChecked);
    }

 $(document).ready(function () {
        // Perbaikan struktur tabel untuk DataTables
        if ($('#table_price_list').find('tbody').length === 0) {
            // Tambahkan elemen tbody jika belum ada
            $('#table_price_list').append('<tbody></tbody>');
            
            // Pindahkan semua baris data (selain header) ke tbody
            $('#table_price_list tr:not(thead tr)').appendTo('#table_price_list tbody');
        }
        
        // Periksa dan perbaiki jumlah kolom di setiap baris
        var headerColumns = $('#table_price_list thead tr:first th').length;
        $('#table_price_list tbody tr').each(function() {
            var rowColumns = $(this).find('td').length;
            if (rowColumns !== headerColumns) {
                console.warn('Baris dengan jumlah kolom yang tidak sama ditemukan: ' + rowColumns + ' vs ' + headerColumns);
                // Tambahkan sel kosong jika kurang
                for (var i = rowColumns; i < headerColumns; i++) {
                    $(this).append('<td></td>');
                }
            }
        });
        
        // DataTable inisialisasi dengan error handling dan opsi tambahan
        try {
            var table = $('#table_price_list').DataTable({
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                autoWidth: true,
                select: true,
                retrieve: true, // Mencegah inisialisasi ganda
                columnDefs: [
                    { targets: '_all', defaultContent: '' } // Mengisi sel kosong
                ]
            });
        } catch (e) {
            console.error("DataTables error:", e);
            
            // Fallback jika DataTables gagal diinisialisasi
            $('#table_price_list').addClass('table-responsive');
        }
        
        // Toggle visibilitas panel pemilihan kolom
        $("#toggle_column_btn").click(function() {
            $("#column_selection").collapse('toggle');
        });
        
        $('#column_selection_panel .panel-heading').click(function() {
            $('#column_selection').collapse('toggle');
        });
        
        // Pilih semua kolom
        $('#select_all_columns').click(function() {
            $('.column-checkbox').prop('checked', true);
            updateColumnVisibility();
        });
        
        // Batalkan semua kolom
        $('#unselect_all_columns').click(function() {
            $('.column-checkbox').prop('checked', false);
            updateColumnVisibility();
        });
        
        // Tambahkan event listener untuk checkbox kolom
        $('.column-checkbox').change(function() {
            updateColumnVisibility();
        });
        
        // Fungsi untuk memperbarui visibilitas kolom
        function updateColumnVisibility() {
            if ($.fn.dataTable.isDataTable('#table_price_list')) {
                $('.column-checkbox').each(function() {
                    var columnName = $(this).val();
                    var isVisible = $(this).prop('checked');
                    
                    // Cari indeks kolom berdasarkan nama kolom
                    var columnIndex = -1;
                    $('#table_price_list thead th').each(function(index) {
                        if ($(this).text().trim().toLowerCase().includes(columnName.replace(/_/g, ' '))) {
                            columnIndex = index;
                            return false; // Hentikan pencarian
                        }
                    });
                    
                    if (columnIndex > 1) { // Abaikan kolom checkbox dan No
                        try {
                            table.column(columnIndex).visible(isVisible);
                        } catch (e) {
                            console.warn("Tidak dapat mengubah visibilitas kolom:", columnName, e);
                        }
                    }
                });
            }
        }

        // Tambahkan kondisi validasi sebelum print
        $(document).on('click', '.btn-print-selected', function() {
            printSelectedRows('standard');
        });
        
        $(document).on('click', '.btn-print-project', function() {
            printSelectedRows('project');
        });
    });

    // Fungsi untuk mencetak baris yang dipilih dengan kolom yang dipilih
    function printSelectedRows(printType) {
        var selectedIds = [];
        var selectedColumns = [];
        
        // Mengumpulkan ID dari baris yang dicentang
        $('.print_checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });
        
        if (selectedIds.length === 0) {
            alert("Please select at least one row to print.");
            return;
        }
        
        // Mengumpulkan kolom yang dipilih
        $('.column-checkbox:checked').each(function() {
            // Jika tipe print standard, skip kolom quantity
            if (printType === 'standard' && $(this).val() === 'quantity') {
                return true; // Skip quantity untuk standard print
            }
            if (printType === 'standard' && $(this).val() === 'total_last_costing') {
                return true; // Skip quantity untuk standard print
            }
            if (printType === 'standard' && $(this).val() === 'total_last_quotation') {
                return true; // Skip quantity untuk standard print
            }
            if (printType === 'standard' && $(this).val() === 'total_target_price') {
                return true; // Skip quantity untuk standard print
            }
             if (printType === 'standard' && $(this).val() === 'total_price_rate') {
                return true; // Skip quantity untuk standard print
            }
            
            
            selectedColumns.push($(this).val());
        });

        // Pastikan quantity disertakan untuk tipe print project
        if (printType === 'project') {
            if (!selectedColumns.includes('quantity')) {
                selectedColumns.push('quantity');
            }
        }
        
        if (selectedColumns.length === 0) {
            alert("Please select at least one column to print.");
            return;
        }
        
        // Redirect ke halaman print dengan parameter IDs yang dipilih dan kolom yang dipilih
        var url = base_url + 'index.php/price_list/print_price_list?ids=' + 
                  selectedIds.join(',') + '&columns=' + selectedColumns.join(',') + 
                  '&print_type=' + printType;
        window.open(url, '_blank');
    }
</script>


<script type="text/javascript">
    // Data untuk menyimpan harga-harga
    var priceData = {};
    
    // Fungsi untuk membuka modal approval
    function openApprovalModal(id, targetPrice, picklistRate, priceRate) {
        // Simpan data harga
        priceData = {
            target_price: targetPrice,
            picklist_rate: picklistRate,
            price_rate: priceRate
        };
        
        // Set ID price list
        $('#pricelist_id').val(id);
        
        // Set tanggal approval ke hari ini
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('#approval_date').val(today);
        
        // Reset nilai price selection
        $('#price_selection').val('');
        $('#approval_price').val('');
        
        // Buka modal
        $('#approvalModal').modal('show');
    }
    
    // Event handler untuk perubahan pada price selection
    $('#price_selection').change(function() {
        var selectedPrice = $(this).val();
        if (selectedPrice && priceData[selectedPrice]) {
            $('#approval_price').val(priceData[selectedPrice]);
        } else {
            $('#approval_price').val('');
        }
    });
    
    // Event handler untuk tombol submit approval
    $('#submitApproval').click(function() {
        // Validasi form
        var form = $('#approvalForm')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        var id = $('#pricelist_id').val();
        var approvalDate = $('#approval_date').val();
        var approvalPrice = $('#approval_price').val();
        
        // Kirim data ke server
        $.ajax({
            url: base_url + "index.php/price_list/update_approval/" + id,
            type: "POST",
            data: {
                approval_date: approvalDate,
                approval_price: approvalPrice
            },
            success: function(data) {
                if (data === 'success') {
                    $('#approvalModal').modal('hide');
                    alert("Approval berhasil disimpan");
                    pricelist_search(<?php echo isset($offset) ? $offset : 0; ?>); // Tambahkan pengecekan isset
                } else {
                    alert("Gagal menyimpan approval");
                }
            },
            error: function() {
                alert("Terjadi kesalahan pada server");
            }
        });
    });
</script>