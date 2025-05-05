<div class="row" style="width: 700px" >
    <table class="" align="center" border="0" width='100%'>
    <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>FOB Product Price:</label></td>  
            <td>
            <input type="hidden" id="proforma_quation_id" name="proforma_quation_id" />
                <input type="hidden" id="productpriceid0" name="productpriceid" value=" " />
                <input type="text" id="productpricecode0" name="productpricecode" value="" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="product_price_list_choose_2()"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Model (Ebako Code) :</label></td>  
            <td>
                <input type="text" id="ebako_code" name="ebako_code" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Customer Code :</label></td>  
            <td>
                <input type="text" id="cust_code" name="cust_code" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
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
                <button type="button" class="btn btn-md btn-success" onclick="proforma_detail_savenew_from_product_price()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>


