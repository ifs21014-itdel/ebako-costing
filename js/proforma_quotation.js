/* 
 * JavaScript functions for Proforma Quotation
 */

function proforma_quotation_search(offset) {
    var model = $('#model_name_s').val();
    var customer = $('#customer_name_s').val();
    var customerid = $('#customerid_search').val();
    
    $.ajax({
        url: base_url + "index.php/proforma_quotation/search",
        type: "POST",
        data: {
            model: model,
            customer: customer,
            customerid: customerid,
            offset: offset
        },
        success: function(data) {
            $('#proforma_quotation_data').html(data);
            // Sembunyikan detail section ketika search baru dilakukan
            $('#detail_section').hide();
        }
    });
}

function proforma_quotation_view_detail(id) {
    $.ajax({
        url: base_url + "index.php/proforma_quotation/view_detail/" + id,
        type: "GET",
        success: function(data) {
            // Tampilkan detail di section bagian bawah
            $('#proforma_quotation_detail_content').html(data);
            $('#detail_section').show();
           
            
            // Scroll ke detail section
            $('html, body').animate({
                scrollTop: $("#detail_section").offset().top - 20
            }, 500);
        }
    });
}

function proforma_quotation_edit(id) {
    App.createContainer('proforma_edit_temp');
    bbox = bootbox.dialog({
        title: 'Edit Proforma Quotation',
        message: $('#proforma_edit_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('proforma_quotation/edit/' + id, function (content) {
            $('#proforma_edit_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
    // window.location.href = base_url + 'index.php/proforma_quotation/edit/' + id;
}

function proforma_quotation_delete(id) {
    if (confirm('Are you sure want to delete this proforma quotation?')) {
        $.ajax({
            url: base_url + "index.php/proforma_quotation/delete/" + id,
            type: "GET",
            success: function(data) {
                if (data === 'success') {
                    alert('Proforma quotation has been deleted successfully!');
                    proforma_quotation_search(0);
                    // Sembunyikan detail section jika item yang dihapus sedang ditampilkan
                    $('#detail_section').hide();
                } else {
                    alert('Failed to delete proforma quotation!');
                }
            }
        });
    }
}

function printSelectedRows() {
    // Implementasi untuk mencetak baris yang dipilih
    var selectedRows = $('#table_proforma_quotation').DataTable().rows({selected: true}).data();
    if (selectedRows.length === 0) {
        alert('Please select rows to print!');
        return;
    }
    
    // Kode untuk memproses pencetakan di sini
    // ...
}



function detail_search(proforma_quotation_id, offset) {
    var ebako_code = $('#ebako_code_s').val();
    var customer_code = $('#customer_code_s').val();
    
    $.ajax({
        url: base_url + "index.php/proforma_quotation/search_detail",
        type: "POST",
        data: {
            proforma_quotation_id: proforma_quotation_id,
            ebako_code: ebako_code,
            customer_code: customer_code,
            offset: offset
        },
        success: function(data) {
            $('#proforma_quotation_detail_content').html(data);
        }
    });
}

/**
 * Update function view_detail untuk menampilkan detail dengan pagination
 */
function proforma_quotation_view_detail(id) {
    $.ajax({
        url: base_url + "index.php/proforma_quotation/view_proforma_detail/" + id,
        type: "GET",
        success: function(data) {
            // Tampilkan detail di section bagian bawah
            $('#proforma_quotation_detail_content').html(data);
            $('#detail_section').show();
            
            // Scroll ke detail section
            $('html, body').animate({
                scrollTop: $("#detail_section").offset().top - 20
            }, 500);
        }
    });
}


function proforma_createnew(){
    App.createContainer('proforma_temp');
    bbox = bootbox.dialog({ // Initialize bbox here
        title: 'Create Proforma Quotation',
        message: $('#proforma_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('proforma_quotation/createnew', function (content) {
            $('#proforma_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}




function proforma_savenew() {
    // Validasi field-field wajib
    var customerid = $('#customerid').val();

    var number = $('#number').val();
    var date= $('#date').val();

    
    // Validasi data yang diperlukan
    if (customerid == 0 || customerid == "") {
        alert("Please select Customer!");
        $('#customerid').focus();
        return;
    }
    
    if (number == 0 || number == "") {
        alert("Please input Number!");
        $('#number').focus();
        return;
    }    
    if (date == "") {
        alert("Please enter Date!");
        $('#date').focus();
        return;
    }
    
    // Persiapkan data untuk dikirim ke server
    var data = {
        'customer_id': customerid,
        'date': date,
        'number' :number,
    };

	console.log(data);
	$.ajax({
        url: url + 'proforma_quotation/create_proforma',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
			bbox.modal("hide");
            console.log("Response:", response);
            proforma_quotation_search(0); 
        },
        error: function(xhr, status, error) {
            alert("Terjadi kesalahan: " + error);
            console.error("Error:", xhr.responseText);
        }
    });
    
   
}

function proforma_edit() {
    // Validasi field-field wajib
    var id = $('#id').val();
    var customerid = $('#customerid').val();

    var number = $('#number').val();
    var date= $('#date').val();

    
    // Validasi data yang diperlukan
    if (customerid == 0 || customerid == "") {
        alert("Please select Customer!");
        $('#customerid').focus();
        return;
    }
    
    if (number == 0 || number == "") {
        alert("Please input Number!");
        $('#number').focus();
        return;
    }    
    if (date == "") {
        alert("Please enter Date!");
        $('#date').focus();
        return;
    }
    
    // Persiapkan data untuk dikirim ke server
    var data = {
        'id' :id,
        'customer_id': customerid,
        'date': date,
        'number' :number,
    };

	console.log(data);
	$.ajax({
        url: url + 'proforma_quotation/edit_proforma',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
			bbox.modal("hide");
            console.log("Response:", response);
            proforma_quotation_search(0); 
        },
        error: function(xhr, status, error) {
            alert("Terjadi kesalahan: " + error);
            console.error("Error:", xhr.responseText);
        }
    });
    
   
}



function proforma_createnewdetail(id,customer_id){
    App.createContainer('proformadetail_temp');
    bbox = bootbox.dialog({ // Initialize bbox here
        title: 'Create Proforma Quotation',
        message: $('#proformadetail_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('proforma_quotation/createnewdetail', function (content) {
            $('#proformadetail_temp').empty().append(content);
            $('#proforma_quation_id').val(id);
            $('#customerid').val(customer_id);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}


function proforma_createnewdetail_from_product_price(id,customer_id){
    App.createContainer('proformadetail_from_product_price_temp');
    bbox = bootbox.dialog({ // Initialize bbox here
        title: 'Create Proforma Quotation',
        message: $('#proformadetail_from_product_price_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('proforma_quotation/createnewdetail_from_product_price', function (content) {
            $('#proformadetail_from_product_price_temp').empty().append(content);
            $('#proforma_quation_id').val(id);
            $('#customerid').val(customer_id);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}
function model_list_choose() {
    var billto = $('#billto').val();

    App.createContainer('model_list_temp');
    modelModal = bootbox.dialog({ // Simpan referensi modal ke variabel global
        title: 'Select Model',
        message: $('#model_list_temp'),
        closeButton: true,
        size: 'large',
    });

    modelModal.init(function () {
        $.get('proforma_quotation/list_model/model/0/' + billto, function (content) {
            $('#model_list_temp').empty().append(content);
        }).fail(function (data) {
            modelModal.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function choose_model(id, model_code, dw, dt, dht, custcode, description) {
    setTimeout(function() {
        if ($("#modelid0").length) {
            $('#modelid0').val(id);
            var customerid = $('#customerid').val();
            var modelid = id; // Gunakan id model yang baru dipilih
            
            // Ambil data costing berdasarkan model dan customer
            get_costing_data(customerid, modelid);
        }

        if ($("#modelcode0").length) {
            $('#modelcode0').val(model_code);
        }

        if ($("#modelcode0").length) {
            $('#modelid0').val(id);
        }
        if ($("#modelcode0").length) {
            $('#custcode').val(custcode);
        }
        // Tutup modal yang sebelumnya dibuka
        if (modelModal) {
            modelModal.modal("hide");
            modelModal = null; // Reset variabel setelah menutup modal
        }
    }, 100);

    return false;
}

function get_costing_data(customerid, modelid) {
    $.ajax({
        url: url + "proforma_quotation/getCostingData/" + customerid + "/" + modelid,
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response && response.success && response.data) {
                // Isi field fob_costing dengan nilai fob_price dari costing
                $('#fob_costing').val(response.data.fob_price);
            }
        },
        error: function(xhr, status, error) {
            console.error("Error getting costing data:", error);
        }
    });
}


function get_costing(id_cust, id_model) {
    $.ajax({
        url: url + "proforma_quotation/searchCostingByCustModel/" + id_cust + "/" + id_model,
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

function costing_list_choose() {
    var customerid = $('#customerid').val();
    console.log(customerid);
    var modelid = $('#modelid0').val();
    
    // Gunakan container yang berbeda untuk modal costing
    var costingContainerId = 'costing_list_temp';
    
    // Buat container baru khusus untuk modal costing
    App.createContainer(costingContainerId);
    
    // Buat modal baru dengan container tersebut
    var costingModal = bootbox.dialog({
        title: 'Select FOB Price',
        message: $('#' + costingContainerId),
        closeButton: true,
        size: 'large',
    });

    costingModal.init(function () {
        $.get('proforma_quotation/lists/' + costingContainerId + '/' + modelid + '/' + customerid, function (content) {
            $('#' + costingContainerId).empty().append(content);
        }).fail(function (data) {
            costingModal.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function select_quotation(fob_price, quation_id) {
    // Isi nilai ke input
    $('#quotation_detail_fob').val(fob_price);
    $('#quotation_detail_id').val(quation_id);
quotation_detail_fob
    // Tutup modal costing
    $('.bootbox').last().modal('hide');

    return false;
}


function product_price_list_choose() {
    // Gunakan container yang berbeda untuk modal product price
    var priceContainerId = 'product_price_list_temp';
    
    // Buat container baru khusus untuk modal product price
    App.createContainer(priceContainerId);
    
    // Buat modal baru dengan container tersebut
    var priceModal = bootbox.dialog({
        title: 'Select Product Price',
        message: $('#' + priceContainerId),
        closeButton: true,
        size: 'large',
    });

    priceModal.init(function () {
        $.get('proforma_quotation/lists_product_price/' + priceContainerId, function (content) {
            $('#' + priceContainerId).empty().append(content);
        }).fail(function (data) {
            priceModal.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function product_price_list_choose_2() {
    // Gunakan container yang berbeda untuk modal product price
    var priceContainerId = 'product_price_list_temp';
    
    // Buat container baru khusus untuk modal product price
    App.createContainer(priceContainerId);
    
    // Buat modal baru dengan container tersebut
    var priceModal = bootbox.dialog({
        title: 'Select Product Price',
        message: $('#' + priceContainerId),
        closeButton: true,
        size: 'large',
    });

    priceModal.init(function () {
        $.get('proforma_quotation/lists_product_price_2/' + priceContainerId, function (content) {
            $('#' + priceContainerId).empty().append(content);
        }).fail(function (data) {
            priceModal.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function select_product_price(fob_price, price_id) {
    // Isi nilai ke input
    $('#productpricecode0').val(fob_price);
    $('#productpriceid0').val(price_id);

    // Tutup modal product price
    $('.bootbox').last().modal('hide');

    return false;
}

function select_product_price_2(fob_price, price_id,customercode,ebako_code) {
    // Isi nilai ke input
    $('#productpricecode0').val(fob_price);
    $('#productpriceid0').val(price_id);
    $('#ebako_code').val(ebako_code);
    $('#cust_code').val(customercode);

    console.log('=== Log Nilai Form ===');
    console.log('proforma_quation_id:', $('#proforma_quation_id').val());
    console.log('productpriceid0:', $('#productpriceid0').val());
    console.log('productpricecode0:', $('#productpricecode0').val());
    console.log('ebako_code:', $('#ebako_code').val());
    console.log('cust_code:', $('#cust_code').val());
    console.log('remark:', $('#remark').val());
    console.log('======================');


    // Tutup modal product price
    $('.bootbox').last().modal('hide');

    return false;
}


function pro_model_choose(){
	//App.modalForm.create({'element':'costing_model','title':'Select Model','large':true, 'url':'model/lists/model/0/0'});
	App.createContainer('pro_model_temp');
	var bbox = bootbox.dialog({
		title: 'Select Model',
		message: $('#pro_model_temp'),
		closeButton: true,
		size:'large',
	});
	bbox.init(function () {
		$.get('proforma_quotation/list_model/model/0/0', function (content) {
			$('#pro_model_temp').empty().append(content);
		}).done(function () {
		}).fail(function (data) {
			bbox.modal("hide");
			Client.message.error({'data': data});
		});
	});
}


function proforma_createnew(){
    App.createContainer('proforma_temp');
    bbox = bootbox.dialog({ // Initialize bbox here
        title: 'Create Proforma Quotation',
        message: $('#proforma_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('proforma_quotation/createnew', function (content) {
            $('#proforma_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}




function proforma_detail_savenew() {
    // Ambil nilai dari form
    var proforma_quotation_id = $('#proforma_quation_id').val() || 0;
    var ebako_code = $('#modelcode0').val() || '';
    var model_id = $('#modelid0').val() || 0;
    var customer_code = $('#custcode').val() || '';
    var product_price_id = $('#productpriceid0').val() || 0;
    var quotation_detail_id = $('#quotation_detail_id').val() || 0;
    var fob_quotation = $('#quotation_detail_fob').val() || 0;
    var fob_product_price = $('#productpricecode0').val() || 0;
    var fob_costing = $('#fob_costing').val() || 0;
    var remark = $('#remark').val() || '';
    var type = "Not From Product Price";

    // Console log semua nilai
    console.log("proforma_quotation_id:", proforma_quotation_id);
    console.log("ebako_code:", ebako_code);
    console.log("model_id:", model_id);
    console.log("customer_code:", customer_code);
    console.log("product_price_id:", product_price_id);
    console.log("quotation_detail_id:", quotation_detail_id);
    console.log("fob_quotation:", fob_quotation);
    console.log("fob_product_price:", fob_product_price);
    console.log("fob_costing:", fob_costing);
    console.log("remark:", remark);

    // Siapkan data yang akan dikirim ke server
    var data = {
        proforma_quotation_id: parseInt(proforma_quotation_id),
        ebako_code: ebako_code,
        model_id: parseInt(model_id),
        customer_code: customer_code,
        product_price_id: parseInt(product_price_id),
        quotation_detail_id: parseInt(quotation_detail_id),
        fob_quotation: parseFloat(fob_quotation),
        fob_product_price: parseFloat(fob_product_price),
        fob_costing: parseFloat(fob_costing),
        remark: remark,
        type : type,
    };

    // Kirim data ke server via AJAX
    $.ajax({
        url: url + 'proforma_quotation/create_proforma_detail',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            console.log("Response:", response);
            // alert("Data berhasil disimpan.");
            bbox.modal("hide");  // Menutup modal setelah berhasil
            proforma_quotation_view_detail(proforma_quotation_id);
           
        },
        error: function(xhr, status, error) {
            alert("Terjadi kesalahan: " + error);
            console.error("Error:", xhr.responseText);
        }
    });
}

function proforma_detail_savenew_from_product_price() {
    // Ambil nilai dari form
    var proforma_quotation_id = $('#proforma_quation_id').val() || 0;
    var ebako_code = 0;
    var model_id = 0;
    var customer_code = $('#cust_code').val() || '';
    var product_price_id = $('#productpriceid0').val() || 0;
    var quotation_detail_id =  0;
    var fob_quotation =  0;
    var fob_product_price = $('#productpricecode0').val() || 0;
    var fob_costing = 0;
    var remark = $('#remark').val() || '';
    var type = "From Product Price";

    // Console log semua nilai
    console.log("proforma_quotation_id:", proforma_quotation_id);
    console.log("ebako_code:", ebako_code);
    console.log("model_id:", model_id);
    console.log("customer_code:", customer_code);
    console.log("product_price_id:", product_price_id);
    console.log("quotation_detail_id:", quotation_detail_id);
    console.log("fob_quotation:", fob_quotation);
    console.log("fob_product_price:", fob_product_price);
    console.log("fob_costing:", fob_costing);
    console.log("remark:", remark);

    // Siapkan data yang akan dikirim ke server
    var data = {
        proforma_quotation_id: parseInt(proforma_quotation_id),
        ebako_code: ebako_code,
        model_id: parseInt(model_id),
        customer_code: customer_code,
        product_price_id: parseInt(product_price_id),
        quotation_detail_id: parseInt(quotation_detail_id),
        fob_quotation: parseFloat(fob_quotation),
        fob_product_price: parseFloat(fob_product_price),
        fob_costing: parseFloat(fob_costing),
        remark: remark,
        type : type,
    };

    // Kirim data ke server via AJAX
    $.ajax({
        url: url + 'proforma_quotation/create_proforma_detail',
        type: 'POST',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            console.log("Response:", response);
            // alert("Data berhasil disimpan.");
            bbox.modal("hide");  // Menutup modal setelah berhasil
            proforma_quotation_view_detail(proforma_quotation_id);
           
        },
        error: function(xhr, status, error) {
            alert("Terjadi kesalahan: " + error);
            console.error("Error:", xhr.responseText);
        }
    });
}


function proforma_detail_edit(id) {
    App.createContainer('proforma_detail_edit_temp');
    bbox = bootbox.dialog({
        title: 'Edit Proforma Detail',
        message: $('#proforma_detail_edit_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('proforma_quotation/edit_detail/' + id, function (content) {
            $('#proforma_detail_edit_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

function proforma_detail_edit_from_product_price(id) {
    App.createContainer('proforma_detail_edit_temp');
    bbox = bootbox.dialog({
        title: 'Edit Proforma Detail',
        message: $('#proforma_detail_edit_temp'),
        closeButton: true,
    });
    bbox.init(function () {
        $.get('proforma_quotation/edit_detail_from_product_price/' + id, function (content) {
            $('#proforma_detail_edit_temp').empty().append(content);
        }).done(function () {
        }).fail(function (data) {
            bbox.modal("hide");
            Client.message.error({'data': data});
        });
    });
}

// function proforma_detail_delete(id, proforma_quotation_id) {
//     bootbox.confirm("Apakah Anda yakin ingin menghapus detail ini?", function(result) {
//         if (result) {
//             $.ajax({
//                 url: 'proforma_quotation/delete_detail/' + id,
//                 type: 'POST',
//                 dataType: 'json',
//                 success: function(response) {
//                     if (response.success) {
//                         // Refresh data detail setelah penghapusan berhasil
//                         proforma_quotation_view_detail(proforma_quotation_id);
//                         bootbox.alert("Detail berhasil dihapus");
//                     } else {
//                         bootbox.alert("Gagal menghapus detail: " + response.msg);
//                     }
//                 },
//                 error: function() {
//                     bootbox.alert("Terjadi kesalahan saat menghapus data");
//                 }
//             });
//         }
//     });
// }

function proforma_detail_delete(id, proforma_quotation_id) {
    if (confirm('Are you sure you want to delete this detail?')) {
        $.ajax({
            url: 'proforma_quotation/delete_detail/' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Refresh detail data after successful deletion
                    proforma_quotation_view_detail(proforma_quotation_id);
                    alert("Detail successfully deleted");
                } else {
                    alert("Failed to delete detail: " + response.msg);
                }
            },
            error: function() {
                alert("An error occurred while deleting the data");
            }
        });
    }
}


function update_proforma_detail() {
    var id = $('#detail_id').val();
    var proforma_quotation_id = $('#proforma_quation_id').val();
    var model_id = $('#modelid0').val();
    var customer_code = $('#custcode').val();
    var product_price_id = $('#productpriceid0').val();
    var quotation_detail_id = $('#quotation_detail_id').val();
    var fob_quotation = $('#quotation_detail_fob').val();
    var fob_product_price = $('#productpricecode0').val();
    var fob_costing = $('#fob_costing').val();
    var remark = $('#remark').val();
    var type = "Not From Product Price";

    
    var data = {
        id: id,
        proforma_quotation_id: proforma_quotation_id,
        model_id: model_id,
        customer_code: customer_code,
        ebako_code: $('#modelcode0').val(),
        product_price_id: product_price_id,
        quotation_detail_id: quotation_detail_id,
        fob_quotation: fob_quotation,
        fob_product_price: fob_product_price,
        fob_costing: fob_costing,
        remark: remark,
        type : type
    };
    
    $.ajax({
        url: 'proforma_quotation/update_detail',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            if (response.success) {
                bootbox.hideAll();
                proforma_quotation_view_detail(proforma_quotation_id);
                bootbox.alert("Detail berhasil diperbarui");
            } else {
                bootbox.alert("Gagal memperbarui detail: " + response.msg);
            }
        },
        error: function() {
            bootbox.alert("Terjadi kesalahan saat memperbarui data");
        }
    });
}

function update_proforma_detail_from_product_price() {
    var id = $('#detail_id').val();
    var proforma_quotation_id = $('#proforma_quation_id').val() || 0;
    var ebako_code = 0;
    var model_id = 0;
    var customer_code = $('#cust_code').val() || '';
    var product_price_id = $('#productpriceid0').val() || 0;
    var quotation_detail_id =  0;
    var fob_quotation =  0;
    var fob_product_price = $('#productpricecode0').val() || 0;
    var fob_costing = 0;
    var remark = $('#remark').val() || '';
    var type = "From Product Price";

    
    var data = {
        id: id,
        proforma_quotation_id: proforma_quotation_id,
        model_id: model_id,
        customer_code: customer_code,
        ebako_code: ebako_code,
        product_price_id: product_price_id,
        quotation_detail_id: quotation_detail_id,
        fob_quotation: fob_quotation,
        fob_product_price: fob_product_price,
        fob_costing: fob_costing,
        remark: remark,
        type : type
    };
    
    $.ajax({
        url: 'proforma_quotation/update_detail',
        type: 'POST',
        dataType: 'json',
        data: JSON.stringify(data),
        contentType: 'application/json',
        success: function(response) {
            if (response.success) {
                bootbox.hideAll();
                proforma_quotation_view_detail(proforma_quotation_id);
                bootbox.alert("Detail berhasil diperbarui");
            } else {
                bootbox.alert("Gagal memperbarui detail: " + response.msg);
            }
        },
        error: function() {
            bootbox.alert("Terjadi kesalahan saat memperbarui data");
        }
    });
}


function print_proforma_detail(id) {
    var printWindow = window.open('proforma_quotation/print_detail/' + id, '_blank');
    
    if (printWindow) {
        printWindow.focus();
    } else {
        alert('');
    }
}
