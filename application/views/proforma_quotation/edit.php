<div class="row" style="width: 700px;">
    <table align="center" border="0" width="100%">
        <tr>
            <td align="right"><label class="labelelement">Customer :</label></td>
            <td>
            <input type="hidden" id="id" name="id" value="<?php echo $proforma_quotation->id ?>" />
                <input type="hidden" id="id" value="<?php echo $proforma_quotation->id ?>" />
                <select id="customerid" class="form-control-sm">
                    <option value="0"></option>
                    <?php foreach ($customer as $result): ?>
                        <option value="<?php echo $result->id ?>" <?php echo ($result->id == $proforma_quotation->customer_id) ? 'selected' : '' ?>>
                            <?php echo $result->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Number :</label></td>  
            <td>
                <input type="text" id="number" name="number" 
                    style="width: 305px; background-color: #fbfbfb; border: 1px solid #aeb5c5;" 
                    class="form-control-sm" required 
                    value="<?php echo $proforma_quotation->number ?>" />
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Date:</label></td>
            <td>
                <input type="date" size="10" name="date" id="date" 
                    value="<?php echo $proforma_quotation->date ?>" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><br/>
                <button type="button" class="btn btn-md btn-success" onclick="proforma_edit()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>
