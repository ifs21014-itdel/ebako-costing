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
    
    /**
     * Mendapatkan model ID berdasarkan ebako_code (no di tabel model)
     * 
     * @param string $ebako_code Kode Ebako (nilai no di tabel model)
     * @return int|null ID model jika ditemukan, null jika tidak ditemukan
     */
    public function getModelIdByEbakoCode($ebako_code) {
        $this->db->select('id');
        $this->db->where('no', $ebako_code);
        $query = $this->db->get('model');
        
        if ($query->num_rows() > 0) {
            return $query->row()->id;
        }
        
        return null;
    }
    
    /**
     * Mendapatkan costing berdasarkan model_id
     * 
     * @param int $model_id ID model
     * @return object|null Data costing jika ditemukan, null jika tidak ditemukan
     */
    public function getCostingByModelId($model_id) {
        $this->db->where('modelid', $model_id);
        $this->db->order_by('date', 'DESC'); // Ambil costing terbaru
        $query = $this->db->get('costing');
        
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        
        return null;
    }
    
    /**
     * Mendapatkan costing berdasarkan ebako_code
     * 
     * @param string $ebako_code Kode Ebako (nilai no di tabel model)
     * @return object|null Data costing jika ditemukan, null jika tidak ditemukan
     */
    public function getCostingByEbakoCode($ebako_code) {
        $model_id = $this->getModelIdByEbakoCode($ebako_code);
        
        if ($model_id) {
            return $this->getCostingByModelId($model_id);
        }
        
        return null;
    }
    
    /**
     * Menyiapkan data detail sales quotes berdasarkan costing
     * 
     * @param int $sales_quotes_id ID sales quotes
     * @param object $costing Data costing
     * @param double $fob_price Harga FOB
     * @param string $notes Catatan
     * @param int $quantity Kuantitas
     * @return array Data detail sales quotes
     */
    public function prepareSalesQuotesDetailData($sales_quotes_id, $costing, $fob_price, $notes, $quantity = 1, $last_quotation_fob_price = 0, $product_price = 0, $last_costing_price = 0) {
        $detail_data = [
            'sales_quotes_id' => $sales_quotes_id,
            'costingid' => $costing ? $costing->id : 0,
            'fob_price' => $fob_price,
            'notes' => $notes,
            'quantity' => $quantity,
            'last_quotation_fob_price' => $last_quotation_fob_price,
            'product_price' => $product_price,
            'last_costing_price' => $last_costing_price
        ];
        
        // Jika costing ditemukan, tambahkan data tambahan dari costing
        if ($costing) {
            $detail_data['ratevalue'] = $costing->ratevalue;
            $detail_data['profit_margin'] = $costing->profit_percentage;
            $detail_data['q_wood'] = $costing->q_wood;
            $detail_data['q_veneer'] = $costing->q_veneer;
            $detail_data['q_upholstery_type'] = $costing->q_upholstery_type;
            $detail_data['q_fabric'] = $costing->q_fabric;
            $detail_data['q_leather'] = $costing->q_leather;
            $detail_data['q_other_remarks'] = $costing->q_other_remarks;
            $detail_data['q_shipping_conf'] = $costing->q_shipping_conf;
            $detail_data['q_packing'] = $costing->q_packing;
            $detail_data['q_qty_perbox'] = $costing->q_qty_perbox;
            $detail_data['q_box_dimension'] = $costing->q_box_dimension;
            $detail_data['q_cube'] = $costing->q_cube;
            $detail_data['q_finishes'] = $costing->q_finishes;
            
            // Mengambil dimensi dari model jika tersedia
            if ($costing->modelid) {
                $this->db->select('dw, dd, dht, cw, cd, ch');
                $this->db->where('id', $costing->modelid);
                $model_query = $this->db->get('model');
                
                if ($model_query->num_rows() > 0) {
                    $model = $model_query->row();
                    $detail_data['dw'] = $model->dw;
                    $detail_data['dd'] = $model->dd;
                    $detail_data['dht'] = $model->dht;
                    $detail_data['cw'] = $model->cw;
                    $detail_data['cd'] = $model->cd;
                    $detail_data['ch'] = $model->ch;
                }
            }
        }
        
        return $detail_data;
    }

    public function getByProformaQuotationId($proforma_quotation_id) {
    $this->db->where('proforma_quotation_id', $proforma_quotation_id);
    $query = $this->db->get('sales_quotes');
    
    if ($query->num_rows() > 0) {
        return $query->row();
    }
    
    return null;
}
}