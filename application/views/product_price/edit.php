<div class="row" style="width: 700px" >
    <table class="" align="center" border="0" width='100%'>
        <tr>
                <td align="right"><label class="labelelement">Customer :</label></td>
                <td>
                    <input type="hidden" id="id" value="<?php echo $product_price->id ?>" />
                    <select id="customerid" class="form-control-sm">
                        <option value="0"></option>
                        <?php
                        foreach ($customer as $result) {
                            if ($result->id == $product_price->customer_id) {
                                echo "<option value='" . $result->id . "' selected>" . $result->name . "</option>";
                            } else {
                                echo "<option value='" . $result->id . "'>" . $result->name . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Model :</label></td>  
            <td>
            <input type="hidden" id="modelid0" value="<?php echo $product_price->ebako_code ?>" />
            <input type="text" id="modelcode0" value="<?php echo $product_price->ebako_code  ?>" class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="model_list_choose()"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Customer Code :</label></td>  
            <td>
                <input type="text" id="custcode" name="custcode" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required  value="<?php echo $product_price->customercode ?>" />
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Description :</label></td>  
            <td>
                <input type="text" id="description" name="description" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required  value="<?php echo $product_price->description ?>" />
            </td>
        </tr>

            <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Material :</label></td>  
            <td>
                <input type="text" id="material"   value="<?php echo $product_price->material ?>" name="material" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>
     <!-- Fragment dari form Anda -->
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Last Quotation FOB Price :</label></td>  
            <td>
                <input type="hidden" id="costingid0" name="costingid" value="<?php echo $product_price->quotation_id ?>"  />
                <input type="text" id="costingcode0" name="costingcode" value="<?php echo $product_price->fob ?>" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="costing_list_choose()"/>
            </td>
        </tr>
      

        <tr>
            <td align="right"><span class="labelelement">Dimension :</span></td>
            <td>
                <span class="required">* </span>W (mm) : <input type="text" id="cw" name="cw" size="4" style="text-align: center;" required="required" value ="<?php echo $product_price->cw ?>" /> &nbsp;&nbsp;
                <span class="required">* </span>D (mm) : <input type="text" id="cd" name="cd" size="4" style="text-align: center;" required="required" value ="<?php echo $product_price->cd ?>"  /> &nbsp;&nbsp;
                <span class="required">* </span>HT (mm) : <input type="text" id="ch" name="ch" size="4" style="text-align: center;" required="required"value ="<?php echo $product_price->ch ?>"  /> &nbsp;&nbsp;
            </td>
        </tr>

        
        
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Quotation Date:</label></td>
            <td>
                <input type="date" size="10" name="quotation_date" id="quotation_date"  value="<?php echo $product_price->quotation_date ?>"/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Approval Date:</label></td>
            <td>
                <input type="date" size="10" name="approval_date" id="approval_date"  value="<?php echo $product_price->approval_date ?>"/>
            </td>
        </tr>

                 
       
        <tr>
            <td align="right"><label class="labelelement">Finishes:</label></td>
            <td>
                <select  name="q_finishes" id="q_finishes"> 
                    <option value='FINISHED' <?php if($product_price->q_finished=='FINISHED') echo 'selected'; ?>>FINISHED</option>
                    <option value='RAW FRAME' <?php if($product_price->q_finished=='RAW FRAME') echo 'selected'; ?>>RAW FRAME</option>
                </select>
            </td>
        </tr>
       

        <tr>
            <td colspan="2" align="center"><br/>
                <button type="button" class="btn btn-md btn-success" onclick="pro_edit()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>


