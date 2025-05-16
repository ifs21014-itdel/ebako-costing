<div class="row" style="width: 700px" >
    <table class="" align="center" border="0" width='100%'>
        <tr>
            <td align="right"><span class="labelelement"><span style="color: red;">*&nbsp;</span>Customer :</span></td>
            <td>
                <select id="customerid" class="form-control-sm">
                    <option value="0"></option>
                    <?php
                    foreach ($customer as $result) {
                        echo "<option value='" . $result->id . "'>" . $result->name . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Model :</label></td>  
            <td>
                <input type="hidden" id="modelid0" value="0" />
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
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Description :</label></td>  
            <td>
                <input type="text" id="description" name="description" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Material :</label></td>  
            <td>
                <input type="text" id="material" name="material" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>


        
     <!-- Fragment dari form Anda -->
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Last Quotation FOB Price :</label></td>  
            <td>
                <input type="hidden" id="costingid0" name="costingid" value="1" />
                <input type="text" id="costingcode0" name="costingcode" value="" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm"/>
                <img style="cursor: pointer;" src="images/list.png" class="miniaction" onclick="costing_list_choose()"/>
            </td>
        </tr>
      

        <tr>
            <td align="right"><span class="labelelement">Dimension :</span></td>
            <td>
                <span class="required">* </span>W (mm) : <input type="text" id="cw" name="cw" size="4" style="text-align: center;" required="required" /> &nbsp;&nbsp;
                <span class="required">* </span>D (mm) : <input type="text" id="cd" name="cd" size="4" style="text-align: center;" required="required" /> &nbsp;&nbsp;
                <span class="required">* </span>HT (mm) : <input type="text" id="ch" name="ch" size="4" style="text-align: center;" required="required" /> &nbsp;&nbsp;
            </td>
        </tr>

        
        
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Quotation Date:</label></td>
            <td>
                <input type="date" size="10" name="quotation_date" id="quotation_date" value=""/>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Approval Date:</label></td>
            <td>
                <input type="date" size="10" name="approval_date" id="approval_date" value=""/>
            </td>
        </tr>

                 
       
        <tr>
            <td align="right"><label class="labelelement">Finishes:</label></td>
            <td>
                <select  name="q_finishes" id="item_costing_q_wood"> 
                    <option value='FINISHED'>FINISHED</option>
                    <option value='RAW FRAME'>RAW FRAME</option>
                </select>
            </td>
        </tr>
       

        <tr>
            <td colspan="2" align="center"><br/>
                <button type="button" class="btn btn-md btn-success" onclick="pro_savenew()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>


