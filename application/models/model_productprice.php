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

    public function getProductPricesByCustomer($customer_id)
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
            WHERE pp.customer_id = ?
            ORDER BY pp.quotation_date DESC
        ";
    
        $result = $this->db->query($query, [$customer_id]);
    
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

/**
 * Mendapatkan daftar sales quotation yang telah disetujui
 * @param int $customer_id ID customer (opsional)
 * @return array Daftar quotation yang disetujui
 */
public function get_approved_quotations($customer_id = 0) {
    $this->db->select('sqd.id, sq.quotation_number, c.name as customer_name, m.no as model_code, 
                      m.description, m.custcode, sqd.fob_price, sq.quo_date, sqd.cw, sqd.cd, sqd.ch, 
                      m.id as model_id, sq.customer_id, sq.id as sales_quotes_id, sqd.q_finishes');
    $this->db->from('sales_quotes_detail sqd');
    $this->db->join('sales_quotes sq', 'sq.id = sqd.sales_quotes_id', 'left');
    $this->db->join('costing co', 'sqd.costingid = co.id', 'left');
    $this->db->join('model m', 'co.modelid = m.id', 'left');
    $this->db->join('customer c', 'sq.customer_id = c.id', 'left');
    
    // Subquery untuk mencocokkan id dari sales_quotes_detail yang sudah ada di product_price
    $this->db->where('NOT EXISTS (SELECT 1 FROM product_price pp WHERE pp.quotation_id = sqd.id)', NULL, FALSE);
    
    $this->db->where('sq.status', 'Approved');
    if ($customer_id && $customer_id != 0) {
        $this->db->where('sq.customer_id', $customer_id);
    }
    $this->db->order_by('sq.quo_date', 'DESC');
    $query = $this->db->get();
    if ($query === FALSE) {
        log_message('error', 'Database error: ' . $this->db->error()['message']);
        return array();
    }
    return $query->result();
}



/**
 * Mengimpor sales quotation detail yang dipilih ke dalam tabel product_price
 * @param array $quotation_detail_ids Array berisi ID dari sales_quotes_detail
 * @return bool True jika berhasil, False jika gagal
 */
public function import_quotations_to_product_price($quotation_detail_ids) {
    if (empty($quotation_detail_ids)) {
        return false;
    }

    $this->db->trans_start();

    foreach ($quotation_detail_ids as $id) {
        $this->db->select('sqd.*, sq.quotation_number, sq.customer_id, sq.quo_date, sq.approved_date,
                           m.no as model_no, m.custcode, m.description');
        $this->db->from('sales_quotes_detail sqd');
        $this->db->join('sales_quotes sq', 'sq.id = sqd.sales_quotes_id', 'left');
        $this->db->join('model m', 'sqd.costingid = m.id', 'left');
        $this->db->where('sqd.id', $id);
        $query = $this->db->get();

        if (!$query) {
            // Log error to error_log using _error_message() and _error_number()
            error_log('Query error (get quotation): ' . $this->db->_error_message() . ' | Error number: ' . $this->db->_error_number());
            continue;
        }

        $quotation = $query->row();

        if ($quotation) {
            // Check if model_no (ebako_code) is null and assign a default value if necessary
            $ebako_code = $quotation->model_no ? $quotation->model_no : '-';

            $data = [
                'ebako_code'    => $ebako_code,
                'customer_id'   => $quotation->customer_id,
                'quotation_id'  => $quotation->id,
                'material'      => $quotation->q_wood,
                'quotation_date'=> $quotation->quo_date,
                'approval_date' => $quotation->approved_date,
                'cw'            => $quotation->cw,
                'cd'            => $quotation->cd,
                'ch'            => $quotation->ch,
                'q_finished'    => $quotation->q_finishes,
                'fob'           => $quotation->fob_price,
                'customercode'  => $quotation->custcode,
                'description'   => $quotation->description
            ];

            $insert = $this->db->insert('product_price', $data);

            if (!$insert) {
                // Log insert error to error_log using _error_message() and _error_number()
                error_log('Insert error (product_price): ' . $this->db->_error_message() . ' | Error number: ' . $this->db->_error_number());
            }
        }
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === false) {
        // Log transaction failure to error_log
        error_log('Transaction failed during import_quotations_to_product_price.');
    }

    return $this->db->trans_status();
}






    
}

?>
