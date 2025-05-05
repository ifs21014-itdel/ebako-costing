<?php
/**
 * Proforma Quotation Controller
 *
 * Controller for managing proforma quotations
 *
 * @author admin
 */
class proforma_quotation extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        $this->load->model('model_model');
        $this->load->model('model_productprice');
        $this->load->model('model_rfqdetail');
        $this->load->model('model_user');
        $this->load->model('model_rate');
        $this->load->model('model_customer');
        $this->load->model('model_costing');
        $this->load->model('model_proformaquotation'); // Load proforma quotation model
    }
    
    /**
     * Main index page
     */
    public function index() {
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "proforma_quotation"));
        $data['customer'] = $this->model_customer->selectAll();
        
        // Load default data with pagination
        $offset = 0;
        $limit = $this->config->item('limit');
        $data['num_rows'] = $this->model_proformaquotation->getNumRows('', '', 0);
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['first'] = 0;
        $data['offset'] = $offset;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        $data['proforma_quotation'] = $this->model_proformaquotation->search('', '', 0, $limit, $offset);
        
        $this->load->view('proforma_quotation/view', $data);
    }
    
    /**
     * Search proforma quotations
     */
    public function search() {
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "proforma_quotation"));
        $model = $this->input->post('model');
        $customer = $this->input->post('customer');
        $customerid = $this->input->post('customerid');
        $offset = $this->input->post('offset');
        $limit = $this->config->item('limit');
        
        $data['num_rows'] = $this->model_proformaquotation->getNumRows($model, $customer, $customerid);
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['first'] = 0;
        $data['offset'] = $offset;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        $data['proforma_quotation'] = $this->model_proformaquotation->search($model, $customer, $customerid, $limit, $offset);
        
        $this->load->view('proforma_quotation/search', $data);
    }
    
    /**
     * View detail of proforma quotation
     */
    public function view_detail($id) {
        $data['proforma_quotation'] = $this->model_proformaquotation->selectById($id);
    
        // Pisahkan pemanggilan data dan log-nya
        $detail = $this->model_proformaquotation->selectDetailByProformaQuotationId($id);
        
        $data['proforma_quotation_detail'] = $detail;
    
        // Return HTML view for detail section
        $this->load->view('proforma_quotation/detail', $data);
    }
    
    
    /**
     * Create new proforma quotation
     */

    
    /**
     * Edit proforma quotation
     */
    public function edit($id) {
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "proforma_quotation"));
        $data['proforma_quotation'] = $this->model_proformaquotation->selectById($id);
        $data['proforma_quotation_detail'] = $this->model_proformaquotation->selectDetailByProformaQuotationId($id);
        $data['customer'] = $this->model_customer->selectAll();
        
        $this->load->view('proforma_quotation/edit', $data);
    }
    
    /**
     * Delete proforma quotation
     */
    public function delete($id) {
        $delete = $this->model_proformaquotation->delete($id);
        
        if ($delete) {
            echo "success";
        } else {
            echo "failed";
        }
    }


    public function search_detail() {
        $proforma_quotation_id = $this->input->post('proforma_quotation_id');
        $ebako_code = $this->input->post('ebako_code');
        $customer_code = $this->input->post('customer_code');
        $offset = $this->input->post('offset');
        $limit = $this->config->item('limit');
        
        $data['proforma_quotation'] = $this->model_proformaquotation->selectById($proforma_quotation_id);
        
        // Ambil data detail dengan filter dan pagination
        $data['num_rows'] = $this->model_proformaquotation->getNumRowsDetail($proforma_quotation_id, $ebako_code, $customer_code);
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['first'] = 0;
        $data['offset'] = $offset;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        $data['proforma_quotation_detail'] = $this->model_proformaquotation->searchDetail($proforma_quotation_id, $ebako_code, $customer_code, $limit, $offset);
        
        // Load view detail
        $this->load->view('proforma_quotation/detail', $data);
    }

    public function view_proforma_detail($id) {
        $data['proforma_quotation'] = $this->model_proformaquotation->selectById($id);
    
        // Tambahkan parameter pagination
        $offset = 0;
        $limit = $this->config->item('limit');
        $data['num_rows'] = $this->model_proformaquotation->getNumRowsDetail($id, '', '');
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['first'] = 0;
        $data['offset'] = $offset;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        
        // Ambil detail dengan pagination
        $data['proforma_quotation_detail'] = $this->model_proformaquotation->searchDetail($id, '', '', $limit, $offset);
    
        // Return HTML view for detail section
        $this->load->view('proforma_quotation/detail', $data);
    }

    function createnew() {
        $this->load->model('model_customer');
        $data['rate'] = $this->model_rate->selectAll();
        $data['customer'] = $this->model_customer->selectAll();
        $this->load->view('proforma_quotation/createnew', $data);
    }

    function createnewdetail() {
        $this->load->model('model_customer');
        $data['rate'] = $this->model_rate->selectAll();
        $data['customer'] = $this->model_customer->selectAll();
        $this->load->view('proforma_quotation/createdetail', $data);
    }

    function createnewdetail_from_product_price() {
        $this->load->model('model_customer');
        $data['rate'] = $this->model_rate->selectAll();
        $data['customer'] = $this->model_customer->selectAll();
        $this->load->view('proforma_quotation/createdetailbyproductprice', $data);
    }


    public function create_proforma() {
        // Ambil input JSON jika ada
        $json_data = json_decode(file_get_contents('php://input'), true);
    
        if ($json_data) {
            $customer_id = isset($json_data['customer_id']) ? $json_data['customer_id'] : null;
            $date = isset($json_data['date']) ? $json_data['date'] : null;
            $number = isset($json_data['number']) ? $json_data['number'] : null;
        } else {
            // Jika tidak berupa JSON, fallback ke POST
            $customer_id = $this->input->post('customer_id');
            $date = $this->input->post('date');
            $number = $this->input->post('number');
        }
    
    
        if (empty($customer_id) || empty($date) || empty($number)) {
            echo json_encode(['success' => false, 'msg' => 'Missing required fields']);
            return;
        }
    
        $data = array(
            'customer_id' => $customer_id,
            'date' => $date,
            'number' => $number,
            'created_by' => $this->session->userdata('id'),
            'update_by' => " "
        );
    
        error_log('Data yang akan disimpan ke proforma_quotation: ' . json_encode($data));
    
        $insert = $this->model_proformaquotation->insert($data);
    
        if ($insert) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Gagal menyimpan data']);
        }
    }
    public function edit_proforma() {
        $json_data = json_decode(file_get_contents('php://input'), true);
    
        if ($json_data) {
            $id = isset($json_data['id']) ? $json_data['id'] : null;
            $customer_id = isset($json_data['customer_id']) ? $json_data['customer_id'] : null;
            $date = isset($json_data['date']) ? $json_data['date'] : null;
            $number = isset($json_data['number']) ? $json_data['number'] : null;
        } else {
            $id = $this->input->post('id');
            $customer_id = $this->input->post('customer_id');
            $date = $this->input->post('date');
            $number = $this->input->post('number');
        }
    
        if (empty($id) || empty($customer_id) || empty($date) || empty($number)) {
            echo json_encode(['success' => false, 'msg' => 'Missing required fields']);
            return;
        }
    
        $data = array(
            'customer_id' => $customer_id,
            'date' => $date,
            'number' => $number,
            'update_by' => $this->session->userdata('id')
        );
    
        error_log('Data yang akan diupdate ke proforma_quotation: ' . json_encode($data));
    
        $update = $this->model_proformaquotation->update( $data,$id);
    
        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Gagal mengupdate data']);
        }
    }
    
    public function lists($temp, $id, $billto)
    {
        $this->load->model('model_productprice');
        error_log('dedi'.$id);  
        // Ambil data sales_quotes_detail berdasarkan customer dan model
        $salesQuotes = $this->model_productprice->getLatestSalesQuotationByCustomerAndModel($billto, $id);
        $sales = $this->model_productprice->getLatestSalesQuotationByCustomer($billto);
        $data['costing'] =$this->model_proformaquotation->selectCostingById($id);
        $data['temp'] = $temp;
        $data['id'] = $id;
        $data['billto'] = $billto;
        $data['salesQuotes'] = $salesQuotes;
        $data['sales'] = $sales;
        error_log('sales costing: ' . print_r($data['costing'], true));
        $this->load->view('proforma_quotation/list', $data);
    }


    public function lists_product_price($temp = 'product_price_list_temp')
    {
        $this->load->model('model_productprice');
        
        // Ambil semua data product price tanpa filter
        $salesQuotes = $this->model_productprice->getAllProductPrices();
        
        // Logging ke error log
        error_log("Sales Quotes: " . print_r($salesQuotes, true));
        
        $data['temp'] = $temp;
        $data['salesQuotes'] = $salesQuotes;
        
        $this->load->view('proforma_quotation/list_product_price', $data);
    }


    public function lists_product_price_2($temp = 'product_price_list_temp')
    {
        $this->load->model('model_productprice');
        
        // Ambil semua data product price tanpa filter
        $salesQuotes = $this->model_productprice->getAllProductPrices_2();
        
        // Logging ke error log
        error_log("Sales Quotes: " . print_r($salesQuotes, true));
        
        $data['temp'] = $temp;
        $data['salesQuotes'] = $salesQuotes;
        
        $this->load->view('proforma_quotation/list_product_price_2', $data);
    }
    

    public function search_product_price()
    {
        $this->load->model('model_productprice');
        $price_from = $this->input->get('price_from');
        $price_to = $this->input->get('price_to');
        $date_from = $this->input->get('date_from');
        $date_to = $this->input->get('date_to');
        $model_code = $this->input->get('model_code');
        $temp = $this->input->get('temp');
        
        $data['temp'] = $temp;
        $data['salesQuotes'] = $this->model_productprice->searchProductPrices(
            $model_code,
            $price_from, 
            $price_to, 
            $date_from, 
            $date_to
        );

        $this->load->view('proforma_quotation/list_product_price_search', $data);
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
        
        $this->load->view('proforma_quotation/list_model', $data);
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
    
        $this->load->view('proforma_quotation/search_result_model', $data);
    }

    public function searchCostingByCustModel($id_customer, $id_model)
    {
        error_log('id customer'.$id_customer);
        error_log('id model;'.$id_model);
        $this->load->model('Model_costing'); // pastikan nama model sesuai
        $data['quotation_detail'] = $this->Model_costing->getCostingByCustomerAndModel($id_customer, $id_model);
        $data['costing'] =$this->Model_costing->selectById($id_customer);
        error_log('Isi costing dedi: ' . print_r($data['costing'], true));
        $this->load->view('proforma_quotation/search_result', $data);
    }


    public function getCostingData($customerid, $modelid) {
        // Load model jika belum di-load
        $this->load->model('model_costing');
        
        // Ambil data costing berdasarkan customer dan model
        $costing = $this->model_proformaquotation->getCostingByCustomerAndModel($customerid, $modelid);
        
        if ($costing) {
            // Jika data ditemukan, kirim response sukses dengan data
            echo json_encode([
                'success' => true,
                'data' => $costing
            ]);
        } else {
            // Jika tidak ada data, kirim response error
            echo json_encode([
                'success' => false,
                'message' => 'No costing data found for this model and customer'
            ]);
        }
    }

    public function create_proforma_detail() {
        // Ambil input JSON
        $json_data = json_decode(file_get_contents('php://input'), true);
    
        if ($json_data) {
            $proforma_quotation_id   = isset($json_data['proforma_quotation_id']) ? $json_data['proforma_quotation_id'] : 0;
            $ebako_code              = isset($json_data['ebako_code']) ? $json_data['ebako_code'] : '';
            $model_id                = isset($json_data['model_id']) ? $json_data['model_id'] : 0;
            $customer_code           = isset($json_data['customer_code']) ? $json_data['customer_code'] : '';
            $product_price_id        = isset($json_data['product_price_id']) ? $json_data['product_price_id'] : 0;
            $quotation_detail_id     = isset($json_data['quotation_detail_id']) ? $json_data['quotation_detail_id'] : 0;
            $fob_quotation           = isset($json_data['fob_quotation']) ? $json_data['fob_quotation'] : 0;
            $fob_product_price       = isset($json_data['fob_product_price']) ? $json_data['fob_product_price'] : 0;
            $fob_costing             = isset($json_data['fob_costing']) ? $json_data['fob_costing'] : 0;
            $remark                  = isset($json_data['remark']) ? $json_data['remark'] : '';
              $type                  = isset($json_data['type']) ? $json_data['type'] : '';
            
        } else {
            echo json_encode(['success' => false, 'msg' => 'Invalid input data']);
            return;
        }
    
        // Validasi minimal
        if (empty($proforma_quotation_id)) {
            echo json_encode(['success' => false, 'msg' => 'Missing proforma_quotation_id']);
            return;
        }
    
        // Data yang akan disimpan
        $data = array(
            'proforma_quotation_id'  => $proforma_quotation_id,
            'ebako_code'             => $ebako_code,
            'model_id'               => $model_id,
            'customer_code'          => $customer_code,
            'product_price_id'       => $product_price_id,
            'quotation_detail_id'    => $quotation_detail_id,
            'fob_quotation'          => $fob_quotation,
            'fob_product_price'      => $fob_product_price,
            'fob_costing'            => $fob_costing,
            'remark'                 => $remark,
            'type'                   => $type,  
            'created_by'             => $this->session->userdata('id'),
            'created_at'             => date('Y-m-d H:i:s'),
            'updated_by'             => '',
            'updated_at'             => null
        );
    
        error_log('Data yang akan disimpan ke proforma_quotation_detail: ' . json_encode($data));
    
        $insert = $this->model_proformaquotation->insertDetail($data);
    
        if ($insert) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Gagal menyimpan data']);
        }
    }

    function edit_detail($id) {
        $data['detail'] = $this->model_proformaquotation->selectDetailById($id);
        $this->load->view('proforma_quotation/edit_detail', $data);
    }

    function edit_detail_from_product_price($id) {
        $data['detail'] = $this->model_proformaquotation->selectDetailById($id);
        $this->load->view('proforma_quotation/edit_detail_product_price', $data);
    }

    public function update_detail() {
        // Ambil input JSON
        $json_data = json_decode(file_get_contents('php://input'), true);
        
        if (!$json_data || !isset($json_data['id'])) {
            echo json_encode(['success' => false, 'msg' => 'Invalid input data']);
            return;
        }
        
        $id = $json_data['id'];
        
        // Data yang akan diupdate
        $data = array(
            'ebako_code'             => isset($json_data['ebako_code']) ? $json_data['ebako_code'] : '',
            'model_id'               => isset($json_data['model_id']) ? $json_data['model_id'] : 0,
            'customer_code'          => isset($json_data['customer_code']) ? $json_data['customer_code'] : '',
            'product_price_id'       => isset($json_data['product_price_id']) ? $json_data['product_price_id'] : 0,
            'quotation_detail_id'    => isset($json_data['quotation_detail_id']) ? $json_data['quotation_detail_id'] : 0,
            'fob_quotation'          => isset($json_data['fob_quotation']) ? $json_data['fob_quotation'] : 0,
            'fob_product_price'      => isset($json_data['fob_product_price']) ? $json_data['fob_product_price'] : 0,
            'fob_costing'            => isset($json_data['fob_costing']) ? $json_data['fob_costing'] : 0,
            'remark'                 => isset($json_data['remark']) ? $json_data['remark'] : '',
            'type'                 => isset($json_data['type']) ? $json_data['type'] : '',
            'updated_by'             => $this->session->userdata('id'),
            'updated_at'             => date('Y-m-d H:i:s')
        );
        
        $update = $this->model_proformaquotation->updateDetail($data, $id);
        
        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Gagal memperbarui data']);
        }
    }
    
    /**
     * Delete detail by ID
     */
    public function delete_detail($id) {
        $delete = $this->model_proformaquotation->deleteDetail($id);
        
        if ($delete) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Gagal menghapus data']);
        }
    }

    public function print_detail($id) {
        $data['proforma_quotation'] = $this->model_proformaquotation->selectById($id);
        $data['proforma_quotation_detail'] = $this->model_proformaquotation->selectDetailByProformaQuotationId($id);
      
        // Load view khusus untuk mencetak
        $this->load->view('proforma_quotation/print_detail', $data);
    }
    
    
}