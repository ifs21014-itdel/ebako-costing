<div style="width: 400px">
    <table width="100%">
        <tr>
            <td width="30%" align="right"><label class="labelelement">New Model Code :</label></td>
            <td width="70%">
                <input type="hidden" id="modelid_copy" value="<?php echo $modelid ?>" />                
                <input type="text" id="newcode" style="width: 100%"/>
            </td>
        </tr>
            <tr>
                <td>&nbsp;</td>
                <td><br/>
                    <button type="button" onclick="model_docopy()">Save</button>
       			 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </td>
            </tr>
    </table>
</div>
