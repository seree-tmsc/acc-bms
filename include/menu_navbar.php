<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" 
                class="navbar-toggle collapsed" 
                data-toggle="collapse" 
                data-target="#navbar" 
                aria-expanded="false" 
                aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!--<img src="images/tmsc-logo-128.png" width="96" class="img-responsive center-block">-->
            <img src="images/tmsc-logo-128.png" width="96">
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <!-- Main -->
            <ul class="nav navbar-nav">
                <li>
                    <a href="Main.php">
                        <span class="fa fa-home fa-lg" style="color:blue"></span>
                        Home
                    </a>                            
                </li>                
            </ul>

            <!-- Menu Upload -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-upload fa-lg" style="color:blue"></span> 
                        Upload ข้อมูล
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>                             
                            <a href="upload_ZSFI_R0001_AR_AGING_Criteria.php" >
                                <span class="fa fa-upload fa-lg" style="color:navy"></span> 
                                Upload ข้อมูล AR-Aging By Invoice Date
                            </a>
                        </li>
                        <li>                             
                            <a href="upload_ZSFI_R0001_AR_AGING_ByCust_Criteria.php" >
                                <span class="fa fa-upload fa-lg" style="color:navy"></span> 
                                Upload ข้อมูล AR-Aging By Customer
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="lst_Upload_ZSFI_R0001_AR_AGING_Criteria.php">
                                <!--&nbsp&nbsp&nbsp-->
                                <span class='fa fa-edit fa-lg' style="color:navy"></span>
                                การจัดการข้อมูล AR-Aging
                            </a>
                        </li>
                        
                    </ul>
                </li>
            </ul>

            <!-- Menu Billing -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-file-o fa-lg" style="color:blue"></span> 
                        ใบวางบิล
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="Create_Billing_Criteria.php">
                                <span class="fa fa-file-o fa-lg" style="color:navy"></span>
                                สรุปใบวางบิล
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="lst_Billing_Document_Criteria.php">
                                <span class='fa fa-edit fa-lg' style="color:navy"></span>
                                การจัดการใบวางบิล [By Manual]
                            </a>
                        </li>
                        <li class="divider">
                        <li>
                            <a href="created_plan_by_AI_criteria.php">
                                <span class='fa fa-edit fa-lg' style="color:navy"></span>
                                การจัดการใบวางบิล [By Computer]
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>            
            
            <!-- Menu Tools -->
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-wrench fa-lg" style="color:blue"></span> 
                        เครื่องมือการจัดการระบบ
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="pMA_User.php">
                                <span class='fa fa-address-card-o' style="color:blue"></span>
                                การจัดการผู้ใช้งาน
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class='fa fa-user-circle-o fa-lg' style="color:blue"></span> 
                        Login as ... 
                        <?php echo $_SESSION["ses_email"];?> 
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>                                
                            <a href="#" data-toggle="modal" data-target="#chgpasswordModal">
                                <span class='fa fa-pencil-square-o fa-lg'></span> 
                                แก้ไข Password
                            </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>                                
                            <a href="#" data-toggle="modal" data-target="#logoutModal">
                                <span class="fa fa-sign-out fa-lg"></span> 
                                logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>