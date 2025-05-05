<?php

/**
 * Model for Price List
 */
class model_pricelist extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    function getNumRows($model_name = '', $customer_name = '', $customer_id = 0) {
        $this->db->select('COUNT(*) as total');
        $this->db->from('price_list');
        $this->db->join('customer', 'price_list.customer_id = customer.id', 'left');
        $this->db->join('model', 'price_list.model_id = model.id', 'left');
    
        // Menambahkan filter jika ada
        if (!empty($model_name)) {
            $this->db->like('model.name', $model_name);
        }
        if (!empty($customer_name)) {
            $this->db->like('customer.name', $customer_name);
        }
        if (!empty($customer_id) && $customer_id != 0) {
            $this->db->where('price_list.customer_id', $customer_id);
        }
        
        $query = $this->db->get();
    
        // Debugging untuk melihat hasil query
        if (!$query) {
            log_message('error', 'Query Failed: ' . $this->db->last_query());
            return 0;
        }
    
        return $query->row()->total;
    }
    
    function search($model_name = '', $customer_name = '', $customer_id = 0, $limit, $offset) {
        try {
            $this->db->select('price_list.*, customer.name AS customer_name, model.no AS model_no, model.description AS model_description');
            $this->db->from('price_list');
            $this->db->join('customer', 'price_list.customer_id = customer.id', 'left');
            $this->db->join('model', 'price_list.model_id = model.id', 'left');
            
            // Filter pencarian
            if (!empty($model_name)) {
                $this->db->like('model.no', $model_name); // ganti model.name jadi model.no
            }
            if (!empty($customer_name)) {
                $this->db->like('customer.name', $customer_name);
            }
            if (!empty($customer_id) && $customer_id != 0) {
                $this->db->where('price_list.customer_id', $customer_id);
            }
        
            // Limit dan offset untuk pagination
            $this->db->limit($limit, $offset);
            $this->db->order_by('price_list.updated_at', 'DESC');
        
            $query = $this->db->get();
            
            if ($query === FALSE) {
                return array();
            }
            
            return $query->result();
        } catch (Exception $e) {
            return array();
        }
    }
    
    
   /**
 * Select price list by ID with additional user information
 */
/**
 * Select price list by ID with additional user information
 */
function selectById($id) {
    $this->db->select('price_list.*, 
                     customer.name AS customer_name, 
                     model.no AS model_no, 
                     model.description AS model_description');
    $this->db->from('price_list');
    $this->db->join('customer', 'price_list.customer_id = customer.id', 'left');
    $this->db->join('model', 'price_list.model_id = model.id', 'left');
    $this->db->where('price_list.id', $id);
    
    $query = $this->db->get();

    if ($query === false) {
        return null;
    }

    if ($query->num_rows() > 0) {
        return $query->row();
    } else {
        return null;
    }
}


    
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('price_list');
    }

    public function getPriceListByIds($ids) {
        $this->db->select('price_list.*, model.no as model_no, customer.name as customer_name');
        $this->db->from('price_list');
        $this->db->join('model', 'model.id = price_list.model_id', 'left');
        $this->db->join('customer', 'customer.id = price_list.customer_id', 'left');
        $this->db->where_in('price_list.id', $ids);
        $this->db->order_by('price_list.id', 'ASC');
        
        $query = $this->db->get();
    
        if (!$query) {
            // Debug error SQL
            $error = $this->db->error(); // array: ['code' => xxx, 'message' => '...']
            log_message('error', 'DB Error: ' . print_r($error, true));
            return []; // atau false, sesuai kebutuhan
        }
    
        return $query->result();
    }

}