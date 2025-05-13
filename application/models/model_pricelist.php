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
        
        // If you're filtering by model, you need to join with price_list_detail table
        // and then join with the model table
        if (!empty($model_name)) {
            $this->db->join('price_list_detail', 'price_list.id = price_list_detail.price_list_id', 'left');
            $this->db->join('model', 'price_list_detail.model_id = model.id', 'left');
            $this->db->like('model.no', $model_name);
        }
    
        // Menambahkan filter jika ada
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
            $this->db->select('price_list.*, customer.name AS customer_name');
            $this->db->from('price_list');
            $this->db->join('customer', 'price_list.customer_id = customer.id', 'left');
            
            // Join with price_list_detail and model tables only if model filtering is needed
            if (!empty($model_name)) {
                $this->db->join('price_list_detail', 'price_list.id = price_list_detail.price_list_id', 'left');
                $this->db->join('model', 'price_list_detail.model_id = model.id', 'left');
                $this->db->select('model.no AS model_no, model.description AS model_description');
                $this->db->like('model.no', $model_name);
                // Using group_by to avoid duplicate price_list records when joining with details
                $this->db->group_by('price_list.id, customer.name, model.no, model.description');
            }
            
            // Filter pencarian
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
            log_message('error', 'Error in search function: ' . $e->getMessage());
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
        $this->db->select('price_list_detail.*, 
                        customer.name AS customer_name, 
                        model.no AS model_no, 
                        model.description AS model_description');
        $this->db->from('price_list_detail');
        $this->db->join('customer', 'price_list_detail.customer_id = customer.id', 'left');
        $this->db->join('model', 'price_list_detail.model_id = model.id', 'left');
        $this->db->where('price_list_detail.price_list_id', $id); // diperbaiki di sini
        
        $query = $this->db->get();

        if ($query === false) {
            return null;
        }

        if ($query->num_rows() > 0) {
            return $query->result(); // karena bisa banyak detail untuk satu price_list_id
        } else {
            return null;
        }
    }
    function selectById_detail($id) {
        $this->db->select('price_list_detail.*, 
                        customer.name AS customer_name, 
                        model.no AS model_no, 
                        model.description AS model_description');
        $this->db->from('price_list_detail');
        $this->db->join('customer', 'price_list_detail.customer_id = customer.id', 'left');
        $this->db->join('model', 'price_list_detail.model_id = model.id', 'left');
        $this->db->where('price_list_detail.id', $id);
        
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
        $this->db->delete('price_list_detail');
    }

    public function getPriceListByIds($ids) {
        $this->db->select('price_list_detail.*, model.no as model_no, customer.name as customer_name');
        $this->db->from('price_list_detail');
        $this->db->join('model', 'model.id = price_list_detail.model_id', 'left');
        $this->db->join('customer', 'customer.id = price_list_detail.customer_id', 'left');
        $this->db->where_in('price_list_detail.id', $ids);
        $this->db->order_by('price_list_detail.id', 'ASC');
        
        $query = $this->db->get();
    
        if (!$query) {
            // Debug error SQL
            $error = $this->db->error(); // array: ['code' => xxx, 'message' => '...']
            log_message('error', 'DB Error: ' . print_r($error, true));
            return []; // atau false, sesuai kebutuhan
        }
    
        return $query->result();
    }

    // public function selectById($id) {
    //     $query = "SELECT pl.*, c.name as customer_name
    //               FROM price_list pl
    //               LEFT JOIN customer c ON pl.customer_id = c.id
    //               WHERE pl.id = $id";
        
    //     return $this->db->query($query)->row();
    // }
    

    public function getDetailByPriceListId($price_list_id) {
        $this->db->select('pld.*, m.name as model_name, m.model_no, c.name as customer_name');
        $this->db->from('price_list_detail AS pld');
        $this->db->join('model AS m', 'm.id = pld.model_id', 'left');
        $this->db->join('customer AS c', 'c.id = pld.customer_id', 'left');
        $this->db->where('pld.price_list_id', $price_list_id);
        
        $query = $this->db->get();
    
        if (!$query) {
            // Debug error
            
            
            return null;
        }
    
        return $query->result();
    }
    

    function search_detail($model_name = '', $customer_name = '', $customer_id = 0, $price_list_id = null, $limit, $offset) {
        error_log("wilo".$price_list_id);
    try {
        $this->db->select('price_list_detail.*, customer.name AS customer_name, model.no AS model_no, model.description AS model_description');
        $this->db->from('price_list_detail');
        $this->db->join('customer', 'price_list_detail.customer_id = customer.id', 'left');
        $this->db->join('model', 'price_list_detail.model_id = model.id', 'left');

        if (!empty($model_name)) {
            $this->db->like('model.no', $model_name);
        }
        if (!empty($customer_name)) {
            $this->db->like('customer.name', $customer_name);
        }
        if (!empty($customer_id) && $customer_id != 0) {
            $this->db->where('price_list_detail.customer_id', $customer_id);
        }
        if (!empty($price_list_id)) {
            $this->db->where('price_list_detail.price_list_id', $price_list_id); // <-- tambahkan filter ini
        }

        $this->db->limit($limit, $offset);
        $this->db->order_by('price_list_detail.updated_at', 'DESC');

        $query = $this->db->get();
        return $query ? $query->result() : [];
    } catch (Exception $e) {
        return [];
    }
}

    
   function getNumRows_detail($model_name = '', $customer_name = '', $customer_id = 0, $price_list_id = null) {
    error_log("wilo".$price_list_id);
    $this->db->select('COUNT(*) as total');
    $this->db->from('price_list_detail');
    $this->db->join('customer', 'price_list_detail.customer_id = customer.id', 'left');
    $this->db->join('model', 'price_list_detail.model_id = model.id', 'left');

    if (!empty($model_name)) {
        $this->db->like('model.name', $model_name);
    }
    if (!empty($customer_name)) {
        $this->db->like('customer.name', $customer_name);
    }
    if (!empty($customer_id) && $customer_id != 0) {
        $this->db->where('price_list_detail.customer_id', $customer_id);
    }
    if (!empty($price_list_id)) {
        $this->db->where('price_list_detail.price_list_id', $price_list_id); // <-- tambah juga di sini
    }

    $query = $this->db->get();
    return $query ? $query->row()->total : 0;
}

}