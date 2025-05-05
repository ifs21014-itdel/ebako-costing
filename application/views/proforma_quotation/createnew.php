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
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Number :</label></td>  
            <td>
                <input type="text" id="number" name="number" 
                    style="width: 305px;background-color: #fbfbfb;border: 1px solid #aeb5c5;" class="form-control-sm" required />
            </td>
        </tr>
        <tr>
            <td align="right"><label class="labelelement"><span style="color: red;">*&nbsp;</span>Date:</label></td>
            <td>
                <input type="date" size="10" name="date" id="date" value=""/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center"><br/>
                <button type="button" class="btn btn-md btn-success" onclick="proforma_savenew()">Save</button>
                <button type="button" class="btn btn-md btn-secondary" data-dismiss="modal">Cancel</button>
            </td> 
        </tr>
    </table>
</div>


