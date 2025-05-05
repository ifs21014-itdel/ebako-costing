<?php
/**
 * Model for Proforma Quotation
 */
class model_proformaquotation extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get number of rows for pagination
     */
    public function getNumRows($model = '', $customer = '', $customerid = 0) {
        $query = "SELECT COUNT(*) as numrows FROM proforma_quotation pq
                  LEFT JOIN customer c ON pq.customer_id = c.id
                  WHERE 1=1";
    
        if ($model != '') {
            $query .= " AND (EXISTS (SELECT 1 FROM proforma_quotation_detail pqd 
                      JOIN model m ON pqd.model_id = m.id 
                      WHERE pqd.proforma_quotation_id = pq.id 
                      AND m.name LIKE '%$model%'))";
        }
    
        if ($customer != '') {
            $query .= " AND c.name LIKE '%$customer%'";
        }
    
        if ($customerid > 0) {
            $query .= " AND pq.customer_id = $customerid";
        }
    
        $result = $this->db->query($query);
    
        // Periksa apakah query berhasil
        if ($result && $result->num_rows() > 0) {
            return $result->row()->numrows;
        } else {
            // Jika query gagal atau tidak ada data
            return 0;
        }
    }
    
    
    /**
     * Search proforma quotations
     */
    public function search($model = '', $customer = '', $customerid = 0, $limit = 10, $offset = 0) {
        // Mulai dengan query dasar
        $query = "SELECT pq.*, c.name as customer_name
                  FROM proforma_quotation pq
                  LEFT JOIN customer c ON pq.customer_id = c.id
                  WHERE 1=1";
    
        // Parameter binding untuk keamanan
        $params = [];
    
        // Filter berdasarkan model jika diberikan
        if ($model != '') {
            $query .= " AND EXISTS (
                            SELECT 1 
                            FROM proforma_quotation_detail pqd 
                            JOIN model m ON pqd.model_id = m.id 
                            WHERE pqd.proforma_quotation_id = pq.id 
                            AND m.name LIKE ?
                        )";
            $params[] = "%$model%"; // Menambahkan parameter untuk model
        }
    
        // Filter berdasarkan customer jika diberikan
        if ($customer != '') {
            $query .= " AND c.name LIKE ?";
            $params[] = "%$customer%"; // Menambahkan parameter untuk customer
        }
    
        // Filter berdasarkan customer_id jika diberikan
        if ($customerid > 0) {
            $query .= " AND pq.customer_id = ?";
            $params[] = $customerid; // Menambahkan parameter untuk customerid
        }
    
        // Menambahkan order by dan limit offset
        $query .= " ORDER BY pq.date DESC, pq.id DESC LIMIT ? OFFSET ?";
        $params[] = $limit;  // Menambahkan parameter untuk limit
        $params[] = $offset; // Menambahkan parameter untuk offset
    
        // Debugging output query
        // echo $this->db->get_compiled_select(); // Debugging untuk melihat query yang dihasilkan
    
        // Eksekusi query dengan parameter binding
        $result = $this->db->query($query, $params);
    
        // Memeriksa apakah query berhasil dijalankan
        if ($result) {
            return $result->result(); // Jika berhasil, kembalikan hasilnya
        } else {
            // Jika query gagal, tampilkan pesan kesalahan
            // echo "Query error: " . $this->db->error(); // Menampilkan pesan error database
            return [];
        }
    }
    
    
    /**
     * Select proforma quotation by ID
     */
    public function selectById($id) {
        $query = "SELECT pq.*, c.name as customer_name
                  FROM proforma_quotation pq
                  LEFT JOIN customer c ON pq.customer_id = c.id
                  WHERE pq.id = $id";
        
        return $this->db->query($query)->row();
    }
    
    /**
     * Select detail by proforma quotation ID
     */
    public function selectDetailByProformaQuotationId($proforma_quotation_id) {
        // Gunakan parameter binding untuk mencegah SQL Injection
        $query = "
            SELECT 
                pqd.*, 
                c.name AS customer_name -- Ambil nama customer dari tabel customer
            FROM proforma_quotation_detail pqd
            LEFT JOIN proforma_quotation pq ON pqd.proforma_quotation_id = pq.id
            LEFT JOIN customer c ON pq.customer_id = c.id -- JOIN dengan tabel customer berdasarkan customer_id
            WHERE pqd.proforma_quotation_id = ?
        ";
    
        $result = $this->db->query($query, [$proforma_quotation_id]);
    
        if ($result) {
            $data = $result->result();
    
            // Debug isi hasil detail
            log_message('debug', 'Hasil selectDetailByProformaQuotationId: ' . print_r($data, true));
    
            return $data;
        } else {
            log_message('error', 'Query selectDetailByProformaQuotationId gagal: ' . $this->db->last_query());
            return false;
        }
    }
    
    
    

    function insert($data) {
        return $this->db->insert('proforma_quotation', $data);
    }
    
    /**
     * Insert detail of proforma quotation
     */
    public function insertDetail($data) {
        return $this->db->insert('proforma_quotation_detail', $data);
    }
    
    /**
     * Update proforma quotation
     */
    public function update($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('proforma_quotation', $data);
    }
    
    /**
     * Delete proforma quotation
     */
    public function delete($id) {
        // Detail akan terhapus secara otomatis karena CASCADE
        $this->db->where('id', $id);
        return $this->db->delete('proforma_quotation');
    }
    
    /**
     * Delete detail by proforma quotation ID
     */
    public function deleteDetailByProformaQuotationId($proforma_quotation_id) {
        $this->db->where('proforma_quotation_id', $proforma_quotation_id);
        return $this->db->delete('proforma_quotation_detail');
    }


    public function getNumRowsDetail($proforma_quotation_id, $ebako_code = '', $customer_code = '') {
        $query = "SELECT COUNT(*) as numrows FROM proforma_quotation_detail pqd
                  WHERE pqd.proforma_quotation_id = ?";
        
        $params = [$proforma_quotation_id];
        
        if ($ebako_code != '') {
            $query .= " AND pqd.ebako_code LIKE ?";
            $params[] = "%$ebako_code%";
        }
        
        if ($customer_code != '') {
            $query .= " AND pqd.customer_code LIKE ?";
            $params[] = "%$customer_code%";
        }
        
        $result = $this->db->query($query, $params);
        
        if ($result && $result->num_rows() > 0) {
            return $result->row()->numrows;
        } else {
            return 0;
        }
    }
    
    /**
     * Search detail with filters and pagination
     */
    public function searchDetail($proforma_quotation_id, $ebako_code = '', $customer_code = '', $limit = 10, $offset = 0) {
        $query = "SELECT pqd.*, pq.customer_id, c.name AS customer_name
                  FROM proforma_quotation_detail pqd
                  LEFT JOIN proforma_quotation pq ON pqd.proforma_quotation_id = pq.id
                  LEFT JOIN customer c ON pq.customer_id = c.id
                  WHERE pqd.proforma_quotation_id = ?";
        
        $params = [$proforma_quotation_id];
        
        if ($ebako_code != '') {
            $query .= " AND pqd.ebako_code LIKE ?";
            $params[] = "%$ebako_code%";
        }
        
        if ($customer_code != '') {
            $query .= " AND pqd.customer_code LIKE ?";
            $params[] = "%$customer_code%";
        }
        
        $query .= " ORDER BY pqd.id ASC LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        
        $result = $this->db->query($query, $params);
        
        if ($result) {
            return $result->result();
        } else {
            return [];
        }
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

    public function selectCostingById($id)
{
    $this->db->select('
        costing.*,
        customer.name AS customer_name,
        model.no AS model_no,
        model.description AS model_description
    ');
    $this->db->from('costing');
    $this->db->join('customer', 'costing.customerid = customer.id', 'left');
    $this->db->join('model', 'costing.modelid = model.id', 'left');
    $this->db->where('costing.id', $id);

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


public function getCostingByCustomerAndModel($customerid, $modelid) {
    $this->db->select('*');
    $this->db->from('costing');
    $this->db->where('customerid', $customerid);
    $this->db->where('modelid', $modelid);
    $this->db->order_by('date', 'DESC'); // Ambil yang paling baru
    $this->db->limit(1);
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row();
    }
    
    return null;
}

/**
 * Select detail by ID
 */
public function selectDetailById($id) {
    $this->db->select('pqd.*, pq.customer_id, c.name AS customer_name');
    $this->db->from('proforma_quotation_detail pqd');
    $this->db->join('proforma_quotation pq', 'pqd.proforma_quotation_id = pq.id', 'left');
    $this->db->join('customer c', 'pq.customer_id = c.id', 'left');
    $this->db->where('pqd.id', $id);
    
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->row();
    }
    
    return null;
}

/**
 * Update detail
 */
public function updateDetail($data, $id) {
    $this->db->where('id', $id);
    return $this->db->update('proforma_quotation_detail', $data);
}

/**
 * Delete detail by ID
 */
public function deleteDetail($id) {
    $this->db->where('id', $id);
    return $this->db->delete('proforma_quotation_detail');
}


}