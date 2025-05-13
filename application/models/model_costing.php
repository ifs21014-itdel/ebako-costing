<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_costing
 *
 * @author hp
 */
class model_costing extends CI_Model {

    public function __construct() {
        parent::__construct();
        $nomor_quotation = "";
    }

    function getRomawi($bln) {
        switch ($bln) {
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }

    function selectAll() {
        $query = "select 
                costing.*,
                model.no code,
                model.custcode,
                model.description,
                model.filename,
                model.dd,
                model.dw,
                model.dht,
                customer.name customername
                from costing
                join model on costing.modelid=model.id
                join customer on costing.customerid=customer.id order by costing.id desc";
        return $this->db->query($query)->result();
    }



    public function searchCosting($code = "", $date_from = "", $date_to = "", $customer_id = 0) {
        if (!empty($customer_id) && $customer_id != 0) {
            $this->db->where('costing.customerid', $customer_id);
        }
        
        if (!empty($code)) {
            $this->db->join('model', 'model.id = costing.modelid', 'left');
            $this->db->like('model.no', $code);
        }
        
        if (!empty($date_from)) {
            $this->db->where('costing.date >=', $date_from);
        }
        
        if (!empty($date_to)) {
            $this->db->where('costing.date <=', $date_to);
        }
        
        $this->db->select('costing.*, model.no as modelno');
        $this->db->from('costing');
        if (empty($code)) {
            $this->db->join('model', 'model.id = costing.modelid', 'left');
        }
        $this->db->order_by('costing.date', 'DESC');
        
        return $this->db->get()->result();
    }
    
    function selectAllModel() {
        $query = "select
					model.no as modelcode,
					model.custcode,
					model.description,
					model.filename,
					customer.name customername
				from costing
				join model on costing.modelid=model.id
				join customer on costing.customerid=customer.id
				order by (case when costing.date is null then 0 else 1 end) desc, costing.date desc ";
        return $this->db->query($query)->result();
    }

    function selectAllApprovedModel() {
        $query = "select
					model.no as modelcode,
					model.custcode,
					model.description,
					model.filename,
					customer.name customername
				from costing
				join model on costing.modelid=model.id
				join customer on costing.customerid=customer.id where (costing.checkedstatus='1') 
				order by (case when costing.date is null then 0 else 1 end) desc, costing.date desc ";
        return $this->db->query($query)->result();
    }

    function getNumRows($code, $custcode, $customerid, $datefrom, $dateto, $is_over_due) {
        $query = "select count(1) as total
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id where true ";
        if ($code != '') {
            $query .= " and model.no ilike '%$code%'";
        }if ($custcode != '') {
            $query .= " and model.custcode ilike '%$custcode%'";
        }if ($customerid != '' && $customerid != 0) {
            $query .= " and costing.customerid=$customerid";
        }if ($datefrom != '' && $dateto == '') {
            $query .= " and costing.date='$datefrom'";
        }if ($datefrom != '' && $dateto != '') {
            $query .= " and costing.date between '$datefrom' and '$dateto'";
        }if ($datefrom == '' && $dateto != '') {
            $query .= " and costing.date='$dateto'";
        }

        if ($is_over_due == "true") {
            $query .= " and costing.date < now() - '1 years'::interval ";
        }
        if ($this->session->userdata('id') == 'C100' || $this->session->userdata('id') == 'C300') {
            $query .= " and costing.submit_to_check=true";
        }

        return $this->db->query($query)->row()->total;
    }

    function getNumRows_pricelist($model_codes, $code, $custcode, $customerid, $datefrom, $dateto, $is_over_due) {
        $query = "select count(1) as total
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id ";

        $where_query = "";
        $where_query_modelcodes = "";

        $codes = [];
        $code = trim($code);

        if (!empty($code)) {
            $codes = explode(',', $code);
        }

        if (count($codes) > 0) {
            $where_query .= " and ( ";
            $i = 1;
            foreach ($codes as $code) {
                $where_query .= "  model.no ilike '%" . trim($code) . "%'";
                if ($i < count($codes)) {
                    $where_query .= " or ";
                }
                $i += 1;
            }
            $where_query .= " ) ";
        }

        if ($custcode != '') {
            $where_query .= " and model.custcode ilike '%$custcode%'";
        }if ($customerid != '' && $customerid != 0) {
            $where_query .= " and costing.customerid=$customerid";
        }if ($datefrom != '' && $dateto == '') {
            $where_query .= " and costing.date='$datefrom'";
        }if ($datefrom != '' && $dateto != '') {
            $where_query .= " and costing.date between '$datefrom' and '$dateto'";
        }if ($datefrom == '' && $dateto != '') {
            $where_query .= " and costing.date='$dateto'";
        }

        if (is_array($model_codes) && count($model_codes) > 0) {
//extract where in
            $in_sql = "";
            $in_cointer = 1;
            $model_codes_length = count($model_codes);
            foreach ($model_codes as $model_code) {
                $in_sql .= "'" . $model_code . "'";
                if ($in_cointer < $model_codes_length) {
                    $in_sql .= " , ";
                }
                $in_cointer += 1;
            }
            $where_query_modelcodes = " model.no in (" . $in_sql . ") ";
        }

        if (empty($where_query)) {
            if (!empty($where_query_modelcodes)) {
                $query .= " where " . $where_query_modelcodes;
            }
        } else {
            if (!empty($where_query_modelcodes)) {
                $where_query = " where (true " . $where_query . ")";
                $query .= $where_query . " or " . $where_query_modelcodes;
            } else {
                $query .= " where true " . $where_query;
            }
        }

        if ($is_over_due == "true") {
            if (empty($where_query) && empty($where_query_modelcodes)) {
                $query .= " where costing.date < now() - '1 years'::interval ";
            } else {
                $query .= " and costing.date < now() - '1 years'::interval ";
            }
        }

        return $this->db->query($query)->row()->total;
    }

    function getCountOverDue() {
        $query = "select count(1) as total from costing where date < now() - '1 years'::interval";
        $data = $this->db->query($query)->row();

        return @$data->total;
    }

    function search($code, $custcode, $customerid, $datefrom, $dateto, $is_over_due, $limit, $offset) {
        $custdesc = $this->input->post('custdesc');
        $approvedstatus = $this->input->post('approvedstatus_id');
        $query = "select 
                costing.*,
                model.no code,
                model.custcode,
                model.description,
                model.filename,
        		model.is_temporary_photo,
        		model.finishoverview,
        		model.constructionoverview,
                model.dd,
                model.dw,
                model.dht,
        		
                model.nw,
                model.gw,
                
        		customer.name customername,
        		
        		(select name as checkedby_name from employee where employee.id=costing.checkedby), 
				(select name as approvedby_name from employee where employee.id=costing.approvedby)
        		
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id where true ";
        if ($code != '') {
            $query .= " and model.no ilike '%$code%'";
        }if ($custcode != '') {
            $query .= " and model.custcode ilike '%$custcode%'";
        }if ($customerid != '' && $customerid != 0) {
            $query .= " and costing.customerid=$customerid";
        }if ($datefrom != '' && $dateto == '') {
            $query .= " and costing.date='$datefrom'";
        }if ($datefrom != '' && $dateto != '') {
            $query .= " and costing.date between '$datefrom' and '$dateto'";
        }if ($datefrom == '' && $dateto != '') {
            $query .= " and costing.date='$dateto'";
        }if ($custdesc != "") {
            $query .= " and model.description ilike '%" . $custdesc . "%'";
        }

        if ($is_over_due == "true") {
            $query .= " and costing.date < now() - '1 years'::interval ";
        }
        if ($this->session->userdata('id') == 'C100' || $this->session->userdata('id') == 'C300') {
            $query .= " and costing.submit_to_check=true";
        }

        if ($approvedstatus != "All") {
            if ($approvedstatus == "") {
                $query .= " and (costing.approvedstatus is null or costing.approvedstatus='') ";
            } else
                $query .= " and costing.approvedstatus='$approvedstatus'";
        }
        $query .= " order by costing.id desc limit $limit offset $offset";
// echo $query;
        return $this->db->query($query)->result();
    }

    function search_and_get_all($code, $custcode, $customerid, $datefrom, $dateto, $is_over_due) {
        $query = "select
                costing.*,
                model.no code,
                model.custcode,
                model.description,
                model.filename,
    			model.is_temporary_photo,
        		model.finishoverview,
        		model.constructionoverview,
                model.dd,
                model.dw,
                model.dht,
    
                model.nw,
                model.gw,
    
        		customer.name customername
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id where true ";
        if ($code != '') {
            $query .= " and model.no ilike '%$code%'";
        }if ($custcode != '') {
            $query .= " and model.custcode ilike '%$custcode%'";
        }if ($customerid != '' && $customerid != 0) {
            $query .= " and costing.customerid=$customerid";
        }if ($datefrom != '' && $dateto == '') {
            $query .= " and costing.date='$datefrom'";
        }if ($datefrom != '' && $dateto != '') {
            $query .= " and costing.date between '$datefrom' and '$dateto'";
        }if ($datefrom == '' && $dateto != '') {
            $query .= " and costing.date='$dateto'";
        }

        if ($is_over_due == "true") {
            $query .= " and costing.date < now() - '1 years'::interval ";
        }

        $query .= " order by costing.id desc ";
        return $this->db->query($query)->result();
    }

    function search_for_pricelist($model_codes, $code, $custcode, $customerid, $datefrom, $dateto, $is_over_due, $limit, $offset) {
        $query = "select 
                costing.*,
                model.no code,
                model.custcode,
                model.description,
                model.filename,
        		model.is_temporary_photo,
        		model.finishoverview,
        		model.constructionoverview,
                model.dd,
                model.dw,
                model.dht,
        		
                model.nw,
                model.gw,
                
        		customer.name customername
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id  ";

        $where_query = "";
        $where_query_modelcodes = "";

        $codes = [];
        $code = trim($code);

        if (!empty($code)) {
            $codes = explode(',', $code);
        }

        if (count($codes) > 0) {
            $where_query .= " and ( ";
            $i = 1;
            foreach ($codes as $code) {
                $where_query .= "  model.no ilike '%" . trim($code) . "%'";
                if ($i < count($codes)) {
                    $where_query .= " or ";
                }
                $i += 1;
            }
            $where_query .= " ) ";
        }

        if ($custcode != '') {
            $where_query .= " and model.custcode ilike '%$custcode%'";
        }if ($customerid != '' && $customerid != 0) {
            $where_query .= " and costing.customerid=$customerid";
        }if ($datefrom != '' && $dateto == '') {
            $where_query .= " and costing.date='$datefrom'";
        }if ($datefrom != '' && $dateto != '') {
            $where_query .= " and costing.date between '$datefrom' and '$dateto'";
        }if ($datefrom == '' && $dateto != '') {
            $where_query .= " and costing.date='$dateto'";
        }

        if (is_array($model_codes) && count($model_codes) > 0) {
//extract where in
            $in_sql = "";
            $in_cointer = 1;
            $model_codes_length = count($model_codes);
            foreach ($model_codes as $model_code) {
                $in_sql .= "'" . $model_code . "'";
                if ($in_cointer < $model_codes_length) {
                    $in_sql .= " , ";
                }
                $in_cointer += 1;
            }
            $where_query_modelcodes = " model.no in (" . $in_sql . ") ";
        }

        if (empty($where_query)) {
            if (!empty($where_query_modelcodes)) {
                $query .= " where " . $where_query_modelcodes;
            }
        } else {
            if (!empty($where_query_modelcodes)) {
                $where_query = " where (true " . $where_query . ")";
                $query .= $where_query . " or " . $where_query_modelcodes;
            } else {
                $query .= " where true " . $where_query;
            }
        }

        if ($is_over_due == "true") {
            if (empty($where_query) && empty($where_query_modelcodes)) {
                $query .= " where costing.date < now() - '1 years'::interval ";
            } else {
                $query .= " and costing.date < now() - '1 years'::interval ";
            }
        }
        //var_dump($where_query);
        if (empty($where_query) && empty($where_query_modelcodes))
            $query .= " where costing.checkedstatus='1' ";
        else {
            $query .= " and costing.checkedstatus='1' ";
        }
        $query .= "  order by model.no desc limit $limit offset $offset";
 //echo $query;
        return $this->db->query($query)->result();
    }

    function search_and_get_all_for_pricelist($model_codes, $code, $custcode, $customerid, $datefrom, $dateto, $is_over_due) {
        $query = "select 
                costing.*,
                model.no code,
                model.custcode,
                model.description,
                model.filename,
        		model.is_temporary_photo,
        		model.finishoverview,
        		model.constructionoverview,
                model.dd,
                model.dw,
                model.dht,
        		
                model.nw,
                model.gw,
                
        		customer.name customername
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id";
        $where_query = "";
        $where_query_modelcodes = "";

        $codes = [];
        $code = trim($code);

        if (!empty($code)) {
            $codes = explode(',', $code);
        }

        if (count($codes) > 0) {
            $where_query .= " and ( ";
            $i = 1;
            foreach ($codes as $code) {
                $where_query .= "  model.no ilike '%" . trim($code) . "%'";
                if ($i < count($codes)) {
                    $where_query .= " or ";
                }
                $i += 1;
            }
            $where_query .= " ) ";
        }

        if ($custcode != '') {
            $where_query .= " and model.custcode ilike '%$custcode%'";
        }if ($customerid != '' && $customerid != 0) {
            $where_query .= " and costing.customerid=$customerid";
        }if ($datefrom != '' && $dateto == '') {
            $where_query .= " and costing.date='$datefrom'";
        }if ($datefrom != '' && $dateto != '') {
            $where_query .= " and costing.date between '$datefrom' and '$dateto'";
        }if ($datefrom == '' && $dateto != '') {
            $where_query .= " and costing.date='$dateto'";
        }

        if (is_array($model_codes) && count($model_codes) > 0) {
//extract where in
            $in_sql = "";
            $in_cointer = 1;
            $model_codes_length = count($model_codes);
            foreach ($model_codes as $model_code) {
                $in_sql .= "'" . $model_code . "'";
                if ($in_cointer < $model_codes_length) {
                    $in_sql .= " , ";
                }
                $in_cointer += 1;
            }
            $where_query_modelcodes = " model.no in (" . $in_sql . ") ";
        }

        if (empty($where_query)) {
            if (!empty($where_query_modelcodes)) {
                $query .= " where " . $where_query_modelcodes;
            }
        } else {
            if (!empty($where_query_modelcodes)) {
                $where_query = " where (true " . $where_query . ")";
                $query .= $where_query . " or " . $where_query_modelcodes;
            } else {
                $query .= " where true " . $where_query;
            }
        }

        if ($is_over_due == "true") {
            if (empty($where_query) && empty($where_query_modelcodes)) {
                $query .= " where costing.date < now() - '1 years'::interval ";
            } else {
                $query .= " and costing.date < now() - '1 years'::interval ";
            }
        }

        $query .= "  and (costing.checkedstatus='1') order by model.no asc ";
 //echo $query;
        return $this->db->query($query)->result();
    }

    function addfromrequestmodel($modelid, $customerid) {
        return $this->db->insert("costing", array("modelid" => $modelid, "customerid" => $customerid));
    }

    function updatefromrequest($id, $rateid, $ratevalue, $fixed_cost, $variable_cost, $profit_percentage, $port_origin_cost, $date) {
        $item_costing_desc = $this->input->post('item_costing_desc');
        return $this->db->update('costing', array(
                    "rateid" => $rateid,
                    "ratevalue" => $ratevalue,
                    "fixed_cost" => $fixed_cost,
                    "variable_cost" => $variable_cost,
                    "profit_percentage" => $profit_percentage,
                    "port_origin_cost" => $port_origin_cost,
                    "item_costing_desc" => $item_costing_desc,
                    "date" => $date
                        ), array("id" => $id));
    }

    function savenew($customerid, $modelid, $rateid, $ratevalue, $fixed_cost, $variable_cost, $profit_percentage, $port_origin_cost, $date, $preparedby = "", $checkedby = "", $approvedby = "",$created_by) {

        $item_costing_desc = $this->input->post('item_costing_desc');
        $q_wood = $this->input->post('q_wood');
        $q_veneer = $this->input->post('q_veneer');
        $q_fabric = $this->input->post('q_fabric');
        $q_leather = $this->input->post('q_leather');
        $q_other_remarks = $this->input->post('q_other_remarks');
        $q_shipping_conf = $this->input->post('q_shipping_conf');
        $q_packing = $this->input->post('q_packing');
        $q_qty_perbox = $this->input->post('q_qty_perbox');
        $q_box_dimension = $this->input->post('q_box_dimension');
        $q_upholstery_type = $this->input->post('q_upholstery_type');
        $q_cube = $this->input->post('q_cube');
        $q_finishes = $this->input->post('q_finishes');
        $lod_category = $this->input->post('lod_category');
        return $this->db->insert('costing', array(
                    "modelid" => $modelid,
                    "customerid" => $customerid,
                    "rateid" => $rateid,
                    "ratevalue" => $ratevalue,
                    //"picklist_rateid" => $rateid,
                    "picklist_ratevalue" => $ratevalue,
                    "fixed_cost" => $fixed_cost,
                    "variable_cost" => $variable_cost,
                    "profit_percentage" => $profit_percentage,
                    "port_origin_cost" => $port_origin_cost,
                    "item_costing_desc" => $item_costing_desc,
                    "q_wood" => $q_wood,
                    "q_veneer" => $q_veneer,
                    "q_fabric" => $q_fabric,
                    "q_leather" => $q_leather,
                    "q_other_remarks" => $q_other_remarks,
                    "q_upholstery_type" => $q_upholstery_type,
                    "q_shipping_conf" => $q_shipping_conf,
                    "q_packing" => $q_packing,
                    "q_qty_perbox" => $q_qty_perbox,
                    "q_finishes" => $q_finishes,
                    'lod_category' => $lod_category,
                    "date" => $date,
                    'preparedby' => $preparedby,
                    'checkedby' => $checkedby,
                    'approvedby' => $approvedby,
                    'created_by' => $created_by
        ));
    }

    function selectCostingByHeaderidAndCategoryId($costingheaderid, $category) {
        $query = "select * from costingdetail where costingid=$costingheaderid and categoryid=$category order by materialcode asc";
    //    echo $query;
//$query = "select * from costingdetail where costingid=$costingheaderid and categoryid=4 order by materialcode asc";
// var_dump($query);
//  echo $query."<hr>";
        return $this->db->query($query)->result();
    }

    function selectById($id) {
        $query = "select 
                costing.*,
                model.no code,
                model.custcode,
                model.description,
                model.description model_desc,
                model.filename,
                model.is_temporary_photo,
                model.dd,
                model.dw,
                model.dht,
                model.cd,
                model.cw,
                model.ch,
                customer.name customername,
                
                (select name as checkedby_name from employee where employee.id=costing.checkedby), 
				(select name as approvedby_name from employee where employee.id=costing.approvedby)
                
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id where costing.id=$id";
        //echo $query;
        return $this->db->query($query)->row();
    }

    function selectDetailById($id) {
        $query = "select * from costingdetail where id=$id";
        return $this->db->query($query)->row();
    }

    function costingdetail_log($id) {
        $query = "SELECT * FROM costingdetail_log WHERE costingid = ?";
        return $this->db->query($query, array($id))->result(); // Gunakan result() untuk mengambil semua data
    }
    

    function savedetail($costingid, $categoryid, $materialcode, $materialdescription, $uom, $qty, $yield, $allowance, $req_qty, $unitpricerp, $unitpriceusd,$created_by,$created_at) {
        return $this->db->insert('costingdetail', array(
                    "materialcode" => $materialcode,
                    "materialdescription" => $materialdescription,
                    "uom" => $uom,
                    "qty" => $qty,
                    "yield" => $yield,
                    "allowance" => $allowance,
                    "req_qty" => $req_qty,
                    "unitpricerp" => $unitpricerp,
                    "unitpriceusd" => $unitpriceusd,
                    "costingid" => $costingid,
                    "categoryid" => $categoryid,
                    "created_by" =>$created_by,
                    "created_at"=>$created_at
        ));
    }

    function savedetail_from_printout($objNewMaterial) {
        $unitpricerp = round((double) @$objNewMaterial->unitpricerp, 3);
        $unitpriceusd = round((double) @$objNewMaterial->unitpriceusd, 3);
      
        $created_by = $this->session->userdata('id');
        echo "<script>alet('$unitpriceusd');</script>";
        if (@$objNewMaterial->curr_costing_price == 'USD') {
            $unitpricerp = 0;
        } else {
            $unitpriceusd = 0;
        }

        $this->db->insert('costingdetail', array(
            "costingid" => @$objNewMaterial->costingid,
            "categoryid" => @$objNewMaterial->categoryid,
            "itemid" => @$objNewMaterial->itemid,
            "materialcode" => @$objNewMaterial->materialcode,
            "materialdescription" => @$objNewMaterial->materialdescription,
            "uom" => @$objNewMaterial->uom,
            "qty" => (double) @$objNewMaterial->qty,
            "yield" => (double) @$objNewMaterial->yield,
            "allowance" => (double) @$objNewMaterial->allowance,
            "req_qty" => round((double) @$objNewMaterial->req_qty, 2),
            "unitpricerp" => $unitpricerp,
            "unitpriceusd" => $unitpriceusd,
            "total" => round((double) @$objNewMaterial->total, 3),
            "source" => @$objNewMaterial->source,
            "created_by" =>$created_by
        ));

        return $this->db->insert_id();
    }

    function deletedetail($id) {
        // Menyusun query
        $query = "DELETE FROM costingdetail WHERE id=$id";
        
        // Menjalankan query dan menangani error
        if ($this->db->query($query)) {
            return true;  // Query berhasil
        } else {
            // Menangani error jika query gagal
            $error = $this->db->_error_message();  // Mendapatkan error message
            // Menulis error ke dalam file log (misalnya log.txt)
            log_message('error', "Query failed: $query\nError: $error");
            return false;  // Query gagal
        }
    }
    
    

    function move($id, $category) {
        $this->db->where("id", $id);
        $this->db->update('costingdetail', array(
            "categoryid" => $category
        ));
    }

    function updatedetail($id, $materialcode, $materialdescription, $uom, $qty, $yield, $allowance, $req_qty, $unitpricerp, $unitpriceusd, $itemid,$updated_date, $updated_by) {
        $this->db->where("id", $id);
        $this->db->update('costingdetail', array(
            "materialcode" => $materialcode,
            "materialdescription" => $materialdescription,
            "uom" => $uom,
            "qty" => $qty,
            "yield" => $yield,
            "allowance" => $allowance,
            "req_qty" => $req_qty,
            "unitpricerp" => $unitpricerp,
            "unitpriceusd" => $unitpriceusd,
            "itemid" => $itemid,
            "updated_date" =>$updated_date,
            "updated_by" => $updated_by
        ));
    }

    function updatedetail_from_printout($objMaterial) {
        //var_dump($objMaterial);
        $this->db->where("id", $objMaterial->id);
        $updated_date = date('Y-m-d H:i:s');
        $updated_by = $this->session->userdata('id');
        $allowance = (@$objMaterial->allowance == "" || @$objMaterial->allowance == null ) ? null : (double) @$objMaterial->allowance;
       // @$objMaterial->req_qty=@$objMaterial->qty/(@$objMaterial->yield*(1+$allowance));

        $this->db->update('costingdetail', array(
            "qty" => (double) @$objMaterial->qty,
            "yield" => empty(@$objMaterial->yield) ? null : (double) @$objMaterial->yield,
            "allowance" => $allowance,
            "req_qty" => (double) @$objMaterial->req_qty,
            //"unitpriceusd" => (double) @$objMaterial->unitpriceusd,
            "total" => (double) @$objMaterial->total,
            "source" => "Manual",
            "updated_date" =>$updated_date,
            "updated_by" => $updated_by
        ));
    }

    function update_price_from_printout($objMaterial) {
        $this->db->where("id", $objMaterial->id);

        $price_usd = 0;
        $price_rp = 0;

        if (@$objMaterial->curr_costing_price == "USD") {
            $price_usd = (double) @$objMaterial->unitpriceusd;
        } else if (@$objMaterial->curr_costing_price == "IDR") {
            $price_rp = (double) @$objMaterial->unitpricerp;
        }

        $this->db->update('costingdetail', array(
            "unitpricerp" => $price_rp,
            "unitpriceusd" => $price_usd,
            "total" => (double) @$objMaterial->total,
            "source" => "Manual"
        ));
    }

    function movedetail_from_printout($objMovedMaterial) {
        $this->db->where("id", $objMovedMaterial->id);
        $this->db->update('costingdetail', array(
            "categoryid" => @$objMovedMaterial->move_to_category_id,
        ));
    }

    function approve($id) {
        return $this->db->update('costing', array("approve" => 'TRUE', "isreviewed" => 'TRUE', "date" => date('Y-m-d'), "needmodify" => 'FALSE', "locked" => "TRUE"), array("id" => $id));
    }

    function getRateByCostingId($costingid) {
        $dt = $this->db->query("select ratevalue from costing where id=$costingid")->row();
        return $dt->ratevalue;
    }

    function savefobprice($data, $where) {
        return $this->db->update('costing', $data, $where);
    }

    function docopy($toid, $fromid) {
        return $this->db->query("select costing_docopy($toid,$fromid)");
    }

    function docopypart($toid, $fromid, $category) {
        $query = "select costing_docopypart($toid, $fromid, $category)";
        echo $query;
        return $this->db->query($query);
    }

    function loadfrommaterial($costingid, $costingcategory, $modelid) {
        $query = "select costing_loadfrommaterial($costingid,$costingcategory,$modelid)";
        return $this->db->query($query);
    }

    function loadAllMaterialFromBOM($costingid, $modelid) {
        $query = "select costing_load_all($costingid,$modelid)";
        return $this->db->query($query);
    }

    function loadAllMaterialFromDefaultMaterial($costingid) {
        $query = "select costing_load_all_from_default_material($costingid)";
        return $this->db->query($query);
    }

    function isExist($customerid, $modelid) {
        $dt = $this->db->query("select * from costing where customerid=$customerid and modelid=$modelid")->row();
        return (!empty($dt));
    }

    function isExist2($customerid, $modelid, $id) {
        $dt = $this->db->query("select * from costing where customerid=$customerid and modelid=$modelid and id!=$id")->row();
        return (!empty($dt));
    }

    function update($data, $where) {

        $item_costing_desc = $this->input->post('item_costing_desc');
        return $this->db->update('costing', $data, $where);
    }

    function updateRateValue($costing_id, $ratevalue) {
        return $this->db->update('costing', array(
                    "ratevalue" => $ratevalue,
                        ), array("id" => $costing_id));
    }

    function updatePicklistRateValue($costing_id, $picklist_ratevalue) {
        return $this->db->update('costing', array(
                    "picklist_ratevalue" => $picklist_ratevalue,
                        ), array("id" => $costing_id));
    }

    function getPriceByCustomerAndModel($modelid, $customerid) {
//echo "select fob_price from costing where modelid=$modelid and customerid=$customerid";

        return $this->db->query("select fob_price from costing where modelid=$modelid and customerid=$customerid")->row()->fob_price;
    }

//============================

    function selectCostingCategoryDirectMaterial() {
        $query = "select * from costingcategory where isdirectmaterial =TRUE order by id asc";
        return $this->db->query($query)->result();
    }

    function selectCostingCategoryNotDirectMaterial() {
        $query = "select * from costingcategory where isdirectmaterial=FALSE order by id asc";
        return $this->db->query($query)->result();
    }

    function selectAllCostingCategory() {
        $query = "select * from costingcategory order by id asc";
        return $this->db->query($query)->result();
    }

    function selectAllHeader() {
        $query = "select 
            costingheader.*,
            so.number sonumber,
            so.date sodate,
            model.id modelid,
            model.no,
            model.description,
            model.dw,
            model.dd,
            model.dht,
            model.filename,
        	model.is_temporary_photo,
            model.custcode from costingheader 
            join model on costingheader.modelid=model.id 
            join so on costingheader.soid=so.id";
        return $this->db->query($query)->result();
    }

    function loadHardwareToCosting($costingheaderid, $soid, $modelid) {
        $this->db->query("select costing_loadhardware($costingheaderid,$soid,$modelid)");
    }

    function getIdByModelIdAndSoId($modelid, $soid) {
        $query = "select id from costingheader where modelid=$modelid and soid=$soid limit 1";
        $dt = $this->db->query($query)->result();
        return empty($dt) ? 0 : $dt->id;
    }

    function iscomplete($soid) {
        $dt = $this->db->query("select costing_iscomplete($soid) as ct")->row();
        return $dt->ct;
    }

    function iscompleteformanagement($soid) {
        $dt = $this->db->query("select costing_iscompleteformanagement($soid) as ct")->row();
        return $dt->ct;
    }

    function delete($id) {
        return $this->db->query("select costing_delete($id)");
    }

    function submit_to_check($id) {
        return $this->db->query("select submit_to_check($id)");
    }

    function loaddirectlabour($id) {
        return $this->db->query("select costing_loaddirectlabour($id)");
    }

    function lock($costingid) {
        return $this->db->update('costing', array("locked" => "TRUE", "needmodify" => 'FALSE', "approve" => "FALSE"), array("id" => $costingid));
    }

    function unlock($costingid) {
// return $this->db->update('costing', array("locked" => "FALSE", "approve" => "FALSE"), array("id" => $costingid));
        return $this->db->update('costing', array("locked" => "FALSE", "approve" => "FALSE", "needmodify" => "TRUE", "checkedstatus" => 1, "approvedstatus" => ""), array("id" => $costingid));
    }

    function updatematerialprice($costingid) {
        return $this->db->query("select costing_updatematerialprice($costingid)");
    }

    function searchcopycosting($modelcode, $custcode, $modeldescription, $customerid) {
        $query = "select 
                costing.*,
                model.no code,
                model.custcode,
                model.description,
                model.filename,
                model.dd,
                model.dw,
                model.dht,
                customer.name customername
                from costing
                join model on costing.modelid=model.id
                join customer on costing.customerid=customer.id ";
        if ($modelcode != '') {
            $query .= " and model.no ilike '%" . $modelcode . "%' ";
        }if ($custcode != '') {
            $query .= " and model.custcode ilike '%" . $custcode . "%' ";
        }if ($modeldescription != '') {
            $query .= " and model.description ilike '%" . $modeldescription . "%' ";
        }if ($customerid != 0) {
            $query .= " and costing.customerid=$customerid ";
        }
        $query .= " order by costing.id desc ";
//echo $query;        
        return $this->db->query($query)->result();
    }

    function updatefobprice($costingid, $fobprice) {
        $this->db->update('costing', array("fob_price" => $fobprice), array("id" => $costingid));
    }

    function get_costing($model_no, $model_type, $cust_code) {

        $query = "select c.*,
                m.no code,
                m.custcode,
                m.description,
                m.filename,
                m.is_temporary_photo,
                m.finishoverview,
                m.constructionoverview,
                m.dd,
                m.dw,
                m.dht,
                m.nw,
                m.gw,
                customer.name customername
                from costing c
                left join customer on c.customerid=customer.id 
                left join model m on c.modelid=m.id
                left join modeltype mt on mt.id=m.modeltypeid
                where true";

        if ($model_no != null) {
            $model_no = implode($model_no, "','");
            $query .= " AND m.no in ('" . $model_no . "')";
        } else if ($model_type != null) {
            $query .= " AND mt.name in ('" . $model_type . "')";
        } else if ($cust_code != null) {
            $query .= " AND m.custcode='$cust_code'";
        } else {
            $query .= " AND false";
        }

        return $this->db->query($query)->result();
    }

    function select_quotation_by_customerid($id) {
//$this->create_quotation();
//$id = str_replace(',', ' or costing.id=', $id);
//echo $id;
        $query = "select 
                sq.* 
                from sales_quotes sq 
                where sq.customer_id=$id";
 //echo $query;
        return $this->db->query($query)->result();
    }

    function get_max_sales_quoteid() {
        return $this->db->query("select id as maks_id,quotation_number,prev_quo_date from public.sales_quotes where true order by id desc limit 1")->result();
    }

    function create_quotation($id) {
        //echo 'port origin='.$_GET['port_origin_cost']."<br>";
        $to = $this->input->get('to');
        $pterm = $this->input->get('pterm');
        $reference = $this->input->get('ref');
        $customer_id = $this->input->get('custid');
        $pick_list_rate_value = $this->input->get('pick_list_rate_value');
        $picklist_mark_up = $this->input->get('picklist_mark_up');
        $fixed_cost = $this->input->get('fixed_cost');
        $variable_cost = $this->input->get('variable_cost');
        $port_origin_cost = $this->input->get('port_origin_cost');
        $valid_date = $this->input->get('valid_date');
        $qnewnumber = $this->input->get('quonumber');
        $insurance = $this->input->get('insurance');
        $description = $this->input->get('description');
        
        // Mendapatkan data quantities yang dikirim dari controller
        $quantities_json = urldecode($this->input->get('quantities'));
        $quantities = json_decode($quantities_json, true) ?: array();
        
        if (trim($valid_date) == "") {
            $valid_date = NULL;
        }
        $parent_sales_quotes_id = $this->input->get('parentid');
        //echo 'parentid='.$parent_sales_quotes_id;
        $createby = $this->session->userdata('id');
        $revisi = 0;
        $quodate = date('Y-m-d');
        $prev_quo_date = null;
        
        if ($parent_sales_quotes_id != 0) {
            $query = "select quotation_number,revision,quo_date,prev_quo_date from public.sales_quotes where id=$parent_sales_quotes_id order by id limit 1";
            $query_result = $this->db->query($query);
            
            if ($query_result) {
                $parent = $query_result->result();
                if (!empty($parent)) {
                    $revisi = $parent[0]->revision + 1;
                    if ($parent[0]->prev_quo_date == null)
                        $prev_quo_date = $parent[0]->quo_date;
                    else {
                        $prev_quo_date = $parent[0]->quo_date;
                    }
                }
            } else {
                // Log error atau tampilkan pesan
                error_log("Error executing query: " . $this->db->error()['message']);
            }
        }
        
        if ($this->db->insert('sales_quotes', array(
                    "to_cp" => $to,
                    "customer_id" => $customer_id,
                    "quotation_number" => $qnewnumber,
                    "reference" => $reference,
                    "quo_date" => $quodate,
                    "revision" => $revisi,
                    "fixed_cost" => (double) $fixed_cost,
                    "variable_cost" => (double) $variable_cost,
                    "port_origin_cost" => (double) $port_origin_cost,
                    "picklist_ratevalue" => (double) $pick_list_rate_value,
                    "picklist_markup" => (double) $picklist_mark_up,
                    "parent_sales_quotes_id" => (int) $parent_sales_quotes_id,
                    "prev_quo_date" => $prev_quo_date,
                    "valid_date" => $valid_date,
                    "description" => $description,
                    "insurance" => (double) $insurance,
                    "created_at" => date('Y-m-d H:i:s'),
                    "created_by" => $createby,
                    "pterm" => $pterm
                ))) {
    
            //----------------- Create QUOTATION ITEM 
            $idmax = $this->model_costing->get_max_sales_quoteid();
            $sales_quotes_id = $idmax[0]->maks_id;
            
            // Pastikan $id diformat dengan benar untuk query SQL
            $id_clause = str_replace(',', ' or costing.id=', $id);
            
            // Print query untuk debugging jika diperlukan
            $query = "select 
                costing.*,
                model.no code,
                model.custcode,
                model.finish_on_metal_hardware,
                model.additionalnotes,
                model.description model_desc,
                model.filename,
                model.dd,
                model.dw,
                model.dht,
                model.cd,
                model.cw,
                model.ch,
                customer.name customername
                
                from costing
                left join model on costing.modelid=model.id
                left join customer on costing.customerid=customer.id where (costing.id=$id_clause)";
                
            // Untuk debugging
            // echo "Query: " . $query . "<br>";
            
            $query_result = $this->db->query($query);
            
            if ($query_result === FALSE) {
                // Log error untuk debugging
                error_log("Query error: " . $this->db->error()['message']);
                error_log("Query: " . $query);
                return FALSE;
            }
            
            $qcitem = $query_result->result();
            
            if (empty($qcitem)) {
                error_log("No results found for query: " . $query);
            }
            
            foreach ($qcitem as $result) {
                // Menentukan quantity untuk item ini, default ke 1 jika tidak ditemukan
                $quantity = isset($quantities[$result->id]) ? (int)$quantities[$result->id] : 1;
                
                if ($this->db->insert('sales_quotes_detail', array(
                            "sales_quotes_id" => $sales_quotes_id,
                            "costingid" => $result->id,
                            "ratevalue" => $result->ratevalue,
                            "profit_margin" => $result->profit_percentage,
                            "fob_price" => $result->fob_price,
                            "fob_price_before" => 0,
                            "ratevalue_before" => 0,
                            "q_wood" => $result->q_wood,
                            "q_veneer" => $result->q_veneer,
                            "q_upholstery_type" => $result->q_upholstery_type,
                            "q_fabric" => $result->q_fabric,
                            "q_leather" => $result->q_leather,
                            "q_other_remarks" => $result->q_other_remarks,
                            "q_shipping_conf" => $result->q_shipping_conf,
                            "q_packing" => $result->q_packing,
                            "q_qty_perbox" => $result->q_qty_perbox,
                            "q_box_dimension" => $result->q_box_dimension,
                            "q_cube" => $result->q_cube,
                            "q_finishes" => $result->q_finishes,
                            "dw" => $result->dw,
                            "dd" => $result->dd,
                            "dht" => $result->dht,
                            "cw" => $result->cw,
                            "cd" => $result->cd,
                            "ch" => $result->ch,
                            "quantity" => $quantity  // Menambahkan quantity dari data yang diterima
                        ))) {
                    //echo 'Item berhasil ditambahkan';
                } else {
                    error_log("Failed to insert sales_quotes_detail: " . $this->db->error()['message']);
                }
            }
    
            return $sales_quotes_id;
        } else {
            error_log("Failed to insert sales_quotes: " . $this->db->error()['message']);
            return FALSE;
        }
    }

    function createquonumber($parentid) {
        // echo $parentid."<br>";
        $startnumber=8886;
        if ((int) $parentid != 0) {
            $query = "select quotation_number,revision,quo_date,prev_quo_date from public.sales_quotes where id=$parentid order by id limit 1";
           // echo $query . "<hr>";
            $parent = $this->db->query($query)->result();
            $codes = explode('/', $parent[0]->quotation_number);
            $codes = explode('R', $codes[0]);
            $revisi = $parent[0]->revision + 1;
            $qnewnumber = ($codes[0]) . "R" . $revisi . "/QN/" . $this->getRomawi(date('n')) . "/" . date('Y');
          //  echo "test".$qnewnumber;
        } else {
            $query = "select max(cast(substring(quotation_number,1,4) as int)) as quotation_number from public.sales_quotes";
          //  echo $query . "<hr>";
            $qnew = $this->db->query($query)->result();
            // var_dump(count($qnew))."<br>";
            if (count($qnew) >= 1) {
                $codes = explode('/', $qnew[0]->quotation_number);
                $qnewnumber = ($codes[0] + 1) . "/QN/" . $this->getRomawi(date('n')) . "/" . date('Y');
            } else {

                $qnewnumber = $startnumber . "/QN/" . $this->getRomawi(date('n')) . "/" . date('Y');
            }
        }
        return $qnewnumber;
    }

    function select_quotation_byid($quotation_id) {

        $query = "select sq.*, customer.name cust_name from sales_quotes sq "
                . "LEFT JOIN customer on sq.customer_id=customer.id "
                . "where sq.id=$quotation_id";
        return $this->db->query($query)->result();
    }

    function select_allitem_by_quotationid($quotation_id) {
        $query = "select sqd.*, model.no code,
                model.custcode,
                model.finish_on_metal_hardware,
                model.additionalnotes,
                model.description model_desc,
                model.filename,
                cost.modelid 
                from sales_quotes_detail sqd 
                left join costing cost on sqd.costingid=cost.id
                JOIN model on cost.modelid=model.id 
                where sqd.sales_quotes_id=$quotation_id order by model.no asc ";
        // echo $query."<br>";
        return $this->db->query($query)->result();
    }

    function select_item_by_quotationid($parentid, $costingid) {
        // Gunakan prepared statement untuk mencegah SQL injection
        $query = "SELECT * FROM sales_quotes_detail WHERE costingid = ? AND sales_quotes_id = ?";
        $result = $this->db->query($query, array($costingid, $parentid));
        
        // Cek apakah query berhasil dieksekusi
        if ($result !== FALSE) {
            return $result->result();
        } else {
            // Log error jika terjadi masalah
            error_log("Error in select_item_by_quotationid: " . $this->db->error()['message']);
            // Return array kosong sebagai fallback
            return array();
        }
    }

    public function create_price_list($data)
    {
        $this->db->where('model_id', $data['model_id']);
        $this->db->where('customer_id', $data['customer_id']);
        $this->db->where('price_list_id', $data['price_list_id']);
        $query = $this->db->get('price_list_detail');
    
        error_log('Query cek data: ' . $this->db->last_query());
    
        if ($query->num_rows() > 0) {
            $existing = $query->row();
            error_log('Data existing ditemukan dengan price_list_id: ' . $data['price_list_id'] . ' status: ' . $existing->status);
            
            // Cek jika status-nya Final, maka tolak update
            if (strtolower($existing->status) === 'final') {
                error_log('Update ditolak karena status Final');
                return false; // Tidak bisa update jika sudah Final
            }
            
            // Jika tidak Final, lakukan update
            $this->db->where('model_id', $data['model_id']);
            $this->db->where('customer_id', $data['customer_id']);
            $this->db->where('price_list_id', $data['price_list_id']);
            $result = $this->db->update('price_list_detail', $data);
            error_log('Query update: ' . $this->db->last_query());
            error_log('Hasil update: ' . ($result ? 'berhasil' : 'gagal'));
            
            // Tangani error tanpa menggunakan metode error()
            if (!$result) {
                error_log('Update gagal. Last query: ' . $this->db->last_query());
            }
            
            return $result;
        } else {
            // Jika tidak ditemukan, insert data baru
            error_log('Mencoba insert data baru dengan price_list_id: ' . $data['price_list_id']);
            error_log('Data yang akan diinsert: ' . json_encode($data));
            
            try {
                $result = $this->db->insert('price_list_detail', $data);
                error_log('Query insert: ' . $this->db->last_query());
                error_log('Hasil insert: ' . ($result ? 'berhasil' : 'gagal'));
                
                // Tangani error tanpa menggunakan metode error()
                if (!$result) {
                    error_log('Insert gagal. Last query: ' . $this->db->last_query());
                    
                    // Coba dapatkan last error dari database dengan metode alternatif
                    $last_error = pg_last_error();
                    if ($last_error) {
                        error_log('PostgreSQL error: ' . $last_error);
                    }
                }
                
                return $result;
            } catch (Exception $e) {
                error_log('Exception pada insert: ' . $e->getMessage());
                return false;
            }
        }
    }
    

    public function get_fob_price_by_costingid($costingid) {
        $this->db->select('fob_price');
        $this->db->from('sales_quotes_detail');
        $this->db->where('costingid', $costingid);
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row()->fob_price;
        } else {
            return null; // atau bisa juga return 0 atau false tergantung kebutuhan
        }
    }
    

    public function check_price_list_exists($model_id, $customer_id, $price_list_id = null) {
        $this->db->where('model_id', $model_id);
        $this->db->where('customer_id', $customer_id);
        
        if ($price_list_id !== null) {
            $this->db->where('price_list_id', $price_list_id);
        }
        
        $query = $this->db->get('price_list_detail');
        error_log('Query check_price_list_exists: ' . $this->db->last_query());
        error_log('Hasil check_price_list_exists: ' . $query->num_rows());
        
        return $query->num_rows() > 0;
    }
    
    

}

?>
