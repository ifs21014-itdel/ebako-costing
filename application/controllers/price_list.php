<?php

/**
 * Price List Controller
 * 
 * Controller for managing price lists
 * 
 * @author admin
 */
class price_list extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('id')) {
            redirect('login');
        }
        $this->load->model('model_model');
        $this->load->model('model_rfqdetail');
        $this->load->model('model_user');
        $this->load->model('model_rate');
        $this->load->model('model_customer');
        $this->load->model('model_costing');
        $this->load->model('model_pricelist'); // Load price list model
    }

    /**
     * Main index page
     */
    public function index() {
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "price_list"));
        $data['customer'] = $this->model_customer->selectAll();
        
        // Load default data with pagination
        $offset = 0;
        $limit = $this->config->item('limit');
        $data['num_rows'] = $this->model_pricelist->getNumRows('', '', 0);
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['first'] = 0;
        $data['offset'] = $offset;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        $data['price_list'] = $this->model_pricelist->search('', '', 0, $limit, $offset);
        
        $this->load->view('price_list/view', $data);
    }
    
    /**
     * Search price lists
     */
    public function search() {
        $model_name = $this->input->post('model_name');
        $customer_name = $this->input->post('customer_name');
        $customerid = $this->input->post('customerid');
        $offset = $this->input->post('offset');
        
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "price_list"));
        
        $limit = $this->config->item('limit');
        $data['num_rows'] = $this->model_pricelist->getNumRows($model_name, $customer_name, $customerid);
        $data['num_page'] = (int) ceil($data['num_rows'] / $limit);
        $data['first'] = 0;
        $data['offset'] = $offset;
        $data['prev'] = (($offset - $limit) < 0) ? 0 : ($offset - $limit);
        $data['next'] = (($offset + $limit) > $data['num_rows']) ? $offset : ($offset + $limit);
        $data['last'] = ($data['num_page'] * $limit) > $data['num_rows'] ? (($data['num_page'] - 1) * $limit) : ($data['num_page'] * $limit);
        $data['page'] = (int) ceil($offset / $limit) + 1;
        $data['price_list'] = $this->model_pricelist->search($model_name, $customer_name, $customerid, $limit, $offset);
        
        $this->load->view('price_list/search', $data);
    }

    public function detail($id) {
        $data['price_list'] = $this->model_pricelist->selectById($id);
        error_log('Isi detail price_list: ' . print_r($data['price_list'], true));
        // Tambahkan accessmenu untuk tombol
        $data['accessmenu'] = explode('|', $this->model_user->getAction($this->session->userdata('id'), "price_list"));
        
        // Jika data tidak ditemukan, berikan pesan
        if ($data['price_list'] === null) {
            $this->session->set_flashdata('error', 'Data price list tidak ditemukan');
        }
        
        $this->load->view('price_list/detail', $data);
    }
    
    /**
     * Show edit form
     * 
     * @param int $id Price list ID
     */
    public function edit($id) {
        $data['price_list'] = $this->model_pricelist->selectById($id);
        $data['customer'] = $this->model_customer->selectAll();
        $data['models'] = $this->model_model->selectAll();
        $this->load->view('price_list/edit', $data);
    }
    
    /**
     * Create new price list form
     */
    public function create() {
        $data['customer'] = $this->model_customer->selectAll();
        $data['models'] = $this->model_model->selectAll();
        $this->load->view('price_list/create', $data);
    }
    
    /**
     * Save new price list
     */
    public function save() {
        $data = array(
            'model_id' => $this->input->post('model_id'),
            'customer_id' => $this->input->post('customer_id'),
            'quantity' => $this->input->post('quantity'),
            'last_quotation_price' => $this->input->post('last_quotation_price'),
            'target_price' => $this->input->post('target_price'),
            'rate' => $this->input->post('rate'),
            'price_rate' => $this->input->post('price_rate'),
            'profit_percentage' => $this->input->post('profit_percentage'),
            'fixed_cost' => $this->input->post('fixed_cost'),
            'variable_cost' => $this->input->post('variable_cost'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('id')
        );
        
        $this->db->insert('price_list', $data);
        echo 'success';
    }
    
    /**
     * Update price list
     * 
     * @param int $id Price list ID
     */
    public function update($id) {
        $data = array(
            'model_id' => $this->input->post('model_id'),
            'customer_id' => $this->input->post('customer_id'),
            'quantity' => $this->input->post('quantity'),
            'last_quotation_price' => $this->input->post('last_quotation_price'),
            'target_price' => $this->input->post('target_price'),
            'rate' => $this->input->post('rate'),
            'price_rate' => $this->input->post('price_rate'),
            'profit_percentage' => $this->input->post('profit_percentage'),
            'fixed_cost' => $this->input->post('fixed_cost'),
            'variable_cost' => $this->input->post('variable_cost'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('id')
        );
        
        $this->db->where('id', $id);
        $this->db->update('price_list', $data);
        echo 'success';
    }

    /**
 * Update status price list
 * 
 * @param int $id Price list ID
 */
public function update_status($id) {
    error_log("dedi");
    // Periksa aksesibilitas
    $accessmenu = explode('|', $this->model_user->getAction($this->session->userdata('id'), "price_list"));
    if (!in_array('edit', $accessmenu)) {
        echo 'unauthorized';
        return;
    }
    
    $data = array(
        'status' => $this->input->post('status'),
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => $this->session->userdata('id')
    );
    
    try {
        $this->db->where('id', $id);
        $this->db->update('price_list', $data);
        echo 'success';
    } catch (Exception $e) {
        echo 'failed';
        log_message('error', 'Error updating price list status: ' . $e->getMessage());
    }
}
    
    /**
     * Delete price list
     * 
     * @param int $id Price list ID
     */
    public function delete($id) {
        try {
            $this->model_pricelist->delete($id);
            echo 'success';
        } catch (Exception $e) {
            echo 'failed';
            log_message('error', 'Error deleting price list: ' . $e->getMessage());
        }
    }

 
    public function print_price_list() {
        // Mendapatkan IDs yang dipilih dari parameter URL
        $selected_ids = $this->input->get('ids');
        $selected_columns = $this->input->get('columns');
        
        if (empty($selected_ids)) {
            echo "<script>alert('Tidak ada data yang dipilih'); window.close();</script>";
            return;
        }
        
        // Memecah string IDs menjadi array
        $ids = explode(',', $selected_ids);
        
        // Memecah string kolom menjadi array
        $columns = empty($selected_columns) ? [] : explode(',', $selected_columns);
        
        // Mengambil data price list berdasarkan IDs yang dipilih
        $data['price_list'] = $this->model_pricelist->getPriceListByIds($ids);
        $data['selected_columns'] = $columns;
        $data['user_name'] = $this->session->userdata('username');
        
        // Debug untuk melihat data yang dikirim ke view
        // error_log(print_r($data, true));
        
        $this->load->view('price_list/print', $data);
    }

    public function update_approval($id) {
        // Periksa aksesibilitas
        $accessmenu = explode('|', $this->model_user->getAction($this->session->userdata('id'), "price_list"));
        if (!in_array('edit', $accessmenu)) {
            echo 'unauthorized';
            return;
        }
        
        $data = array(
            'approval_date' => $this->input->post('approval_date'),
            'approval_price' => $this->input->post('approval_price'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('id')
        );
        
        try {
            $this->db->where('id', $id);
            $this->db->update('price_list', $data);
            echo 'success';
        } catch (Exception $e) {
            echo 'failed';
            log_message('error', 'Error updating price list approval: ' . $e->getMessage());
        }
    }


    
}