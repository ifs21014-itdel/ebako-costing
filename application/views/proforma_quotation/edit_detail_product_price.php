<div class="row" style="width: 700px" >
    <table class="" align="center" border="0" width='100%'>
    <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>FOB Product Price:</label></td>  
            <td>
            <input type="hidden" id="proforma_quation_id" name="proforma_quation_id" value="<?php echo $detail->proforma_quotation_id ?>" />
            <input type="hidden" id="detail_id" name="detail_id" value="<?php echo $detail->id ?>" />
                <input type="hidden" id="productpriceid0" name="productpriceid"  value="<?php echo $detail->product_price_id ?>" />
                <input type="text" id="productpricecode0" name="productpricecode" value="<?php echo $detail->fob_product_price ?>"
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="product_price_list_choose_2()"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Model (Ebako Code) :</label></td>  
            <td>
                <input type="text" id="ebako_code" name="ebako_code" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required  value="<?php echo $detail->ebako_code ?>"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Customer Code :</label></td>  
            <td>
                <input type="text" id="cust_code" name="cust_code"  value="<?php echo $detail->customer_code ?>"
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>        
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Remark :</label></td>  
            <td>
                <input type="text" id="remark" name="remark" value="<?php echo $detail->remark ?>"
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><br/>
                <button type="button" class="btn btn-md btn-success" onclick="update_proforma_detail_from_product_price()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>


