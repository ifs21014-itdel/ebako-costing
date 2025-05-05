<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of groups
 *
 * @author admin
 */
class product_price extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            echo "<script>location.reload()</script>";
        }
        $this->load->model('model_model');
        $this->load->model('model_rfqdetail');
        $this->load->model('model_user');
        $this->load->model('model_rate');
        $this->load->model('model_customer');
        $this->load->model('model_costing');
        $this->load->model('model_productprice');
    }

   
    public function index() {
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "model"));
        $this->load->model('model_modeltype');
        $this->load->model('model_rfqdetail');
        $data['numberrequest'] = count($this->model_rfqdetail->selectRequestedModel());
        $data['modeltype'] = $this->model_modeltype->selectAll();
        $data['customer'] = $this->model_customer->selectAll();
        
        // Tambahkan bagian ini untuk memuat data product_price secara default
        $offset = 0;
        $limit = $this->config->item('limit');
        $data['num_rows'] = $this->model_productprice->getNumRows('', '', '', '', 0);
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['first'] = 0;
        $data['offset'] = $offset;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        $data['product_prices'] = $this->model_productprice->search('', '', '', '', 0, $limit, $offset);
        
        $this->load->view('product_price/view', $data);
    }


    function createnew() {
        $this->load->model('model_customer');
        $data['rate'] = $this->model_rate->selectAll();
        $data['customer'] = $this->model_customer->selectAll();
        $this->load->view('product_price/createnew', $data);
    }


    public function lists($temp, $id, $billto)
    {
        $this->load->model('model_productprice');
        
        // Ambil data sales_quotes_detail berdasarkan customer dan model
        $salesQuotes = $this->model_productprice->getLatestSalesQuotationByCustomerAndModel($billto, $id);
        $sales = $this->model_productprice->getLatestSalesQuotationByCustomer($billto);
        $data['temp'] = $temp;
        $data['id'] = $id;
        $data['billto'] = $billto;
        $data['salesQuotes'] = $salesQuotes;
        $data['sales'] = $sales;
        $this->load->view('product_price/list', $data);
    }

    public function get_quotation_detail() {
        $id = $this->input->get('id');
        $this->load->model('model_productprice');
        $quote = $this->model_productprice->getSalesQuoteDetailById($id);
        echo json_encode($quote);
    }

    public function search() {
        $code = $this->input->get('code');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $billto = $this->input->get('billto');
        $page = $this->input->get('page');
        
        // Siapkan kondisi query berdasarkan parameter pencarian
        $conditions = array();
        
        if (!empty($billto) && $billto != 0) {
            $conditions['customerid'] = $billto;
        }
        
        if (!empty($code)) {
            // Menggunakan JOIN dengan tabel model untuk mencari model code
            $this->db->join('model', 'model.id = costing.modelid', 'left');
            $this->db->like('model.no', $code);
        }
        
        if (!empty($date_from)) {
            $this->db->where('costing.date >=', $date_from);
        }
        
        if (!empty($date_to)) {
            $this->db->where('costing.date <=', $date_to);
        }
        
        // Query untuk costing dengan kondisi pencarian
        $this->db->select('costing.*, model.no as modelno');
        $this->db->from('costing');
        $this->db->join('model', 'model.id = costing.modelid', 'left');
        foreach ($conditions as $field => $value) {
            $this->db->where("costing.$field", $value);
        }
        $this->db->order_by('costing.date', 'DESC');
        
        $data['costing'] = $this->db->get()->result();
        $data['temp'] = $this->input->get('temp');
        $data['id'] = $this->input->get('id');
        $data['billto'] = $billto;
        
        $this->load->view('product_price/search_result', $data);
    }


    public function searchCostingByCustModel($id_customer, $id_model)
    {
        error_log('id customer'.$id_customer);
        error_log('id model;'.$id_model);
        $this->load->model('Model_costing'); // pastikan nama model sesuai
        $data['quotation_detail'] = $this->Model_costing->getCostingByCustomerAndModel($id_customer, $id_model);
        $data['costing'] =$this->Model_costing->selectById($id_customer);
        error_log('Isi costing dedi: ' . print_r($data['costing'], true));
        $this->load->view('product_price/search_result', $data);
    }
    

    public function list_model($temp, $id, $billto) {
        $this->load->model('model_model');
        $data['models'] = $this->model_model->selectAll();
        if ($billto == 0) {
            $data['models'] = [];// $this->model_model->selectAllAvailabel();
        } else {
            $data['models'] = $this->model_model->selectAllFromCostingByCustomer($billto);
        }
        $data['temp'] = $temp;
        $data['id'] = $id;
        $data['billto'] = (int) $billto;
        
        $this->load->view('product_price/list_model', $data);
    }
    

    public function search_model() {
        $code = $this->input->get('code');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $billto = $this->input->get('billto');
        $page = $this->input->get('page');
    
        // Siapkan kondisi query berdasarkan parameter pencarian
        $conditions = array();
    
        if (!empty($billto) && $billto != 0) {
            $conditions['customerid'] = $billto;
        }
    
        if (!empty($code)) {
            $this->db->where("(model.no LIKE '%".$this->db->escape_like_str($code)."%' OR 
                           model.custcode LIKE '%".$this->db->escape_like_str($code)."%' OR 
                           model.description LIKE '%".$this->db->escape_like_str($code)."%')");
        }
    
        if (!empty($date_from)) {
            $this->db->where('model.inputdate >=', $date_from);
        }
    
        if (!empty($date_to)) {
            $this->db->where('model.inputdate <=', $date_to);
        }
    
        // Query untuk model dengan kondisi pencarian
        $this->db->select('*');
        $this->db->from('model');
        
        foreach ($conditions as $field => $value) {
            $this->db->where($field, $value);
        }
        
        $this->db->order_by('model.inputdate', 'DESC');
    
        $data['models'] = $this->db->get()->result();
        $data['temp'] = $this->input->get('temp');
        $data['id'] = $this->input->get('id');
        $data['billto'] = $billto;
    
        $this->load->view('product_price/search_result_model', $data);
    }
    
    public function saveNew() {
        // Untuk data yang dikirim sebagai JSON
        $json_data = json_decode(file_get_contents('php://input'), true);
        
        if ($json_data) {
            // Gunakan data dari JSON
            $customerid = isset($json_data['customerid']) ? $json_data['customerid'] : null;
            $ebako_code = isset($json_data['ebako_code']) ? $json_data['ebako_code'] : null;
            $quotation_id = isset($json_data['quotation_id']) ? $json_data['quotation_id'] : null;
            $quotation_date = isset($json_data['quotation_date']) ? $json_data['quotation_date'] : null;
            $approval_date = isset($json_data['approval_date']) ? $json_data['approval_date'] : null;
            $cw = isset($json_data['cw']) ? (double)$json_data['cw'] : null;
            $cd = isset($json_data['cd']) ? (double)$json_data['cd'] : null;
            $ch = isset($json_data['ch']) ? (double)$json_data['ch'] : null;
            $q_finished = isset($json_data['q_finished']) ? $json_data['q_finished'] : null;
            $material = isset($json_data['material']) ? $json_data['material'] : null;
            $fob = isset($json_data['fob']) ? (double)$json_data['fob'] : null;
            $customercode = isset($json_data['customercode']) ? $json_data['customercode'] : null;
            $description = isset($json_data['description']) ? $json_data['description'] : null;

        } else {
            // Gunakan data dari POST biasa (form)
            $customerid = $this->input->post('customerid');
            $ebako_code = $this->input->post('ebako_code'); // Diubah dari modelid ke ebako_code
            $quotation_date = $this->input->post('quotation_date');
            $quotation_id = $this->input->post('quotation_id');
            $approval_date = $this->input->post('approval_date');
            $cw = (double) $this->input->post('cw');
            $cd = (double) $this->input->post('cd');
            $ch = (double) $this->input->post('ch');
            $q_finished = $this->input->post('q_finished'); // Diubah dari item_costing_q_wood ke q_finished
            $material = $this->input->post('material');
            $fob = (double) $this->input->post('fob'); // Diubah dari costingid ke fob
            $customercode = $this->input->post('customercode');
            $description = $this->input->post('description'); // Diubah dari costingid ke fob
        }
        
        error_log('Raw POST Data: ' . file_get_contents('php://input'));
        error_log("customerid: " . $customerid);
        error_log("ebako_code: " . $ebako_code);
        error_log("quotation_date: " . $quotation_date);
        error_log("approval_date: " . $approval_date);
        error_log("cw: " . $cw);
        error_log("cd: " . $cd);
        error_log("ch: " . $ch);
        error_log("q_finished: " . $q_finished);
        error_log("fob: " . $fob);
    
        if (empty($customerid) || empty($ebako_code) || empty($quotation_id) ||empty($quotation_date) || empty($cw) || empty($cd) || empty($ch) || empty($fob)) {
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
    
        $data = [
            'customer_id' => $customerid,
            'ebako_code' => $ebako_code,
            'quotation_date' => $quotation_date,
            'quotation_id' => $quotation_id,
            'approval_date' => $approval_date,
            'cw' => round($cw, 3),
            'cd' => round($cd, 3),
            'ch' => round($ch, 3),
            'q_finished' => $q_finished,
            'fob' => round($fob, 3),
            'material' =>$material,
            'customercode'=>$customercode,
            'description' =>$description
        ];
        
        if ($this->model_productprice->insert($data)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => $this->db->error()]);
        }
    }



    function search_productprice($offset = 0) {
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "product_price"));
        
        // Mendapatkan nilai filter dari input
        $ebako_code = $this->input->post('ebako_code');
        $customercode = $this->input->post('customer_code');
        $quotation_date_start = $this->input->post('quotation_date_start');
        $quotation_date_end = $this->input->post('quotation_date_end');
        $customerid = $this->input->post('customerid');
        
        // Jika tidak ada parameter pencarian (saat pertama kali halaman dimuat),
        // tampilkan semua data tanpa filter
        $isSearching = ($ebako_code !== null || $customer_code !== null || 
                       $quotation_date_start !== null || $quotation_date_end !== null ||
                       $customerid !== null && $customerid != 0);
        
        if (!$isSearching) {
            $ebako_code = '';
            $customercode = '';
            $quotation_date_start = '';
            $quotation_date_end = '';
        }
        
        // Mendapatkan jumlah total data berdasarkan filter atau semua data
        $data['num_rows'] = $this->model_productprice->getNumRows($ebako_code, $customercode, $quotation_date_start, $quotation_date_end, $customerid);
        $limit = $this->config->item('limit');
        
        // Validasi offset
        if(empty($offset) || $offset < 0){
            $offset = 0;
        }
        
        // Perhitungan paginasi
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['offset'] = $offset;
        $data['first'] = 0;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        
        // Mendapatkan data product_price berdasarkan filter dan paginasi
        $data['product_prices'] = $this->model_productprice->search($ebako_code, $customercode, $quotation_date_start, $quotation_date_end, $customerid, $limit, $offset);
        
        $this->load->view('product_price/search', $data);
    }

    function edit($id) {
        $this->load->model('model_customer');
        $data['rate'] = $this->model_rate->selectAll();
        $data['customer'] = $this->model_customer->selectAll();
        $data['product_price'] = $this->model_productprice->selectById($id);
        error_log(print_r($data, true)); // atau bisa pakai json_encode($data)
        $this->load->view('product_price/edit', $data);
    }


    public function update() {
        $json_data = json_decode(file_get_contents('php://input'), true);
    
        if ($json_data) {
            $id = isset($json_data['id']) ? $json_data['id'] : null;
            $customer_id = isset($json_data['customerid']) ? $json_data['customerid'] : null;
            $ebako_code = isset($json_data['ebako_code']) ? $json_data['ebako_code'] : null;
            $quotation_id = isset($json_data['quotation_id']) ? $json_data['quotation_id'] : null;
            $material = isset($json_data['material']) ? $json_data['material'] : null;
            $quotation_date = isset($json_data['quotation_date']) ? $json_data['quotation_date'] : null;
            $approval_date = isset($json_data['approval_date']) ? $json_data['approval_date'] : null;
            $cw = isset($json_data['cw']) ? (double)$json_data['cw'] : null;
            $cd = isset($json_data['cd']) ? (double)$json_data['cd'] : null;
            $ch = isset($json_data['ch']) ? (double)$json_data['ch'] : null;
            $q_finished = isset($json_data['q_finished']) ? $json_data['q_finished'] : null;
            $fob = isset($json_data['fob']) ? (double)$json_data['fob'] : null;
            $description = isset($json_data['description']) ? $json_data['description'] : null;
            $customercode = isset($json_data['customercode']) ? $json_data['customercode'] : null;
        } else {
            $id = $this->input->post('id');
            $customer_id = $this->input->post('customerid');
            $quotation_id = $this->input->post('quotation_id');
            $material = $this->input->post('material');
            $ebako_code = $this->input->post('ebako_code');
            $quotation_date = $this->input->post('quotation_date');
            $approval_date = $this->input->post('approval_date');
            $cw = (double) $this->input->post('cw');
            $cd = (double) $this->input->post('cd');
            $ch = (double) $this->input->post('ch');
            $q_finished = $this->input->post('q_finished');
            $fob = (double) $this->input->post('fob');
            $description = $this->input->post('description');
            $customercode = $this->input->post('customercode');
        }
    
        if (empty($id) || empty($customer_id) || empty($ebako_code) || empty($quotation_date) || $cw === null || $cd === null || $ch === null || $fob === null) {
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }
    
        $data = [
            'customer_id' => $customer_id,
            'material' => $material,
            'quotation_id' => $quotation_id,
            'ebako_code' => $ebako_code,
            'quotation_date' => $quotation_date,
            'approval_date' => $approval_date,
            'cw' => round($cw, 3),
            'cd' => round($cd, 3),
            'ch' => round($ch, 3),
            'q_finished' => $q_finished,
            'fob' => round($fob, 3),
            'description' => $description,
            'customercode' => $customercode
        ];
    
        if ($this->model_productprice->update($id, $data)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => $this->db->error()]);
        }
    }
    
    
    
    public function delete($id)
{
    if ($this->model_productprice->delete($id)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $this->db->error()]);
    }
}


}

?>
