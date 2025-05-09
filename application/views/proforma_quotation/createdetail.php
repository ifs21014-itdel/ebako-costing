<div class="row" style="width: 700px" >
    <table class="" align="center" border="0" width='100%'>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Model :</label></td>  
            <td>
            <input type="hidden" id="proforma_quation_id" name="proforma_quation_id" />
                <input type="hidden" id="modelid0" value="" />
                <input type="hidden" id="customerid" name="customerid" />
                <input type="text" id="modelcode0" value=""  
                       style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;"  class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="model_list_choose()"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Customer Code :</label></td>  
            <td>
                <input type="text" id="custcode" name="custcode" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>

        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>FOB :</label></td>  
            <td>
                <input type="hidden" id="quotation_detail_id" name="quotation_detail_id" value=" " />
                <input type="text" id="quotation_detail_fob" name="quotation_detail_fob" value=" " 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="costing_list_choose()"/>
            </td>
        </tr>
        
        <!-- <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Quotation Detail Id :</label></td>  
            <td>
                <input type="text" id="quotation_detail_id" name="quotation_detail_id" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr> -->
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>FOB Costing :</label></td>  
            <td>
                <input type="text" id="fob_costing" name="fob_costing" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>
        <tr>
            <td align="right">
                <label class="labelelement">
                    <span style="color: red;">*&nbsp;</span>Quantity :
                </label>
            </td>  
            <td>
                <input type="number" id="quantity" name="quantity" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>


        
     <!-- Fragment dari form Anda -->
       
      
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>FOB Product Price:</label></td>  
            <td>
                <input type="hidden" id="productpriceid0" name="productpriceid" value=" " />
                <input type="text" id="productpricecode0" name="productpricecode" value="" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="product_price_list_choose()"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Remark :</label></td>  
            <td>
                <input type="text" id="remark" name="remark" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>

    
    
       

        <tr>
            <td colspan="2" align="center"><br/>
                <button type="button" class="btn btn-md btn-success" onclick="proforma_detail_savenew()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>


