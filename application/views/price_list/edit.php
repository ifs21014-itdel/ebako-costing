<div class="row" style="width: 700px" >
    <table class="" align="center" border="0" width='100%'>
        <tr>
                <td align="right"><label class="labelelement">Customer :</label></td>
                <td>
                    <input type="hidden" id="id" value="<?php echo $price_list_detail->id ?>" />
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
       
     <!-- Fragment dari form Anda -->
    
       

        <tr>
            <td colspan="2" align="center"><br/>
                <button type="button" class="btn btn-md btn-success" onclick="pro_edit()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>


