<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class costing_pricelist extends CI_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->session->userdata('id')) {
            redirect("/home");
        }
        $this->load->model('model_costing');
        $this->load->model('model_customer');
        $this->load->model('model_user');
    }

    function view_pricelist() {
        //$data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "costing"));
        $data['customer'] = $this->model_customer->selectAll();
        $data["list_model"] = $this->model_costing->selectAllApprovedModel();

        $this->load->view('costing_pricelist/view', $data);
    }

    function search_pricelist($offset = 0) {
        //$data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "costing"));
        //price list parameter    	
        $price_list_base_on = $this->input->post('price_list_base_on');

        $start_ratevalue = (double) $this->input->post('start_ratevalue');
        $end_ratevalue = (double) $this->input->post('end_ratevalue');
        $range_ratevalue = (double) $this->input->post('range_ratevalue');
        $profit_percentage = (double) $this->input->post('profit_percentage');

        $start_profit = (double) $this->input->post('start_profit');
        $end_profit = (double) $this->input->post('end_profit');
        $range_profit = (double) $this->input->post('range_profit');
        $ratevalue = (double) $this->input->post('ratevalue');

        $fixed_cost = (double) $this->input->post('fixed_cost');
        $variable_cost = (double) $this->input->post('variable_cost');
        $port_origin_cost = (double) $this->input->post('port_origin_cost');
        $picklist_mark_up = (double) $this->input->post('picklist_mark_up');
        $picklist_ratevalue = (double) $this->input->post('picklist_ratevalue');

        $target_price = (double) $this->input->post('target_price');

        //filter data parameter

        $model_codes = $this->input->post('model_codes');
        $code = $this->input->post('code');
        $custcode = $this->input->post('custcode');
        $customerid = $this->input->post('customerid');
        $list_sales_quotes = "";
        echo $customerid;
        if ($customerid <> "") {
            $list_sales_quotes = $this->model_costing->select_quotation_by_customerid($customerid);
        }

        $data['sales_quotes'] = $list_sales_quotes;
        $datefrom = $this->input->post('datefrom');
        $dateto = $this->input->post('dateto');
        $is_over_due = $this->input->post('is_over_due');

        $limit = $this->config->item('limit');

        $data['num_rows'] = $this->model_costing->getNumRows_pricelist($model_codes, $code, $custcode, $customerid, $datefrom, $dateto, $is_over_due);
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['offset'] = $offset + 1;
        $data['first'] = 0;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;

        $costingcategories = $this->model_costing->selectCostingCategoryDirectMaterial();
        $costingcategories_notdirect = $this->model_costing->selectCostingCategoryNotDirectMaterial();

        $list_costing = $this->model_costing->search_for_pricelist($model_codes, $code, $custcode, $customerid, $datefrom, $dateto, $is_over_due, $limit, $offset);
        $costing_details = [];

        $ranges = [];
        $start_range = 0;
        $end_range = 0;
        $range = 0;

        if ($price_list_base_on == "rate") {
            $start_range = $start_ratevalue;
            $end_range = $end_ratevalue;
            $range = $range_ratevalue;
        } else {
            $start_range = $start_profit;
            $end_range = $end_profit;
            $range = $range_profit;
        }

        while ($start_range <= $end_range) {
            $ranges [] = $start_range;

            if ($price_list_base_on == "rate") {
                $ratevalue_tmp = $start_range;
                $profit_percentage_tmp = $profit_percentage;
            } else {
                $ratevalue_tmp = $ratevalue;
                $profit_percentage_tmp = $start_range;
            }

            foreach ($list_costing as $costing) {
                $costing_details[$costing->id][$start_range] = ceil($this->getFOB_price($costing, $costingcategories, $costingcategories_notdirect, $ratevalue_tmp, $profit_percentage_tmp, $port_origin_cost, $fixed_cost, $variable_cost, $port_origin_cost, $picklist_mark_up, $picklist_ratevalue));
            }
            $start_range += $range;
        }

        $data['ranges'] = $ranges;
        $data['costing'] = $list_costing;
        $data['costing_details'] = $costing_details;

        $data['target_price'] = $target_price;
        $data['price_list_base_on'] = $price_list_base_on;

        $this->load->view('costing_pricelist/search', $data);
    }

    function search_pricelist_then_print_summary($offset) {
        //$data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "costing"));

        $this->load->library("pdf");
        // $this->load->library("mytcpdf");
        //price list parameter    	
        $price_list_base_on = $this->input->get('price_list_base_on');

        $start_ratevalue = (double) $this->input->get('start_ratevalue');
        $end_ratevalue = (double) $this->input->get('end_ratevalue');
        $range_ratevalue = (double) $this->input->get('range_ratevalue');
        $profit_percentage = (double) $this->input->get('profit_percentage');
        $prev_date = $this->input->get('prev_quo_date');
        $start_profit = (double) $this->input->get('start_profit');
        $end_profit = (double) $this->input->get('end_profit');
        $range_profit = (double) $this->input->get('range_profit');
        $ratevalue = (double) $this->input->get('ratevalue');

        $fixed_cost = (double) $this->input->get('fixed_cost');
        $variable_cost = (double) $this->input->get('variable_cost');
        $port_origin_cost = (double) $this->input->get('port_origin_cost');
        $picklist_mark_up = (double) $this->input->get('picklist_mark_up');
        $picklist_ratevalue = (double) $this->input->get('picklist_ratevalue');
        $parentid = (double) $this->input->get('parentid');

        $is_over_due = $this->input->get('is_over_due');

        $target_price = (double) $this->input->get('target_price');
        //filter data parameter

        $model_codes = $this->input->get('model_codes');
        if (!empty($model_codes)) {
            $model_codes = json_decode($model_codes);
        }

        $code = $this->input->get('code');
        $custcode = $this->input->get('custcode');
        $customerid = $this->input->get('customerid');
        $datefrom = $this->input->get('datefrom');
        $dateto = $this->input->get('dateto');

        $data['price_list_base_on'] = $price_list_base_on;
        // Di controller, tambahkan ini saat mengambil data
        $data['prev_quo_date'] = $prev_date;
        $data['start_ratevalue'] = $start_ratevalue;
        $data['end_ratevalue'] = $end_ratevalue;
        $data['range_ratevalue'] = $range_ratevalue;
        $data['profit_percentage'] = $profit_percentage;

        $data['start_profit'] = $start_profit;
        $data['end_profit'] = $end_profit;
        $data['range_profit'] = $range_profit;
        $data['ratevalue'] = $ratevalue;

        $data['fixed_cost'] = $fixed_cost;
        $data['variable_cost'] = $variable_cost;
        $data['port_origin_cost'] = $port_origin_cost;
        $data['picklist_mark_up'] = $picklist_mark_up;
        $data['picklist_ratevalue'] = $picklist_ratevalue;

        $data['code'] = $code;
        $data['custcode'] = $custcode;
        $data['customerid'] = $customerid;
        $data['datacust'] = $this->model_customer->selectById($customerid);
        $data['datefrom'] = $datefrom;
        $data['dateto'] = $dateto;

        $costingcategories = $this->model_costing->selectCostingCategoryDirectMaterial();
        $costingcategories_notdirect = $this->model_costing->selectCostingCategoryNotDirectMaterial();

        $list_costing = $this->model_costing->search_and_get_all_for_pricelist($model_codes, $code, $custcode, $customerid, $datefrom, $dateto, $is_over_due);
        //$list_sales_quotes_item = $this->model_costing->select_quotation_by_customerid($customerid);

        $list_sales_quotes_item = $this->model_costing->select_allitem_by_quotationid($parentid);
        $costing_details = [];

        $ranges = [];
        $start_range = 0;
        $end_range = 0;
        $range = 0;

        if ($price_list_base_on == "rate") {
            $start_range = $start_ratevalue;
            $end_range = $end_ratevalue;
            $range = $range_ratevalue;
        } else {
            $start_range = $start_profit;
            $end_range = $end_profit;
            $range = $range_profit;
        }

        while ($start_range <= $end_range) {
            $ranges [] = $start_range;

            if ($price_list_base_on == "rate") {
                $ratevalue_tmp = $start_range;
                $profit_percentage_tmp = $profit_percentage;
            } else {
                $ratevalue_tmp = $ratevalue;
                $profit_percentage_tmp = $start_range;
            }


            foreach ($list_costing as $costing) {
                $costing_details[$costing->id][$start_range] = ceil($this->getFOB_price($costing, $costingcategories, $costingcategories_notdirect, $ratevalue_tmp, $profit_percentage_tmp, $port_origin_cost, $fixed_cost, $variable_cost, $port_origin_cost, $picklist_mark_up, $picklist_ratevalue));
            }
            $start_range += $range;
        }

        $data['ranges'] = $ranges;
        $data['costing'] = $list_costing;
        $data['costing_details'] = $costing_details;
        $data['sales_quotes_item'] = $list_sales_quotes_item;

        $data['target_price'] = $target_price;
        $data['price_list_base_on'] = $price_list_base_on;
        $data['quonumber'] = $this->model_costing->createquonumber($parentid);



        //$this->load->view('costing_pricelist/print_costing_pricelist', $data);
        //var_dump($data);
        $html = $this->load->view('costing_pricelist/print_costing_pricelist', $data);
        // echo $html;
        // $this->pdf->pdf_create($data, "file", "", "P", "legal");
    }

    function print_preview_cost_sheet() {
        //price list parameter
        $id = $this->input->get('id');
        $data['ratevalue'] = (double) $this->input->get('ratevalue');
        $data['profit_percentage'] = (double) $this->input->get('profit_percentage');
        $data['port_origin_cost'] = (double) $this->input->get('port_origin_cost');
        $data['fixed_cost'] = (double) $this->input->get('fixed_cost');
        $data['variable_cost'] = (double) $this->input->get('variable_cost');
        $data['port_origin_cost'] = (double) $this->input->get('port_origin_cost');
        $data['picklist_mark_up'] = (double) $this->input->get('picklist_mark_up');
        $data['picklist_ratevalue'] = (double) $this->input->get('picklist_ratevalue');

        $data['id'] = $id;
        $data['costing'] = $this->model_costing->selectById($id);
        $data['costingcategory'] = $this->model_costing->selectCostingCategoryDirectMaterial();
        $data['costingcategorynotdirect'] = $this->model_costing->selectCostingCategoryNotDirectMaterial();
        //$html = $this->load->view('po/print', $data, TRUE);
        //$this->pdf->pdf_create($html, "file");

        $this->load->view('costing_pricelist/print_preview_cost_sheet', $data);
    }

    function set_as_fixed_cost_sheet() {
        $costingid = (double) $this->input->post('costingid');
        $arr_data = [
            "ratevalue" => (double) $this->input->post('ratevalue'),
            "profit_percentage" => (double) $this->input->post('profit_percentage'),
            "fixed_cost" => (double) $this->input->post('fixed_cost'),
            "variable_cost" => (double) $this->input->post('variable_cost'),
            "port_origin_cost" => (double) $this->input->post('port_origin_cost'),
            "variable_mark_up_cat_8" => (double) $this->input->post('picklist_mark_up'),
            "picklist_ratevalue" => (double) $this->input->post('picklist_ratevalue'),
            "fob_price" => (double) $this->input->post('fob_price'),
            "updated_price" => "TRUE",
            "date" => date('Y-m-d'),
        ];

        if ($this->model_costing->update($arr_data, array("id" => $costingid))) {
            echo json_encode(array('success' => true));
        } else {
            echo json_encode(array('msg' => $this->db->_error_message()));
        }
    }

    function getFOB_price(
    $costing, $costingcategories, $costingcategories_notdirect, $rate, $profit_percentage, $port_origin_cost, $fixed_cost, $variable_cost, $port_origin_cost, $picklist_mark_up, $picklist_ratevalue
    ) {

        $costingid = $costing->id;

        if (empty($profit_percentage)) {
            $profit_percentage = @$costing->profit_percentage;
        }
        if (empty($port_origin_cost)) {
            $port_origin_cost = @$costing->port_origin_cost;
        }
        if (empty($fixed_cost)) {
            $fixed_cost = @$costing->fixed_cost;
        }
        if (empty($variable_cost)) {
            $variable_cost = @$costing->variable_cost;
        }
        if (empty($port_origin_cost)) {
            $port_origin_cost = @$costing->port_origin_cost;
        }
        if (empty($picklist_mark_up)) {
            $picklist_mark_up = @$costing->variable_mark_up_cat_8;
        }


        $directmaterialtotal = 0;
        $subtotal = 0;
        foreach ($costingcategories as $costingcategory) {
            // render costing
            $costingdetail = $this->model_costing->selectCostingByHeaderidAndCategoryId($costingid, $costingcategory->id);

            $subtotal = 0;
            $total_in_usd = 0;
            foreach ($costingdetail as $result) {
                if (@$result->qty <= 0 || @$result->qty == '')
                    continue;

                $req_qty = $result->req_qty;
                if ((empty($result->yield) || $result->yield <= 0)) {

                    if ($result->allowance < 0) {
                        $req_qty = 0;
                    }
                }

                $unitpricerp = number_format($result->unitpricerp, 3, '.', ',');
                if ($result->unitpriceusd != 0) {
                    $unitpricerp = number_format(($result->unitpriceusd * $rate), 3, '.', '');
                }

                $unitpriceusd = number_format(($result->unitpricerp / $rate), 3, '.', '');
                if ($result->unitpriceusd != 0) {
                    $unitpriceusd = $result->unitpriceusd;
                }

                $total_in_usd = number_format(($unitpriceusd * $req_qty), 3, '.', ',');

                $subtotal = $subtotal + $total_in_usd;
            }
            $directmaterialtotal += $subtotal;
        }

        /**
         *  Costing not direct material
         */
        $sum_not_direct = array();

        $rate_tmp = $rate;

        foreach ($costingcategories_notdirect as $costingcategory) {
            $costingdetail = $this->model_costing->selectCostingByHeaderidAndCategoryId($costingid, $costingcategory->id);
            $subtotal = 0;
            $total_in_usd = 0;

            if ($costingcategory->id == 8) {
                $rate_tmp = $picklist_ratevalue;
            } else {
                $rate_tmp = $rate;
            }

            foreach ($costingdetail as $result) {

                if (@$result->qty <= 0 || @$result->qty == '')
                    continue;

                $req_qty = $result->req_qty;

                if ((empty($result->yield) || $result->yield <= 0)) {

                    if ($result->allowance < 0) {
                        $req_qty = 0;
                    }
                }

                $unitpricerp = number_format($result->unitpricerp, 3, '.', ',');
                if ($result->unitpriceusd != 0) {
                    $unitpricerp = number_format(($result->unitpriceusd * $rate_tmp), 3, '.', '');
                }

                $unitpriceusd = number_format(($result->unitpricerp / $rate_tmp), 3, '.', '');
                if ($result->unitpriceusd != 0) {
                    $unitpriceusd = $result->unitpriceusd;
                }
                $total_in_usd = number_format(($unitpriceusd * $req_qty), 3, '.', ',');
                $subtotal = $subtotal + $total_in_usd;
            }
            $sum_not_direct [$costingcategory->id] = $subtotal;
        }
    //    echo "noname=round((100-('".$fixed_cost."+".$variable_cost."+".$profit_percentage."))/100)<br>";
        $noname = round((100 - ($fixed_cost + $variable_cost + $profit_percentage)) / 100, 3);
       // echo "factorycost=round((100-('".$directmaterialtotal."+".$sum_not_direct[9]."/".$noname.")))<br>";
        $factory_cost_and_profit = round((($directmaterialtotal + $sum_not_direct [9]) / $noname), 3);

        if (!empty($picklist_mark_up)) {
            $sum_not_direct [8] = round(($sum_not_direct [8] * $picklist_mark_up), 3);
        }
        $port_origin_cost = round(($factory_cost_and_profit * $port_origin_cost) / 100, 3);
     //   echo "port origin=round((100-('".$factory_cost_and_profit."*".$port_origin_cost.")))<br>";
        $subtotal_ = round($sum_not_direct [8] + $sum_not_direct [10] + $port_origin_cost, 3);
     //   echo "subtotal=round((100-('".$sum_not_direct [8]."+".$sum_not_direct [10]."+".$port_origin_cost.")))<br>";
        $fob_price = round($subtotal_ + $factory_cost_and_profit, 3);
     //   echo "fob=round((100-('".$subtotal_."+".$factory_cost_and_profit.")))<br>";

        return $fob_price;
    }

    function create_quotation() {
        //price list parameter
        $id = $this->input->get('id');
        $jenis = $this->input->get('jenis');
//        $this->load->library("pdf");
        $this->load->library("mytcpdf"); //-- untuk tcpdf
        $this->load->library("pdf"); // untuk dom pdf 

        $parent_sales_quotes_id = $this->input->get('parent_sales_quotes');
        if ($jenis == 'create') {
            $quotation_id = $this->model_costing->create_quotation($id);
            $data['quotation'] = $this->model_costing->select_quotation_byid($quotation_id);
            $data['quo_item'] = $this->model_costing->select_allitem_by_quotationid($quotation_id);

            $html = $this->load->view('costing_pricelist/print_quotation', $data, TRUE);
        } else {
            //  echo $id;
            $id = explode(",", $id);

            // echo count($id);
            $data["costing"] = $id;
            $html = $this->load->view('costing_pricelist/preview_quotation', $data, TRUE);
            //$html = 'test';
        }
        echo $html;
    }
    public function print_quotation() {
        $quotation_id = $this->input->get('id');
        $print_type = $this->input->get('print_type'); // Ambil parameter print_type
        
        $data['quotation'] = $this->model_costing->select_quotation_byid($quotation_id);
        $data['quo_item'] = $this->model_costing->select_allitem_by_quotationid($quotation_id);
        $data['print_type'] = $print_type; // Teruskan ke view
        
        // Periksa apakah quotation memiliki parent_id
        $has_parent = false;
        if (!empty($data['quotation'][0]->parent_id)) {
            $has_parent = true;
        }
        
        // Tandai item pertama untuk keperluan tampilan (flagging the first item)
        if (!empty($data['quo_item'])) {
            $first_item = true;
            foreach ($data['quo_item'] as &$item) {
                $item->is_first_item = $first_item;
                // Jika tidak memiliki parent, semua item akan ditampilkan lengkap
                $item->show_full = !$has_parent || $item->sort_order === '0' || $first_item;
                if ($first_item) {
                    $first_item = false;
                }
            }
        }
        
        $html = $this->load->view('costing_pricelist/print_quotation', $data, TRUE);
        echo $html;
    }

    public function create_price_list() {
        $clean_price_rate = str_replace(',', '', $this->input->post('price_rate'));
    
        $data = array(
            'model_id'             => $this->input->post('model_id'),
            'customer_id'          => $this->input->post('customer_id'),
            'quantity'             => $this->input->post('quantity'),
            'last_costing_price'   => $this->input->post('last_costing_price'),
            'target_price'         => $this->input->post('target_price'),
            'rate'                 => $this->input->post('rate'),
            'price_rate'           => $clean_price_rate,
            'profit_percentage'    => $this->input->post('profit_percentage'),
            'fixed_cost'           => $this->input->post('fixed_cost'),
            'variable_cost'        => $this->input->post('variable_cost'),
            'picklist_markup'      => $this->input->post('picklist_markup'),
            'port_origin_cost'     => $this->input->post('port_origin_cost'),
            'picklist_rate'        => $this->input->post('picklist_rate'),
            'insurance'            => $this->input->post('insurance'),
            'costing_id'           => $this->input->post('costing_id'),
            'price_list_id'        => $this->input->post('price_list_id'),
            'type'                 => $this->input->post('type'),
            'status'               => "Draft"
        );
        
        error_log('Data price_list yang akan disimpan: ' . json_encode($data));
        
        // Validasi data sebelum memanggil model
        foreach (['model_id', 'customer_id', 'costing_id', 'price_list_id', 'quantity'] as $required) {
            if (empty($data[$required])) {
                error_log('ERROR: Field ' . $required . ' kosong atau tidak valid');
                echo json_encode(['success' => false, 'msg' => 'Field ' . $required . ' tidak boleh kosong']);
                return;
            }
        }
        
        $costing_id = $data['costing_id'];
        $fob_price = $this->model_costing->get_fob_price_by_costingid($costing_id);
        
        $data['last_quotation_price'] = $fob_price;
        $data['created_by'] = $this->session->userdata('id');
        
        // Cek apakah data sudah ada di database
        $exists = $this->model_costing->check_price_list_exists($data['model_id'], $data['customer_id']);
        
        // Hanya set updated_by jika melakukan update
        if ($exists) {
            $data['updated_by'] = $this->session->userdata('id');
        }
        
        $insert = $this->model_costing->create_price_list($data);
        
        if ($insert) {
            echo json_encode(['success' => true]);
        } else {
            // Tidak menggunakan $this->db->error() karena tidak tersedia
            echo json_encode([
                'success' => false, 
                'msg' => 'Gagal menyimpan data. Silakan periksa log untuk detail error.'
            ]);
        }
    }
    
    
    

}
