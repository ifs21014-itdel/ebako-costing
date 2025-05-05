<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_quotation
 *
 * @author hp
 */
class model_productprice extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function insert($data) {
        return $this->db->insert('product_price', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('product_price', $data);
    }
    
    public function delete($id)
{
    $this->db->where('id', $id);
    return $this->db->delete('product_price');
}

    // Di dalam file product_price_model.php

    function getNumRows($ebako_code = '', $customer_code = '', $quotation_date_start = '', $quotation_date_end = '', $customerid = 0) {
        $this->db->select('COUNT(*) as total');
        $this->db->from('product_price');
        $this->db->join('customer', 'product_price.customer_id = customer.id', 'left');  // Tambahkan JOIN customer
    
        // Menambahkan filter jika ada
        if (!empty($ebako_code)) {
            $this->db->like('product_price.ebako_code', $ebako_code);
        }
        if (!empty($customer_code)) {
            $this->db->like('customer.name', $customer_code);  // Ubah dari customer_id menjadi customer.name
        }
        if (!empty($quotation_date_start)) {
            $this->db->where('product_price.quotation_date >=', $quotation_date_start);
        }
        if (!empty($quotation_date_end)) {
            $this->db->where('product_price.quotation_date <=', $quotation_date_end);
        }
        if (!empty($customerid) && $customerid != 0) {
            $this->db->where('product_price.customer_id', $customerid);  // Ubah customer_code menjadi customer_id
        }
        
        $query = $this->db->get();
    
        // Debugging untuk melihat hasil query
        if (!$query) {
            // Jika query gagal, tampilkan error
            log_message('error', 'Query Failed: ' . $this->db->last_query());
            return 0;
        }
    
        return $query->row()->total;
    }
    
    
    function search($ebako_code = '', $customer_name = '', $quotation_date_start = '', $quotation_date_end = '', $customerid = 0, $limit, $offset) {
        $this->db->select('product_price.*, customer.name AS customer_name');
        $this->db->from('product_price');
        $this->db->join('customer', 'product_price.customer_id = customer.id', 'left');
    
        // Filter pencarian
        if (!empty($ebako_code)) {
            $this->db->like('product_price.ebako_code', $ebako_code);
        }
        if (!empty($customer_name)) {
            $this->db->like('product_price.customercode', $customer_name);
        }
        if (!empty($quotation_date_start)) {
            $this->db->where('product_price.quotation_date >=', $quotation_date_start);
        }
        if (!empty($quotation_date_end)) {
            $this->db->where('product_price.quotation_date <=', $quotation_date_end);
        }
        if (!empty($customerid) && $customerid != 0) {
            $this->db->where('product_price.customer_id', $customerid);
        }
    
        // Limit dan offset untuk pagination
        $this->db->limit($limit, $offset);
        $this->db->order_by('product_price.quotation_date', 'DESC');
    
        $query = $this->db->get();
        return $query->result();
    }
    

    function selectById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('product_price');
        return $query->row();
    }

    public function getLatestSalesQuotationByCustomerAndModel($customerId, $modelId)
    {
        $query = "
            SELECT s.*
            FROM sales_quotes_detail s
            JOIN costing c ON s.costingid = c.id
            WHERE c.customerid = $customerId
              AND c.modelid = $modelId
            ORDER BY c.date DESC
            LIMIT 1
        ";
    
        $result = $this->db->query($query);
    
        if ($result) {
            return $result->row(); // atau ->result() jika lebih dari satu
        }
    
        return []; // atau return null;
    }

    public function getLatestSalesQuotationByCustomer($customerId)
    {
        $query = "
            SELECT *
            FROM sales_quotes
            WHERE customer_id = ?
            LIMIT 1
        ";

        $result = $this->db->query($query, [9]);

        if ($result && $result->num_rows() > 0) {
            return $result->row(); // Ambil data terbaru berdasarkan customer
        }

        return null;
    }

    
    public function getSalesQuoteDetailById($id) {
        $query = $this->db->query("SELECT * FROM sales_quotes_detail WHERE id = $id");
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null;
    }

    // Di model_productprice.php
    public function getAllProductPrices()
    {
        $query = "
            SELECT 
                pp.id,
                pp.ebako_code,
                pp.customer_id,
                pp.quotation_id,
                pp.material,
                pp.quotation_date,
                pp.approval_date,
                pp.cw,
                pp.cd,
                pp.ch,
                pp.q_finished,
                pp.fob,
                pp.customercode,
                pp.description,
                c.name AS customer_name
            FROM product_price pp
            LEFT JOIN customer c ON pp.customer_id = c.id
            ORDER BY pp.quotation_date DESC
        ";
        
        $result = $this->db->query($query);
        
        if ($result && $result->num_rows() > 0) {
            return $result->result();
        }
        
        return [];
    }

    public function getAllProductPrices_2()
    {
        $query = "
            SELECT 
                pp.id,
                pp.ebako_code,
                pp.customer_id,
                pp.quotation_id,
                pp.material,
                pp.quotation_date,
                pp.approval_date,
                pp.cw,
                pp.cd,
                pp.ch,
                pp.q_finished,
                pp.fob,
                pp.customercode,
                pp.description,
                c.name AS customer_name
            FROM product_price pp
            LEFT JOIN customer c ON pp.customer_id = c.id
            ORDER BY pp.quotation_date DESC
        ";
        
        $result = $this->db->query($query);
        
        if ($result && $result->num_rows() > 0) {
            return $result->result();
        }
        
        return [];
    }
    

public function searchSalesQuotationByFilters($customer_id, $model_id, $price_from = null, $price_to = null, $date_from = null, $date_to = null)
{
    $query = "
        SELECT sq.*, sqd.model_code, sqd.description, sqd.fob_price, sqd.currency, m.no
        FROM sales_quotes sq
        JOIN sales_quotes_detail sqd ON sq.id = sqd.sales_quotes_id
        JOIN model m ON sqd.model_id = m.id
        WHERE sq.customer_id = ? AND sqd.model_id = ?
    ";
    
    $params = [$customer_id, $model_id];
    
    if ($price_from && $price_from != '') {
        $query .= " AND sqd.fob_price >= ?";
        $params[] = $price_from;
    }
    
    if ($price_to && $price_to != '') {
        $query .= " AND sqd.fob_price <= ?";
        $params[] = $price_to;
    }
    
    if ($date_from && $date_from != '') {
        $query .= " AND sq.date >= ?";
        $params[] = $date_from;
    }
    
    if ($date_to && $date_to != '') {
        $query .= " AND sq.date <= ?";
        $params[] = $date_to;
    }
    
    $query .= " ORDER BY sq.date DESC";
    
    $result = $this->db->query($query, $params);
    
    if ($result && $result->num_rows() > 0) {
        return $result->result();
    }
    
    return [];
}

    
public function searchProductPrices($model_code = null, $price_from = null, $price_to = null, $date_from = null, $date_to = null)
{
    $query = "
        SELECT *
        FROM product_price
        WHERE 1=1
    ";
    
    $params = [];
    
    if ($model_code && $model_code != '') {
        $query .= " AND (ebako_code ILIKE ? OR customercode ILIKE ?)";
        $params[] = "%$model_code%";
        $params[] = "%$model_code%";
    }
    
    if ($price_from && $price_from != '') {
        $query .= " AND fob >= ?";
        $params[] = $price_from;
    }
    
    if ($price_to && $price_to != '') {
        $query .= " AND fob <= ?";
        $params[] = $price_to;
    }
    
    if ($date_from && $date_from != '') {
        $query .= " AND quotation_date >= ?";
        $params[] = $date_from;
    }
    
    if ($date_to && $date_to != '') {
        $query .= " AND quotation_date <= ?";
        $params[] = $date_to;
    }
    
    $query .= " ORDER BY quotation_date DESC";
    
    $result = $this->db->query($query, $params);
    
    if ($result && $result->num_rows() > 0) {
        return $result->result();
    }
    
    return [];
}




    
}

?>
