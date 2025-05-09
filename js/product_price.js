var bbox;
function pro_view(){
    productprice_search(0);
    my_y_position = 0;
}

function productprice_createnew(){
    App.createContainer('productprice_temp');
    bbox = bootbox.dialog({
        title: 'Create Product Price',
        message: $('#productprice_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('product_price/createnew', function (content) {
            $('#productprice_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function pro_model_choose(){
    App.createContainer('pro_model_temp');
    var bbox = bootbox.dialog({
        title: 'Select Model',
        message: $('#pro_model_temp'),
        closeButton: true,
        size:'large',
    });
    bbox.init(function () {
        $.get('product_price/list_model/model/0/0', function (content) {
            $('#pro_model_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

var costingModal; // Variabel global untuk menyimpan referensi modal

function costing_list_choose() {
    var customerid = $('#customerid').val();
    var modelid = $('#modelid0').val();
    var temp = 'costing_list_temp'; // Atur sesuai nama temp di controller

    App.createContainer(temp);

    costingModal = bootbox.dialog({
        title: 'Select FOB Price',
        message: $('#' + temp),
        closeButton: true,
        size: 'large',
    });

    costingModal.init(function () {
        $.get('product_price/lists/' + temp + '/' + modelid + '/' + customerid, function (content) {
            $('#' + temp).empty().append(content);
        }).fail(function (data) {
            costingModal.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

// Helper function untuk format angka
function number_format(number, decimals) {
    // Pastikan number adalah angka yang valid
    if (isNaN(number) || number === null) {
        return '0'; // Nilai default jika tidak valid
    }

    // Jika angka adalah 0, langsung kembalikan "0" tanpa desimal
    if (parseFloat(number) === 0) {
        return '0';
    }

    // Format angka dengan desimal
    let formatted = parseFloat(number).toFixed(decimals);

    // Gunakan regex untuk menambahkan koma sebagai pemisah ribuan
    return formatted.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function model_search2(offset) {
    var id = $('#id').val();
    var temp = $('#temp').val();
    var code = $('#code_sd').val();
    var custcode = $('#custcode_s').val();
    var description = $('#description_sd').val();
    var modeltypeid = $('#modeltypeid_sd').val();
    var billto = $('#billto_s').val();
    $.post(url + 'model/search2/' + offset, {
        code: code,
        description: description,
        modeltypeid: modeltypeid,
        id: id,
        temp: temp,
        billto: billto,
        custcode: custcode
    }, function (content) {
        $('#searchmodeldata').empty();
        $('#searchmodeldata').append(content);
    });
}

function model_set2(id, temp, tempid) {
    var modelid = document.getElementsByName('modelid[]');
    var st = 0;
    for (var i = 0; i < modelid.length; i++) {
        if (modelid[i].value == id) {
            st = 1;
            break;
        }
    }
    if (st == 0) {
        $('#' + temp + 'id' + tempid).val(id);
        $('#' + temp + 'code' + tempid).val($('#code' + id).val());
        $('#' + temp + 'description' + tempid).val($('#description' + id).val());
        $('#' + temp + 'finishing' + tempid).val($('#finishoverview' + id).val());
        $('#' + temp + 'fabrication' + tempid).val($('#constructionoverview' + id).val());
        $('#billto').prop("disabled", true);
        
        // Menutup modal
        bootbox.hideAll();
    } else {
        App.errorForm.create({message: ' - Duplicate Model!'});
    }
}

var modelModal;
function model_list_choose() {
    var billto = $('#billto').val();

    App.createContainer('model_list_temp');
    modelModal = bootbox.dialog({
        title: 'Select Model',
        message: $('#model_list_temp'),
        closeButton: true,
        size: 'large',
    });

    modelModal.init(function () {
        $.get('product_price/list_model/model/0/' + billto, function (content) {
            $('#model_list_temp').empty().append(content);
        }).fail(function (data) {
            modelModal.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function select_quotation(fob_price, quation_id) {
    console.log('FOB Price terpilih:', fob_price);
    console.log('quotation:', quation_id);

    // Isi nilai ke input
    $('#costingcode0').val(fob_price);
    $('#costingid0').val(quation_id);

    // Tutup modal
    if (typeof modelModal !== 'undefined' && modelModal !== null) {
        modelModal.modal('hide');
    } else {
        // Cari modal bootbox yang paling atas
        var topModal = $('.bootbox').last();
        if (topModal.length > 0) {
            topModal.modal('hide');
        }
    }

    return false;
}

function choose_model(id, model_code, dw, dt, dht, custcode, description) {
    setTimeout(function() {
        if ($("#modelid0").length) {
            $('#modelid0').val(id);
            var customerid = $('#customerid').val();
            var modelid = $('#modelid0').val();
            get_costing(customerid, modelid);
        }

        if ($("#modelcode0").length) {
            $('#modelcode0').val(model_code);
        }

        if ($("#modelcode0").length) {
            $('#cw').val(dw);
        }
        if ($("#modelcode0").length) {
            $('#cd').val(dt);
        }
        if ($("#modelcode0").length) {
            $('#ch').val(dht);
        }
        if ($("#modelcode0").length) {
            $('#custcode').val(custcode);
        }
        if ($("#modelcode0").length) {
            $('#description').val(description);
        }

        // Tutup modal yang sebelumnya dibuka
        if (modelModal) {
            modelModal.modal("hide");
            modelModal = null; // Reset variabel setelah menutup modal
        }
    }, 100);

    return false;
}

function get_costing(id_cust, id_model) {
    $.ajax({
        url: url + "product_price/searchCostingByCustModel/" + id_cust + "/" + id_model,
        type: "GET",
        success: function (response) {
            $('#costing_result_container').html(response);
        },
        error: function (xhr) {
            console.error("Gagal mengambil data costing:", xhr.responseText);
            alert("Terjadi kesalahan saat mengambil data costing.");
        }
    });
}

function pro_savenew() {
    // Validasi field-field wajib
    var customerid = $('#customerid').val();
    var modelid = $('#modelcode0').val();
    var material = $('#material').val();
    console.log(material);
    var costingid = $('#costingcode0').val();
    var quotation_id = $('#costingid0').val();
    var cw = $('#cw').val();
    var cd = $('#cd').val();
    var ch = $('#ch').val();
    var description = $('#description').val();
    var custcode = $('#custcode').val();
    var quotation_date = $('#quotation_date').val();

    console.log(description);
    // Validasi data yang diperlukan
    if (customerid == 0 || customerid == "") {
        alert("Please select Customer!");
        $('#customerid').focus();
        return;
    }
    
    if (modelid == 0 || modelid == "") {
        alert("Please select Model!");
        $('#modelcode0').focus();
        return;
    }
    
    if (costingid == 0 || costingid == "") {
        alert("Please select FOB value!");
        $('#costingcode0').focus();
        return;
    }
    
    if (quotation_id == "") {
        $('#costingid0').focus();
        return;
    }
    
    if (cw == "" || isNaN(cw)) {
        alert("Please enter valid Width dimension!");
        $('#cw').focus();
        return;
    }
    
    if (cd == "" || isNaN(cd)) {
        alert("Please enter valid Depth dimension!");
        $('#cd').focus();
        return;
    }
    
    if (ch == "" || isNaN(ch)) {
        alert("Please enter valid Height dimension!");
        $('#ch').focus();
        return;
    }
    
    if (quotation_date == "") {
        alert("Please enter Quotation Date!");
        $('#quotation_date').focus();
        return;
    }
    
    // Persiapkan data untuk dikirim ke server
    var data = {
        'customerid': customerid,
        'quotation_id': quotation_id,
        'ebako_code': modelid,
        'quotation_date': quotation_date,
        'approval_date': $('#approval_date').val(),
        'cw': cw,
        'cd': cd,
        'ch': ch,
        'q_finished': $('#item_costing_q_wood').val(),
        'fob': costingid,
        'material': material,
        'customercode': custcode,
        'description': description,
    };

    console.log(data);
    $.ajax({
        url: url + 'product_price/savenew',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            bbox.modal("hide");
            console.log("Response:", response);
            productprice_search(0); 
        },
        error: function(xhr, status, error) {
            alert("Terjadi kesalahan: " + error);
            console.error("Error:", xhr.responseText);
        }
    });
}

function productprice_search(offset) {
    if (undefined == offset) {
        offset = 0;
    }
    var ebako_code = $('#ebako_code_s').val();
    var customer_code = $('#customer_code_s').val();
    var quotation_date_start = $('#quotation_date_start').val();
    var quotation_date_end = $('#quotation_date_end').val();
    var customerid = $('#customerid_search').val();
    
    $("#productpricedata").html("<center><img style='padding-top:50px;' src='images/loading1.gif'/></center>");
    $.post(url + 'product_price/search_productprice/' + offset, {
        ebako_code: ebako_code,
        customer_code: customer_code,
        quotation_date_start: quotation_date_start,
        quotation_date_end: quotation_date_end,
        customerid: customerid
    }, function (content) {
        $('#productpricedata').empty();
        $('#productpricedata').append(content);
    });
}

function product_price_edit(id){
    App.createContainer('productprice_temp');
    bbox = bootbox.dialog({
        title: 'Edit Product Price',
        message: $('#productprice_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('product_price/edit/' +id, function (content) {
            $('#productprice_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function pro_edit() {
    // Validasi field-field wajib
    var id = $('#id').val();
    console.log(id);
    var material = $('#material').val();
    var customerid = $('#customerid').val();
    var modelid = $('#modelcode0').val();
    var costingid = $('#costingcode0').val();
    var cw = $('#cw').val();
    var cd = $('#cd').val();
    var ch = $('#ch').val();
    var quotation_date = $('#quotation_date').val();
    var quotation_id = $('#costingid0').val();
    var description = $('#description').val();
    var custcode = $('#custcode').val();
    
    // Validasi data yang diperlukan
    if (customerid == 0 || customerid == "") {
        alert("Please select Customer!");
        $('#customerid').focus();
        return;
    }

    if (modelid == 0 || modelid == "") {
        alert("Please select Model!");
        $('#modelcode0').focus();
        return;
    }

    if (costingid == 0 || costingid == "") {
        alert("Please select FOB value!");
        $('#costingcode0').focus();
        return;
    }

    if (cw == "" || isNaN(cw)) {
        alert("Please enter valid Width dimension!");
        $('#cw').focus();
        return;
    }

    if (cd == "" || isNaN(cd)) {
        alert("Please enter valid Depth dimension!");
        $('#cd').focus();
        return;
    }

    if (ch == "" || isNaN(ch)) {
        alert("Please enter valid Height dimension!");
        $('#ch').focus();
        return;
    }

    if (quotation_date == "") {
        alert("Please enter Quotation Date!");
        $('#quotation_date').focus();
        return;
    }

    // Persiapkan data untuk dikirim ke server
    var data = {
        'id': id,
        'customerid': customerid,
        'quotation_id': quotation_id,
        'material': material,
        'ebako_code': modelid,
        'quotation_date': quotation_date,
        'approval_date': $('#approval_date').val(),
        'cw': cw,
        'cd': cd,
        'ch': ch,
        'q_finished': $('#q_finishes').val(),
        'fob': costingid,
        'customercode': custcode,
        'description': description
    };

    console.log("Data dikirim:", data);
    $.ajax({
        url: url + 'product_price/update',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            bbox.modal("hide");
            pro_view();
            Client.message.success("Product Price updated successfully...");
        },
        error: function(xhr, status, error) {
            alert("Terjadi kesalahan: " + error);
            console.error("Error:", xhr.responseText);
        }
    });
}

function product_price_delete(id) {
    if(confirm('Sure?')){
        $.get(url+'product_price/delete/'+id, function() {
            pro_view();
        });
    }
}

// Fungsi untuk membuka modal daftar sales quotation
function open_sales_quotation_list() {
    $('#salesQuotationModal').modal('show');
    search_approved_quotations();
}

// Fungsi untuk mencari quotation yang sudah disetujui
function search_approved_quotations() {
    var customer_id = $('#search_customer').val();
    
    $.ajax({
        url: url + "product_price/get_approved_quotations",
        type: "GET",
        data: { customer_id: customer_id },
        success: function(response) {
            $('#approved_quotations_list').html(response);
        },
        error: function(xhr, status, error) {
            console.error("Error fetching approved quotations:", error);
            alert("An error occurred while loading quotation data");
        }
    });
}

// Fungsi untuk mengimpor quotation yang dipilih ke product price
function import_selected_quotations() {
    var selectedQuotations = [];
    
    $('input[name="quotation_detail_checkbox"]:checked').each(function() {
        selectedQuotations.push($(this).val());
    });
    
    if (selectedQuotations.length === 0) {
        alert("Select at least one quotation to import!");
        return;
    }
    
    $.ajax({
        url: url + "product_price/import_quotations",
        type: "POST",
        data: { quotation_details: selectedQuotations },
        dataType: "json",
        success: function(response) {
            if (response.success) {
                alert("Data successfully imported into Product Price!");
                $('#salesQuotationModal').modal('hide');
                productprice_search(0); // Refresh data product price
            } else {
                alert("Failed to import data: " + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error importing quotations:", error);
            alert("An error occurred while importing data");
        }
    });
}

// Toggle semua checkbox
function toggle_all_quotations(checkbox) {
    $('input[name="quotation_detail_checkbox"]').prop('checked', checkbox.checked);
}



