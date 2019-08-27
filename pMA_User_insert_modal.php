<div class="modal fade" id="insert_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Insert Data :</h4>
            </div>
            
            <div class="modal-body" id="detail"> 
                <form method='post' id='insert-form'>
                    <input type="hidden" id="editempCode" name="editempCode">
                    <label>Code:</label>
                    <input type="text" id="empCode" name ="empCode" class='form-control' required>
                    <label>e-Mail:</label>
                    <input type="email" id="eMail" name ='eMail' class='form-control' required>
                    <label>User Type:</label>
                    
                    <!--<input type="text" id="userType" name = 'userType' class='form-control' required>-->
                    <select id="userType" name = 'userType' class='form-control' required>
                        <option value="A">Admin</option>
                        <option value="P">Power-User</option>
                        <option value="U">End-User</option>
                    </select>

                    <label>Created Date:</label>
                    <input type="date" id="createdDate" name ='createdDate' class='form-control' value="<?php echo date('Y-m-d'); ?>" >
                    <br>
                    <input type="submit" id='insert' class='btn btn-success'>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary btnClose" data-dismiss="modal">Close</button>
            </div>
            
        </div>
    </div>
</div>