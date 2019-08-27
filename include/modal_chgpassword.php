<div class="modal fade" id="chgpasswordModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Change password</h4>
            </div>

            <div class="modal-body">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Input Form</h3>
                    </div>
                    <div class="panel-body">
                        <form action="chg_password.php" method="post">
                            <div class="col-lg-2 col-md-6">
                            </div>

                            <div class="col-lg-8 col-md-6">
                                <div class="form-group">
                                    <label>Current Password:</label>
                                    <input type="password"  name="param_curpwd" value="" placeholder="Current password" required autofocus class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>New Password:</label>
                                    <input type="password" name="param_newpwd" value="" placeholder="New password" required class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password:</label>
                                    <input type="password" name="param_confnewpwd" values ="" placeholder ="Confirm new password" required class="form-control" >                                    
                                </div>
                                <div align="right">
                                    <!--<input type="submit" name="btn_Login" value="Login" class="btn btn-success">-->
                                    <button type="button" name ="btn_cancel" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <!--<a class="btn btn-success" href="chgpassword.php">Submit</a>-->
                                    <!--<button type="submit" class="btn btn-success" data-dismiss="modal">Change Password</button>-->
                                    <input type="submit" name="btn_submit" value="Change Password" class="btn btn-success">
                                </div>                                
                            </div>

                            <div class="col-lg-2 col-md-6">                
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!--
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>                
                <a class="btn btn-success" href="logout.php">Logout</a>
                -->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->