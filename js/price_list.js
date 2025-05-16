/**
 * JavaScript functions for Price List module
 */

/**
 * Search price list data with pagination
 * @param {int} offset - Pagination offset
 */
function pricelist_search(offset) {
    var model_name = $('#model_name_s').val();
    var customer_name = $('#customer_name_s').val();
    var customerid = $('#customerid_search').val();
    
    $.ajax({
        url: base_url + "index.php/price_list/search",
        type: "POST",
        data: {
            model_name: model_name,
            customer_name: customer_name,
            customerid: customerid,
            offset: offset
        },
        success: function(data) {
            $('#pricelistdata').html(data);
        },
        error: function(xhr, status, error) {
            console.error("Error pada pencarian: " + error);
            alert("Terjadi kesalahan saat mencari data. Silakan coba lagi.");
        }
    });
}

// function pricelist_search_detail(offset) {
//     var model_name = $('#model_name_s').val();
//     var customer_name = $('#customer_name_s').val();
//     var customerid = $('#customerid_search').val();
    
//     $.ajax({
//         url: base_url + "index.php/price_list/search_detail",
//         type: "POST",
//         data: {
//             model_name: model_name,
//             customer_name: customer_name,
//             customerid: customerid,
//             offset: offset
//         },
//         success: function(data) {
//             $('#pricelistdata').html(data);
//         },
//         error: function(xhr, status, error) {
//             console.error("Error pada pencarian: " + error);
//             alert("Terjadi kesalahan saat mencari data. Silakan coba lagi.");
//         }
//     });
// }

function pricelist_search_detail(proforma_quotation_id, offset) {
    var model_name = $('#model_name_s').val();
    var customer_name = $('#customer_name_s').val();
    var customerid = $('#customerid_search').val();
    console.log(proforma_quotation_id);

    $.ajax({
        url: base_url + "index.php/price_list/search_detail",
        type: "POST",
        data: {
            model_name: model_name,
            customer_name: customer_name,
            customerid: customerid,
            offset: offset,
            proforma_quotation_id: proforma_quotation_id // <-- ditambahkan
        },
        success: function(data) {
            $('#detail_section').html(data);
        }
    });
}


/**
 * View price list detail
 * @param {int} id - Price list ID
 */
function price_list_viewdetail(id) {
    $.ajax({
        url: base_url + "index.php/price_list/detail/" + id,
        type: "GET",
        success: function(data) {
            $('#pricelistdata').html(data);
        },
        error: function(xhr, status, error) {
            console.error("Error pada view detail: " + error);
            alert("Terjadi kesalahan saat melihat detail. Silakan coba lagi.");
        }
    });
}

/**
 * Edit price list
 * @param {int} id - Price list ID
 */
function price_list_edit(id) {
    App.createContainer('pricelist_temp');
    bbox = bootbox.dialog({
        title: 'Edit Price List',
        message: $('#pricelist_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('price_list/edit/' +id, function (content) {
            $('#pricelist_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function product_price_edit(id){
   
}

/**
 * Delete price list
 * @param {int} id - Price list ID
 */
function price_list_delete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data price list ini?')) {
        $.ajax({
            url: base_url + "index.php/price_list/delete/" + id,
            type: "GET",
            success: function(data) {
                if (data === 'success') {
                    pricelist_search(0);
                    alert('Data price list berhasil dihapus');
                } else {
                    alert('Gagal menghapus data price list');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error pada delete: " + error);
                alert("Terjadi kesalahan saat menghapus data. Silakan coba lagi.");
            }
        });
    }
}

/**
 * Cancel form and return to search view
 */
function price_list_cancel() {
    pricelist_search(0);
}

// Document ready handler
$(document).ready(function() {
    // Bind event handlers for search inputs
    $('#model_name_s, #customer_name_s').keypress(function(e) {
        if (e.which == 13) {
            pricelist_search(0);
            return false;
        }
    });
    
    // Bind change event for customer select
    $('#customerid_search').change(function() {
        pricelist_search(0);
    });
});


// Fungsi untuk melakukan pencarian
// function pricelist_search(offset) {
//     var model_name = $("#model_name_s").val();
//     var customer_name = $("#customer_name_s").val();
//     var customerid = $("#customerid_search").val();
    
//     $.ajax({
//         url: base_url + "index.php/price_list/search",
//         type: "POST",
//         data: {
//             model_name: model_name,
//             customer_name: customer_name,
//             customerid: customerid,
//             offset: offset
//         },
//         success: function(data) {
//             $("#pricelistdata").html(data);
//         }
//     });
// }



// Fungsi untuk edit
function price_list_edit(id) {
    window.location.href = base_url + "index.php/price_list/edit/" + id;
}

// Fungsi untuk delete
function price_list_delete(id) {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        $.ajax({
            url: base_url + "index.php/price_list/delete/" + id,
            type: "POST",
            success: function(data) {
                if (data === "success") {
                    alert("Data berhasil dihapus");
                    pricelist_search(0);
                } else {
                    alert("Gagal menghapus data");
                }
            },
            error: function() {
                alert("Terjadi kesalahan pada server");
            }
        });
    }
}

// Fungsi untuk mencetak baris yang dipilih dengan kolom yang dipilih
function printSelectedRows() {
    var selectedIds = [];
    var selectedColumns = [];
    
    // Mengumpulkan ID dari baris yang dicentang
    $('.print_checkbox:checked').each(function() {
        selectedIds.push($(this).val());
    });
    
    if (selectedIds.length === 0) {
        alert("Silakan pilih minimal satu baris untuk dicetak");
        return;
    }
    
    // Mengumpulkan kolom yang dipilih
    $('.column-checkbox:checked').each(function() {
        selectedColumns.push($(this).val());
    });
    
    if (selectedColumns.length === 0) {
        alert("Silakan pilih minimal satu kolom untuk dicetak");
        return;
    }
    
    // Redirect ke halaman print dengan parameter IDs yang dipilih dan kolom yang dipilih
    var url = base_url + 'index.php/price_list/print_price_list?ids=' + selectedIds.join(',') + '&columns=' + selectedColumns.join(',');
    window.open(url, '_blank');
}

// Fungsi untuk memilih semua baris
function toggleSelectAll() {
    var isChecked = $('#select_all').prop('checked');
    $('.print_checkbox').prop('checked', isChecked);
}

// Ketika dokumen siap
$(document).ready(function() {
    // Pilih semua kolom
    $('#select_all_columns').click(function() {
        $('.column-checkbox').prop('checked', true);
    });
    
    // Batalkan semua kolom
    $('#unselect_all_columns').click(function() {
        $('.column-checkbox').prop('checked', false);
    });
    
    // Toggle visibilitas panel pemilihan kolom
    $('#toggle_column_btn, #column_selection_panel .panel-heading').click(function() {
        $('#column_selection').collapse('toggle');
    });
});

/**
 * JavaScript functions untuk integrasi Price List
 * Tambahkan ini pada file price_list.js yang sudah ada
 */

// Fungsi untuk melihat detail price list
// Fungsi untuk menampilkan detail price list
function price_list_view_detail(id) {
    $.ajax({
        url: base_url + "index.php/price_list/view_detail/" + id,
        type: "GET",
        success: function(data) {
            // Tampilkan detail di section
            $('#price_list_detail_content').html(data);
            $('#detail_section').show();
            
            // Scroll ke detail section
            $('html, body').animate({
                scrollTop: $("#detail_section").offset().top - 20
            }, 500);
        },
        error: function(xhr, status, error) {
            console.error("Error loading detail: " + error);
            alert("Gagal memuat detail. Silakan coba lagi.");
        }
    });
}

$(document).ready(function () {
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
    });
    
    // Ketika baris di klik, tampilkan detail
    $('#table_price_list tbody').on('click', 'tr.clickable-row', function () {
        var id = $(this).data('id');
        price_list_view_detail(id);
    });
});

