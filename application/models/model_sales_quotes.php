<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_model
 *
 * @author admin
 */
class model_sales_quotes extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    function selectById($id) {
        $query = "select sq.*, customer.name from sales_quotes sq "
                . "LEFT JOIN customer on sq.customer_id=customer.id  where sq.id=" . $id;
        //echo $query."<br/>";
        return $this->db->query($query)->row();
    }

    function selectAll() {
        $this->db->order_by('id', 'approvedstatus', 'desc');
        return $this->db->get('model')->result();
    }

    function selectAllAvailabel() {
        $query = "select 
                model.*,
                (select model_getfinish_overview(model.id)) finishoverviewname,
                (select model_getconstruction_overview(model.id)) constructionoverviewname
                from model where ishavebom=true order by id desc";
        return $this->db->query($query)->result();
    }

    function selectAllFromCostingByCustomer($billto) {
        $query = "select 
                  costing.modelid,
                  model.*,
                  (select model_getfinish_overview(model.id)) finishoverviewname,
                  (select model_getconstruction_overview(model.id)) constructionoverviewname
                  from costing join 
                  model on costing.modelid=model.id and costing.customerid=$billto";
        //echo $query;
        return $this->db->query($query)->result();
    }

    function getNumRows($sq_id, $custid) {
        $query = "select sq.*, customer.name from sales_quotes sq "
                . "LEFT JOIN customer on sq.customer_id=customer.id where true ";
        if ($sq_id != "") {
            $query .= " and sq.quotation_number ilike '%" . $sq_id . "%'";
        }if ($custid != "" && $custid != 0) {
            $query .= " and sq.customer_id ='" . $custid . "'";
        }
        //$query .= "  order by sq.id desc";
       // echo $query;
        return $this->db->query($query)->num_rows();
    }

    function search($sq_id, $custid, $limit, $offset) {
        $query = "select sq.*, customer.name from sales_quotes sq "
                . "LEFT JOIN customer on sq.customer_id=customer.id where true ";
        
        $code = $this->input->post('code');
       // echo "code=".$code;
        if ($sq_id != "") {
            $query .= " and sq.quotation_number ilike '%" . $sq_id . "%'";
        }if ($custid != "" && $custid != 0) {
            $query .= " and sq.customer_id ='" . $custid . "'";
        }if ($code != "") {
            $query .= " and sq.id in "
                    . "(select sq.sales_quotes_id from sales_quotes_detail sq LEFT JOIN costing c on sq.costingid=c.id"
                    . " LEFT JOIN model m on c.modelid=m.id where m.no ilike '%".$code."%' or m.custcode ilike '%".$code."%')";
        }
        $query .= " order by sq.id desc limit $limit offset $offset";
        //echo $query;
        return $this->db->query($query)->result();
    }

    function getFileNameById($id) {
        $this->db->select('filename');
        $this->db->where('id', $id);
        $dt = $this->db->get('model')->row();
        return $dt->filename;
    }

    function selectsqdetailbyid($id) {
        $query = "select 
                sqd.*,
                cos.q_wood,
                cos.q_veneer,
                cos.q_upholstery_type,
                cos.q_fabric,
                cos.q_leather,
                cos.q_other_remarks,
                cos.q_shipping_conf,
                cos.q_packing,
                cos.q_qty_perbox,
                cos.q_box_dimension,
                cos.q_cube,
                cos.q_finishes,
                model.no code,
                model.custcode,
                model.finish_on_metal_hardware,
                model.additionalnotes,
                model.description model_desc,
                model.filename,
                model.dd,
                model.dw,
                model.dht,
                model.cd,
                model.cw,
                model.ch 
                from sales_quotes_detail sqd 
                LEFT JOIN sales_quotes sq ON sqd.sales_quotes_id=sq.id
                LEFT JOIN costing cos ON sqd.costingid=cos.id 
                left join model on cos.modelid=model.id
                where sq.id=$id";
       // echo $query;
        return $this->db->query($query)->result();
    }


      function update_parent_sales($sales_quotes_id, $model_id) {
        // First, find the sales quotes ID associated with this model
        
        
            
            // Update parent_sales_quotes_id in the current sales_quotes
            $this->db->where('id', $sales_quotes_id);
            $this->db->update('sales_quotes', array('parent_id' => $model_id));
            
            return $this->db->affected_rows() > 0;
      
    }
    //  function selectById($id) {
    //     $this->db->where('id', $id);
    //     return $this->db->get('sales_quotes')->result();
    // }
    
    // Function to get related models for dropdown
  function getRelatedModels($id) {
    $sql = "SELECT DISTINCT 
                model.id, 
                model.no,
                CONCAT(model.no, ' - ', model.custcode, ' - ', model.description) as name
            FROM model
            JOIN costing cos ON model.id = cos.modelid
            JOIN sales_quotes_detail sqd ON cos.id = sqd.costingid
            JOIN sales_quotes sq ON sqd.sales_quotes_id = sq.id
            WHERE sq.id = ?
            ORDER BY model.no ASC";

    $query = $this->db->query($sql, [$id]);

    if (!$query) {
        error_log('Query failed: ' . $this->db->_error_message());
        return [];
    }

    return $query->result();
}






    function getModelAvailable() {
        $query = "select 
                  model.*,
                  modeltype.name modeltypename,
                  (select model_getfinish_overview(model.id)) finishoverviewname,
                  (select model_getconstruction_overview(model.id)) constructionoverviewname
                  from model join
                  modeltype on model.modeltypeid=modeltype.id where model.ishavebom=true and model.checkedstatus='1' and model.approvedstatus='1'";
        return $this->db->query($query)->result();
    }
    
    function delete($id) {
        return $this->db->query("delete from public.sales_quotes where id=$id");
    }

}

?>
