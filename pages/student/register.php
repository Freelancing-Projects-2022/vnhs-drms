<!DOCTYPE html>
<html>

<head>
    <?php
        include("../../dbcon.php");
        include("../../util.php");
        $query = mysqli_query($conn, "SELECT * FROM settings");                    
        $row = mysqli_fetch_array($query);

        $systemDisplayName = "";
        $organizationName = "";
        if ($row != null) {                
            $systemDisplayName = $row['system_display_name'];
            $organizationName = $row['organization_name'];
        }
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?=$organizationName?> | <?=$systemDisplayName?></title>

    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="../../assets/css/animate.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <link href="../../assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../../images/bg-home.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }

        .login-column-2 {
            max-width: 1000px;
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
        }
    </style>
</head>
<?php
    session_start();
    $msg = "";
    if(isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
?>
<input type="hidden" id="txtMessage" value="<?php echo $msg ?>" >
<body>
    <div class="login-column-2 animated fadeInDown">
        <div id="ibox" class="row">
            <div class="ibox-content" style="border-radius:10px;">
                <div class="sk-spinner sk-spinner-double-bounce">
                    <div class="sk-double-bounce1"></div>
                    <div class="sk-double-bounce2"></div>
                </div>
                <div class="col-sm-12 border-bottom">
                    <h2 class="text-center"><b>Student Registration</b></h2>
                </div>
                <div class="col-sm-12">
                    <form id="frmRegistration" class="m-t" role="form" method="POST" action="../../backend/student-registration-add.php">                                
                        <div class="form-group col-sm-3">
                            <label>LRN</label>
                            <input type="text" placeholder="Enter 12 digit LRN" class="form-control" minlength="12" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="txtLRN" name="txtLRN" required>
                        </div>   
                        <div class="col-sm-9">
                            <div class="alert alert-info m-t-md" style="padding: 10px 15px;">
                                Your Learner Reference Number (LRN) will serve as your username.
                            </div>    
                        </div>                         
                        <div class="form-group col-sm-3">
                            <label>Last Name</label>
                            <input type="text" placeholder="Enter Last Name" class="form-control" id="txtLastName" name="txtLastName" required>
                        </div>      
                        <div class="form-group col-sm-6">
                            <label>First Name</label>
                            <input type="text" placeholder="Enter First Name" class="form-control" id="txtFirstName" name="txtFirstName" required>
                        </div>
                        <div class="form-group col-sm-3">
                            <label>Middle Name</label>
                            <input type="text" placeholder="Enter Middle Name" id="txtMiddleName" name="txtMiddleName" class="form-control">
                        </div>       
                        <div class="form-group col-sm-3">
                            <label>Email Address</label>
                            <input type="email" placeholder="johndoe@gmail.com" class="form-control" id="txtEmailAddress" name="txtEmailAddress" required>
                        </div>     
                        <div class="form-group col-sm-3">
                            <label>Cellphone Number</label>
                            <input type="text" placeholder="09xxxxxxxxx" class="form-control" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="txtCPNumber" name="txtCPNumber" required>
                        </div>                    
                        <div class="form-group col-sm-3">
                            <label>Password</label>
                            <input type="password" placeholder="Enter Password" class="form-control col-sm-10" id="txtPassword" name="txtPassword" onkeyup="checkPassword(this.value)" required>
                        </div>                
                        <div id="frmGrpReTypePassword" class="form-group col-sm-3">
                            <label>Re-Type Password</label>
                            <input type="password" placeholder="Re-Type Password" class="form-control col-sm-10" id="txtReTypePassword" onkeyup="checkPassword(this.value)" required>
                        </div>                          
                        <div class="col-sm-12 border-top text-center m-b-lg m-t-sm">
                            <button onclick="history.back()" class="btn btn-danger m-t"><i class="fa fa-mail-reply m-r-xs"></i>Cancel</button>
                            <button type="submit" name="submit" class="btn btn-success m-t"><i class="fa fa-check m-r-xs"></i>Confirm</button>
                        </div>
                    </form>
                </div>
                <div class="clearfix m-b-sm"></div>
            </div>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="../../assets/js/jquery-3.1.1.min.js"></script>
    <script src="../../assets/js/bootstrap.min.js"></script>
    <script src="../../assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../../assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Sweet Alert -->
    <script src="../../assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <script type="text/javascript">
        function checkPassword(reTypedPassword) {
            if(reTypedPassword != $('#txtPassword').val() || reTypedPassword != $('#txtReTypePassword').val()) {
                $(':input[type="submit"]').prop('disabled', true);
                $('#frmGrpReTypePassword').addClass('has-error');
            }
            else {                
                $(':input[type="submit"]').prop('disabled', false);
                $('#frmGrpReTypePassword').removeClass('has-error');
            }
        }

        var msgStr = $("#txtMessage").val();
        if(msgStr.length != 0) {
                var msgType = "<?php echo $_SESSION['msgType'] ?>";
                var msgTitle = "<?php echo $_SESSION['msgTitle'] ?>";
                swal(msgTitle, msgStr, msgType);
        }
    </script>
</body>

</html>
