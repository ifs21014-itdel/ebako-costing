
function show_parameter_base_on_ratevalue() {
    $(".group__profit_range").hide();
    $(".group__rate_range").show();
}

function show_parameter_base_on_profit() {
    $(".group__rate_range").hide();
    $(".group__profit_range").show();
}

function costing_pricelist_search(offset) {
    var price_list_base_on = $("input[name='price_list_base_on']:checked").val();

    var start_ratevalue = $('#pricelist__start_ratevalue').val();
    var end_ratevalue = $('#pricelist__end_ratevalue').val();
    var range_ratevalue = $('#pricelist__range_ratevalue').val();
    var profit_percentage = $('#pricelist__profit_percentage').val();

    var start_profit = $('#pricelist__start_profit').val();
    var end_profit = $('#pricelist__end_profit').val();
    var range_profit = $('#pricelist__range_profit').val();
    var ratevalue = $('#pricelist__ratevalue').val();

    var port_origin_cost = $('#pricelist__port_origin_cost').val();
    var fixed_cost = $('#pricelist__fixed_cost').val();
    var variable_cost = $('#pricelist__variable_cost').val();
    var port_origin_cost = $('#pricelist__port_origin_cost').val();
    var picklist_mark_up = $('#pricelist__picklist_mark_up').val();
    var picklist_ratevalue = $('#pricelist__picklist_ratevalue').val();
    var insurance_percentage = $('#insurance_percentage_id').val();

    var target_price = $('#pricelist__target_price').val();

    var model_codes = $('#model_codes').val();
    var code = $('#code_search').val();
    var custcode = $('#custcode_search').val();
    var customerid = $('#customerid_search').val();
    var datefrom = $('#datefrom').val();
    var dateto = $('#dateto').val();
    var is_over_due = $("#is_over_due:checked").val();

    $("#datacosting_pricelist").html("<center><img style='padding-top:50px;' src='" + url + "images/loading1.gif'/></center>");
    $.post(url + 'costing_pricelist/search_pricelist/' + offset, {
        price_list_base_on: price_list_base_on,

        start_ratevalue: start_ratevalue,
        end_ratevalue: end_ratevalue,
        range_ratevalue: range_ratevalue,
        profit_percentage: profit_percentage,

        start_profit: start_profit,
        end_profit: end_profit,
        range_profit: range_profit,
        ratevalue: ratevalue,

        port_origin_cost: port_origin_cost,
        fixed_cost: fixed_cost,
        variable_cost: variable_cost,
        port_origin_cost: port_origin_cost,
        picklist_mark_up: picklist_mark_up,
        picklist_ratevalue: picklist_ratevalue,

        target_price: target_price,

        code: code,
        model_codes: model_codes,
        custcode: custcode,
        customerid: customerid,
        datefrom: datefrom,
        dateto: dateto,
        insurance_percentage: insurance_percentage,
        is_over_due: is_over_due,
    }, function (content) {
        $('#datacosting_pricelist').empty();
        $('#datacosting_pricelist').append(content);

        $('html, body').animate({
            scrollTop: $("#datacosting_pricelist").offset().top
        }, 1000);

    });
}

function costing_pricelist_search_then_print_summary(offset, type) {
    //alert('test');
    var price_list_base_on = $("input[name='price_list_base_on']:checked").val();

    var start_ratevalue = $('#pricelist__start_ratevalue').val();
    var end_ratevalue = $('#pricelist__end_ratevalue').val();
    var range_ratevalue = $('#pricelist__range_ratevalue').val();
    var profit_percentage = $('#pricelist__profit_percentage').val();

    var start_profit = $('#pricelist__start_profit').val();
    var end_profit = $('#pricelist__end_profit').val();
    var range_profit = $('#pricelist__range_profit').val();
    var ratevalue = $('#pricelist__ratevalue').val();

    var port_origin_cost = $('#pricelist__port_origin_cost').val();
    var fixed_cost = $('#pricelist__fixed_cost').val();
    var variable_cost = $('#pricelist__variable_cost').val();
    var port_origin_cost = $('#pricelist__port_origin_cost').val();
    var picklist_mark_up = $('#pricelist__picklist_mark_up').val();
    var picklist_ratevalue = $('#pricelist__picklist_ratevalue').val();
    var parent_sales_quotes_id2 = $('#parent_sales_quotes_id2').val();
    var insurance_percentage = $('#insurance_percentage_id').val();

    var target_price = $('#pricelist__target_price').val();

    var model_codes = $('#model_codes').val();
    var code = $('#code_search').val();
    var custcode = $('#custcode_search').val();
    var customerid = $('#customerid_search').val();
    var datefrom = $('#datefrom').val();
    var dateto = $('#dateto').val();
    var is_over_due = $("#is_over_due:checked").val();

    var full_url = url + 'costing_pricelist/search_pricelist_then_print_summary/' + offset + "?"
            + "price_list_base_on=" + price_list_base_on

            + "&start_ratevalue=" + start_ratevalue
            + "&end_ratevalue=" + end_ratevalue
            + "&range_ratevalue=" + range_ratevalue
            + "&profit_percentage=" + profit_percentage

            + "&start_profit=" + start_profit
            + "&end_profit=" + end_profit
            + "&range_profit=" + range_profit
            + "&ratevalue=" + ratevalue

            + "&port_origin_cost=" + port_origin_cost
            + "&fixed_cost=" + fixed_cost
            + "&variable_cost=" + variable_cost
            + "&port_origin_cost=" + port_origin_cost
            + "&picklist_mark_up=" + picklist_mark_up
            + "&picklist_ratevalue=" + picklist_ratevalue
            + "&target_price=" + target_price

            + "&code=" + code
            + "&custcode=" + custcode
            + "&customerid=" + customerid
            + "&datefrom=" + datefrom
            + "&dateto=" + dateto
            + "&is_over_due=" + is_over_due
            + "&model_codes=" + encodeURIComponent(JSON.stringify(model_codes))
            + "&type=" + type
            + "&insurance=" + insurance_percentage
            + "&parentid=" + parent_sales_quotes_id2;



    var win = window.open(full_url, '_blank');
    win.focus();

}

function set_as_fixed_cost_sheet(costingid, ratevalue, profit_percentage, fixed_cost, variable_cost, port_origin_cost, picklist_mark_up, picklist_ratevalue, fob_price,target_price,quantity,rate,price_rate,modelid,last_costing_price,customerid,insurance,date,type) {
    create_price_list(costingid,target_price,quantity,rate,price_rate,modelid,last_costing_price,customerid,profit_percentage,fixed_cost,variable_cost,picklist_mark_up,port_origin_cost,picklist_ratevalue,insurance,date,type);
    $.post(url + 'costing_pricelist/set_as_fixed_cost_sheet/', {
        costingid: costingid,
        ratevalue: ratevalue,
        profit_percentage: profit_percentage,
        fixed_cost: fixed_cost,
        variable_cost: variable_cost,
        port_origin_cost: port_origin_cost,
        picklist_mark_up: picklist_mark_up,
        picklist_ratevalue: picklist_ratevalue,
        fob_price: fob_price,
    }).done(function (content) {
        var result = eval('(' + content + ')');
        if (result.success) {
            Client.message.success("Price Successfully Set As Fixed Cost Sheet ...");
             
            $(".td_" + costingid).css('background-color', '#fff');
            $("#td_" + costingid + "_rate_" + ratevalue + "_profit_" + profit_percentage).css('background-color', '#fff6a5');
        } else {
            $("input[name='selected_price_" + costingid + "']").prop('checked', false);
            $(".td_" + costingid).css('background-color', '#fff');
            Client.message.error({'message': result.msg});
        }
    }).fail(function (data) {
        $("input[name='selected_price_" + costingid + "']").prop('checked', false);
        $(".td_" + costingid).css('background-color', '#fff');
        Client.message.error({'message': data.msg});
    });
    return false;
}


function create_price_list(costing_id,target_price, quantity, rate, price_rate, model_id, last_costing_price, customer_id,profit_percentage,fixed_cost,variable_cost,picklist_markup,port_origin_cost,picklist_rate,insurance,price_list_date,type) {
    var price_list_id = $("#existing_price_list").val();
    console.log("=== DATA YANG DIKIRIM ===");
    console.table({
        price_list_id,
        customer_id,
        costing_id,
        model_id,
        quantity,
        last_costing_price,
        target_price,
        rate,
        price_rate,
        profit_percentage,
        fixed_cost,
        variable_cost,
        picklist_markup,
        port_origin_cost,
        picklist_rate,
        insurance,
        type
    });
    $.post(url + 'costing_pricelist/create_price_list/', {
        price_list_id : price_list_id,
        customer_id : customer_id,
        costing_id : costing_id,
        model_id: model_id,
        quantity: quantity,
        last_costing_price: last_costing_price,
        target_price: target_price,
        rate: rate,
        price_rate: price_rate,
        profit_percentage : profit_percentage,
        fixed_cost : fixed_cost,
        variable_cost:variable_cost,
        picklist_markup : picklist_markup,
        port_origin_cost : port_origin_cost,
        picklist_rate : picklist_rate,
        insurance : insurance,
        type : type
    }).done(function(content) {
        if (content.success) {
            Client.message.success("Price list has been created ...");
        } else {
            Client.message.error({ 'message': content.msg });
        }
    }).fail(function(data) {
        Client.message.error({ 'message': data.msg });
    });

    return false;
}
