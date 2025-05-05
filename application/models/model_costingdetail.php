<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model_costing
 *
 * @author hp
 */
class model_costingdetail extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function selectDetailById($id) {
        $query = "select * from costingdetail_log where costingid=$id";
        return $this->db->query($query)->row();
    }
    

}

?>
