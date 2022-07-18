 <?php
    // This is the Footer of the page
    // All the javascript sources are declared here

    include("dbcon.php");
    $query = mysqli_query($conn, "SELECT * FROM settings");                    
    $row = mysqli_fetch_array($query);
    $systemDisplayName = "";
    $organizationName = "";
    if ($row != null) {       
        $systemDisplayName = $row['system_display_name'];
        $organizationName = $row['organization_name'];
    }
 ?>
            <div class="footer m-t-md">
                <div class="pull-right">
                    <?= $systemDisplayName?>
                </div>
                <div>
                    <strong>Copyright</strong> <?= $organizationName?> &copy; 2022
                </div>
            </div>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        

    <!-- Flot -->
    <script src="assets/js/plugins/flot/jquery.flot.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Peity -->
    <script src="assets/js/plugins/peity/jquery.peity.min.js"></script>
    <script src="assets/js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="assets/js/inspinia.js"></script>
    <script src="assets/js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- EayPIE -->
    <script src="assets/js/plugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="assets/js/demo/sparkline-demo.js"></script>
    
    <!-- Sweet Alert -->
    <script src="assets/js/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Full Calendar -->
    <script src="assets/js/plugins/fullcalendar/moment.min.js"></script>
    <script src="assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    
    <!-- DataTables -->
    <script src="assets/js/plugins/dataTables/datatables.min.js"></script>

    <!-- Data picker -->
    <script src="assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>
    
    <!--Tinycon -->
    <script src="assets/js/plugins/tinycon/tinycon.min.js"></script>
    
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

<script>
    var msgStr = $('#txtMessage').val();
    if(msgStr.length != 0) {
        var msgType = $('#txtMessageType').val();
        var msgTitle = $('#txtMessageTitle').val();
        swal(msgTitle, msgStr, msgType);
    }
</script>
