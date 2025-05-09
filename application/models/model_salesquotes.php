<?php

class model_salesquotes extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Insert sales quotes
     * 
     * @param array $data Data untuk insert
     * @return int ID dari sales quotes yang dibuat
     */
    public function insert($data) {
        return $this->db->insert('sales_quotes', $data);
    }
    
    /**
     * Insert sales quotes detail
     * 
     * @param array $data Data untuk insert
     * @return bool Status keberhasilan insert
     */
    public function insertDetail($data) {
        return $this->db->insert('sales_quotes_detail', $data);
    }
    
    /**
     * Ambil sales quotes berdasarkan ID
     * 
     * @param int $id ID sales quotes
     * @return object Data sales quotes
     */
    public function selectById($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('sales_quotes');
        return $query->row();
    }
    
    /**
     * Ambil sales quotes detail berdasarkan sales_quotes_id
     * 
     * @param int $sales_quotes_id ID sales quotes
     * @return array Data sales quotes detail
     */
    public function selectDetailBySalesQuotesId($sales_quotes_id) {
        $this->db->where('sales_quotes_id', $sales_quotes_id);
        $query = $this->db->get('sales_quotes_detail');
        return $query->result();
    }
    
    /**
     * Update sales quotes
     * 
     * @param array $data Data untuk update
     * @param int $id ID sales quotes
     * @return bool Status update
     */
    public function update($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('sales_quotes', $data);
    }
    
    /**
     * Update sales quotes detail
     * 
     * @param array $data Data untuk update
     * @param int $id ID sales quotes detail
     * @return bool Status update
     */
    public function updateDetail($data, $id) {
        $this->db->where('id', $id);
        return $this->db->update('sales_quotes_detail', $data);
    }
    
    /**
     * Delete sales quotes
     * 
     * @param int $id ID sales quotes
     * @return bool Status delete
     */
    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('sales_quotes');
    }
    
    /**
     * Delete sales quotes detail
     * 
     * @param int $id ID sales quotes detail
     * @return bool Status delete
     */
    public function deleteDetail($id) {
        $this->db->where('id', $id);
        return $this->db->delete('sales_quotes_detail');
    }
    
    /**
     * Cek apakah quotation number sudah ada
     * 
     * @param string $quotation_number Nomor quotation
     * @return bool TRUE jika sudah ada, FALSE jika belum
     */
    public function isQuotationNumberExists($quotation_number) {
        $this->db->where('quotation_number', $quotation_number);
        $query = $this->db->get('sales_quotes');
        return ($query->num_rows() > 0);
    }
}