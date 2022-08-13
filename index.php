<!DOCTYPE html>
<html>
    <head>
    <?php
        // This is where the first page of the app loads
        // This also contains the login page

        include("dbcon.php");
        include("util.php");
        $query = mysqli_query($conn, "SELECT * FROM settings");                    
        $row = mysqli_fetch_array($query);

        $logo = "images/logo.png";
        $systemDisplayName = "";
        $organizationName = "";
        $maxCountOfRequestPerDay = "";
        if ($row != null) {                    
            $id = $row['id'];    
            $logo = $row['logo'];         
            $systemDisplayName = $row['system_display_name'];
            $organizationName = $row['organization_name'];
        }
    ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?=$organizationName?> | <?=$systemDisplayName?></title>

        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        
        <link href="assets/css/animate.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <style>
            body {
                background-image: url('images/bg-home.jpg');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }

            .login-column-2 {
                max-width: 800px;
                margin: 0 auto;
                padding: 20vh 20px 20px 20px;
            }

            h2 {
                color: black;
            }
            @media only screen and (max-width: 768px) {
            /* For mobile phones: */
                .login-column-2 {
                    padding: 5px 20px;
                }

                .border-right {
                    border-right-width: 0px;
                    border-bottom: 1px solid #e7eaec;
                }
            }
        </style>
    </head>

    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        else {
            session_destroy();
        }
    ?>
    <body>
        <div class="login-column-2 animated fadeInDown">
            <div class="row">
                <div class="ibox-content" style="border-radius:10px;">
                    <div class="col-sm-6 text-center border-right m-t-md">
                        <img src="<?= $logo ?>" style="width: 90%;border-radius:50%"/>
                        <h2><strong><?= $systemDisplayName ?></strong></h2>
                    </div>
                    <div class="col-sm-6 m-t-md">
                        <form method="POST" action="backend/login.php" class="m-t" role="form">
                            <h3 class="text-center">
                                <b>Sign in to your account</b>                            
                            </h3>
                            <div class="form-group">
                                <label>LRN / Username</label>
                                <input id="txtUsername" name="txtUserName" type="text" placeholder="Enter Student LRN or Admin Username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input id="txtPassword" name="txtPassword" type="password" placeholder="Enter Password" class="form-control col-sm-10" required>
                                <a class="col-sm-2" style="margin-top: -30px !important; float: right !important; margin-right: 10px !important;" href="#" onclick="showPassword()"><i id="iconPassword" style="color: #333 !important" class="fa fa-eye-slash fa-2x"></i></a>
                            
                            </div>
                            <p class="text-right">
                                <a href="pages/student/forget-password.php">
                                    <small>Forgot password?</small>
                                </a>
                            </p>
                            <button type="submit" class="btn btn-success block full-width m-b">Login</button>

                            <p class="text-muted text-center">
                                <small>Do not have an account?</small>
                            </p>
                            <a class="btn btn-sm btn-primary btn-block" href="pages/student/register.php">Create an account</a>
                        </form>
                        <p class="m-t text-center">
                            <small><?= $organizationName ?> &copy; 2022</small>
                        </p>
                    </div>
                    <div class="clearfix m-b-md"></div>
                </div>
            </div>
        </div>
        
        <!-- Mainly scripts -->
        <script type="text/javascript" src="assets/js/jquery-3.1.1.min.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script type="text/javascript" src="assets/js/plugins/sweetalert/sweetalert.min.js"></script>

        <?php
            $msg = "";
            $msgType = "";
            $msgTitle = "";
            if(isset($_SESSION['msg'])){
                $msg = $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            if(isset($_SESSION['msgType'])){
                $msgType = $_SESSION['msgType'];
                unset($_SESSION['msgType']);
            }
            if(isset($_SESSION['msgTitle'])){
                $msgTitle = $_SESSION['msgTitle'];
                unset($_SESSION['msgTitle']);
            }
        ?>
        <input type='hidden' id='txtMessage' value='<?php echo $msg ?>' >
        <input type='hidden' id='txtMessageType' value='<?php echo $msgType ?>' >
        <input type='hidden' id='txtMessageTitle' value='<?php echo $msgTitle ?>' >

        <script type="text/javascript"> 
            var msgStr = $('#txtMessage').val();
            if(msgStr.length != 0) {
                var msgType = $('#txtMessageType').val();
                var msgTitle = $('#txtMessageTitle').val();
                swal(msgTitle, msgStr, msgType);
            }

            function showPassword(){
                if($("#txtPassword").is("input:text")) {
                    $("#txtPassword").attr("type", "password")
                    $("#iconPassword").addClass("fa-eye-slash");
                    $("#iconPassword").removeClass("fa-eye");
                }
                else {
                    $("#txtPassword").attr("type", "text")
                    $("#iconPassword").addClass("fa-eye");
                    $("#iconPassword").removeClass("fa-eye-slash");
                }
            }
        </script>
    </body>

</html>
