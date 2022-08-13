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
            max-width: 500px;
            margin: 0 auto;
            padding: 20vh 20px 20px 20px;
        }
        
        h2 {
            color: black;
        }
        @media only screen and (max-width: 768px) {
        /* For mobile phones: */
            .login-column-2 {
                padding: 10vh 20px;
            }
        }
    </style>
</head>
<?php
    session_start();
?>
<body>
    <div class="login-column-2 animated fadeInDown">
        <div id="ibox" class="row">
            <div class="ibox-content" style="border-radius:10px;">
                <div class="sk-spinner sk-spinner-double-bounce">
                    <div class="sk-double-bounce1"></div>
                    <div class="sk-double-bounce2"></div>
                </div>
                <div class="col-sm-12 border-bottom">
                    <h2 class="text-center"><b>Forgot Password</b></h2>
                </div>
                <div class="col-sm-12">
                    <div id="divSendRecoveryCode" >                           
                        <div class="form-group text-center col-sm-12 m-t-md">
                            <label>Learner's Refence Number (LRN)</label>
                            <input type="text" placeholder="Enter 12 digit LRN" class="form-control  text-center" maxlength="12" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="txtLRN" name="txtLRN" required>
                        </div>   
                        <div class="form-group text-center col-sm-12">
                            <label>Registered Mobile Number</label>
                            <input type="text" placeholder="09xxxxxxxxx" class="form-control text-center" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="txtCPNumber" name="txtCPNumber" required>
                            <br><label>We will send a recovery code if this matches to your account.</label>
                        </div>                                              
                        <div class="col-sm-12 border-top text-center m-b-lg m-t-sm">
                            <button onClick="cancelRecovery()" class="btn btn-default m-t"><i class="fa fa fa-mail-reply m-r-xs"></i>Cancel</button>
                            <button onClick="sendRecoveryCode()" class="btn btn-primary m-t"><i class="fa fa-paper-plane m-r-xs"></i>Send Code</button>
                        </div>
                    </div>
                    <div id="divEnterRecoveryCode" style="display:none;">                         
                        <div class="form-group text-center col-sm-12 m-t-md">
                            <label>Enter Recovery Code</label>
                            <input type="text" placeholder="" class="form-control text-center" id="txtRecoverCode" name="txtRecoverCode" style="font-size: 28px; font-weight: 800 !important;font-family: monospace;">
                            
                        </div>                       
                        <div class="col-sm-12 border-top text-center m-b-lg m-t-sm">
                            <button onClick="$('#divEnterRecoveryCode').hide();$('#divSendRecoveryCode').show();" class="btn btn-warning m-t"><i class="fa fa fa-mail-reply m-r-xs"></i>Back</button>
                            <button onClick="submitRecoverCode()" class="btn btn-success m-t"><i class="fa fa-check m-r-xs"></i>Submit</button>
                        </div>
                    </div>
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
        function cancelRecovery() {            
            window.location.href='../../index.php';
        }

        function sendRecoveryCode() {
            $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: 'POST',
                url: '../../backend/student-account-send-recover-code.php',
                data: {
                    lrn: $("#txtLRN").val(),
                    cpNumber: $("#txtCPNumber").val()
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response.msgType == "success") {
                        swal("Success", response.msgStr, "success");
                        $("txtRecoverCode").val("");
                        $("#divEnterRecoveryCode").show();
                        $("#divSendRecoveryCode").hide();
                    }
                    else {                    
                        swal("Invalid", response.msgStr, "error");
                    }
                    $('#ibox').children('.ibox-content').toggleClass('sk-loading');             
                }
            }); 
	        
        }

        function submitRecoverCode() {
	        $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: 'POST',
                url: '../../backend/student-account-send-recover-code-confirm.php',
                data: {
                    lrn: $("#txtLRN").val(),
                    cpNumber: $("#txtCPNumber").val(),
                    recoveryCode: $("#txtRecoverCode").val()
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response.msgType == "success") {
                        swal("Success", response.msgStr, "success");
                        setTimeout(function() {
                            window.location.href='../../index.php';
                        }, 2500);
                    }
                    else {                    
                        swal("Invalid", response.msgStr, "error");
                    }         
	                $('#ibox').children('.ibox-content').toggleClass('sk-loading');    
                }
            }); 
        }
    </script>
</body>

</html>
