
<style>
.fix-request-content > div {
    display: contents;
} 
</style>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-sm-12">
        <h2>Welcome, <?= $_SESSION['firstName']; ?>!</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#" name="pages/admin/home.php" onClick="setPage(this, 'DASHBOARD')">Home</a>
            </li>
            <li class="active">
                <strong>Dashboard</strong>
            </li>
        </ol>
    </div>
</div>
<?php
    include('dbcon.php');
    include('util.php');
    $userId = $_SESSION['userId'];
    $resultForApproval = mysqli_query($conn, "SELECT * FROM request WHERE status = 'FOR APPROVAL'");
    $resultCancelled = mysqli_query($conn, "SELECT * FROM request WHERE status = 'CANCELLED'");
    $resultResubmission = mysqli_query($conn, "SELECT * FROM request WHERE status = 'RESUBMISSION'");
    $resultForReleasing = mysqli_query($conn, "SELECT * FROM request WHERE status = 'FOR RELEASING'");

    $countForApproval = mysqli_num_rows($resultForApproval) == null? "0" : mysqli_num_rows($resultForApproval);
    $countCancelled = mysqli_num_rows($resultCancelled) == null? "0" : mysqli_num_rows($resultCancelled);
    $countResubmission = mysqli_num_rows($resultResubmission) == null? "0" : mysqli_num_rows($resultResubmission);
    $countForReleasing = mysqli_num_rows($resultForReleasing) == null? "0" : mysqli_num_rows($resultForReleasing);
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3 col-md-6  col-sm-12 col-xs-12">
            <div class="widget style1 lazur-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-spinner fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> For Approval</span>
                        <h2 class="font-bold"><?= $countForApproval?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6  col-sm-12 col-xs-12">
            <div class="widget style1 red-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-times-circle fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Cancelled </span>
                        <h2 class="font-bold"><?= $countCancelled?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6  col-sm-12 col-xs-12">
            <div class="widget style1 yellow-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-upload fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> Resubmission</span>
                        <h2 class="font-bold"><?= $countResubmission?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6  col-sm-12 col-xs-12">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <div class="col-xs-4">
                        <i class="fa fa-thumbs-up fa-5x"></i>
                    </div>
                    <div class="col-xs-8 text-right">
                        <span> For Releasing </span>
                        <h2 class="font-bold"><?= $countForReleasing?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>        
    <div class="row animated fadeInDown m-t-md m-b-md">
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <span class="label label-warning pull-right spanTodayDate" ></span>
                    <h5>Your Appointments Today</h5>
                </div>
                <div class="ibox-content">
                    <p>Students scheduled today for document releasing.</p>
                    <div class="table-responsive">
                        <table class="table table-hover no-margins table-striped">
                            <thead>
                                <tr>
                                    <th width="20%">Status</th>
                                    <th width="70%">Request Details</th>
                                    <th width="10%" align="right"><button class="btn btn-danger btn-xs" type="button" onclick="cancelAllRequestCurrentDate()"><i class="fa fa-times m-r-xs"></i>Cancel All</button></td>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $dateNow = Date('Y-m-d');
                                $resultAppointments = mysqli_query($conn, "SELECT *, request.id AS requestId, request.user_id AS userId, document.name AS documentName FROM request INNER JOIN document on request.document_id = document.id WHERE DATE(request.pickup_date) = '$dateNow' AND (request.status = 'FOR RELEASING' OR (request.status = 'CANCELLED' AND request.is_cancelled_by_admin = false))");
                                if(mysqli_num_rows($resultAppointments)>0) {
                                    while ($row = mysqli_fetch_array($resultAppointments)) {
                                        $userId = $row['userId'];
                                        $userQry = mysqli_query($conn, "SELECT * FROM student_registration where id = $userId");
                                        $user = mysqli_fetch_array($userQry);
                                        $userFullName = getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true);
                                        $statusStr = "";
                                        $warningClass = "";
                                        $actionButton = "";
                                        if($row['status'] == 'FOR RELEASING') {
                                            $statusStr = "<span class=\"label label-primary\">For Releasing</span>";
                                            $actionButton = "<button class=\"btn btn-danger btn-xs\" type=\"button\" onclick=\"updateRequestSchedule('CANCELLED', '". $row['requestId'] ."', '" . $userFullName . "')\"><i class=\"fa fa-times m-r-xs\"></i>Cancel</button>";
                                        }
                                        else {
                                            $statusStr = "<span class=\"label label-danger\">Cancelled</span>";
                                            $warningClass = "warning";
                                        }
                            ?>
                                <tr class="<?= $warningClass ?>">
                                    <td><?= $statusStr ?></td>
                                    <td><?= "<b>" . $userFullName . "</b><br>" .$row['documentName'] ?></td>
                                    <td align="right"><?= $actionButton?></td>
                                </tr>
                            <?php
                                    }
                                }else {
                            ?>
                                    <tr>
                                        <td colspan="4" align="center"><i>No appointments today.</i></td>
                                    </tr>
                            <?php        
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Your Calendar</h5>
                </div>
                <div class="ibox-content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="modal inmodal fade" id="modalRequestSchedule" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content col-sm-12 no-padding">
            <form role="form" action="#">
                <div class="modal-header col-sm-12 p-xs">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="divModalTitleSchedule"></h4>
                    <small class="font-bold">Fill up the following.</small>
                </div>
                <div class="modal-body text-left col-sm-12 p-xs">    
                    <div class="col-sm-12">                            
                        <div class="col-sm-8">
                            <div class="form-group" id="data_1">
                                <label class="font-normal"><b>Set Date for Pickup</b></label>
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" id="txtDatePickUp" name="txtDatePickUp" value="" placeholder="MM/dd/yyyy">
                                </div>
                            </div>
                        </div>      
                        <div class="col-sm-4">                                        
                            <button type="button" class="btn btn-primary btn-md m-t-md block" onClick="$('#calendar2').toggleClass('hidden');$('#calendar2 > div.fc-toolbar > div.fc-left > button').click()"> <i class="fa fa-calendar m-r-xs"></i>Show Calendar</button>
                        </div>                              
                        <div class="col-sm-12">
                            <div id="calendar2" class="hidden"></div>
                        </div>
                        <table class="table table-striped">
                            <tr>
                                <td colspan="3" align="center"><b>Details of Request</b></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Requested By</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"><i class="fa fa-user m-r-xs"></i> <div id="divFullNameSchedule"></div></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Document Requested</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"><i class="fa fa-file m-r-xs"></i> <div id="divDocumentRequestedSchedule"></div></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Date Requested</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"> <i class="fa fa-calendar m-r-xs"></i> <div id="divDateRequestedSchedule"></div></td>
                            </tr>                                            
                            <tr>
                                <td width="30%"><b>Date Approved</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"> <i class="fa fa-calendar m-r-xs"></i> <div id="divDateApprovedSchedule"></div></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Date for Pickup</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"> <i class="fa fa-calendar m-r-xs"></i> <div id="divDatePickupSchedule"></div></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Current Status</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"><div id="divStatusSchedule"></div></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Remarks</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"><div id="divRemarksSchedule"></div></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Purpose</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"><div id="divPurposeStrSchedule"></div></td>
                            </tr>
                            <tr>
                                <td width="30%"><b>Attachments</b></td>
                                <td width="1%"><b>:</b></td>
                                <td width="69%" class="fix-request-content"><div id="divAttachmentSchedule"></div></td>
                            </tr>
                        </table>
                    </div>
                    <div class="clearfix"></div>
                </div>        
                <div class="modal-footer col-sm-12 p-xs m-t-md">
                    <div id="divActionsSchedule"></div>
                </div>
            </form>                                                
        </div>
    </div>                                        
    <div class="clearfix m-b-lg"></div>
</div>

<!-- START | FOOTER -->
<?php include('home-footer.php'); ?>
<!-- END | FOOTER -->

<script>

    $('#calendar2').fullCalendar({
        header: {
            left: 'prev,next today',
            right: 'title'
        },
        contentHeight: 'auto',
        droppable: false, // this allows things to be dropped onto the calendar
        eventLimit: true,
        eventLimitText: "Schedule",
        eventOrder: "id",
        views: {
            timeGrid: {
                eventLimit: 2
            }
        },
        events: [
        <?php                    
            $evenTitle = "";
            $eventColor = "#7d8589";
            $settingsQry = mysqli_query($conn,"SELECT * from settings");
            $settingsResult = mysqli_fetch_array($settingsQry);
            $counter = 1;
            
            $datesResult = mysqli_query($conn,"SELECT pickup_date FROM request WHERE (status = 'FOR RELEASING' OR status = 'COMPLETED') AND DATE(pickup_date) > NOW() GROUP BY pickup_date");

            if(mysqli_num_rows($datesResult)>0) {
                while ($day = mysqli_fetch_array($datesResult)) {
                    $date = $day['pickup_date'];
                    $result = mysqli_query($conn,"SELECT * FROM request WHERE status = 'FOR RELEASING' AND DATE(pickup_date) = '$date'");
                    if(mysqli_num_rows($result) == $settingsResult['max_count_of_request_per_day']) {
                        $evenTitle = "Fully Booked";
                        $eventColor = "#ed5565";
                    }
                    else {
                        $evenTitle = mysqli_num_rows($result) . " Booked";
                    }
                    // THIS IS FOR THE SEPARATOR
                    if($counter < 1) {
                        echo ',';
                    }
        ?>
                    {
                        color: '<?= $eventColor?>',
                        title: '<?= $evenTitle?>',
                        start: new Date('<?=date('d M Y', strtotime($date))?>'),
                        allDay: true
                                        
                    }
        <?php
                    $counter--;
                }
            }
        ?>
        ]
    });

    function confirmRequestSchedule(id) {
        var datePickUp = $("#txtDatePickUp").val();
        var dateReg = /^\d{2}\/\d{2}\/\d{4}$/;

        var dateEntered = new Date(datePickUp);
        var now = new Date();
        now.setHours(0,0,0,0);

        if(datePickUp === "") {
            swal("Empty Date!", "Please provide Date for Pickup.", "error");
        }
        else if(!dateReg.test(datePickUp)) {
            swal("Invalid Date!", "Please provide Date for Pickup in a format of MM/dd/yyyy.", "error");
        }
        else if(dateEntered < now) {
            swal("Invalid Date!", "Cannot set date that is in the past.", "error");
        }
        else {
            $.ajax({
                type: 'POST',
                url: 'backend/student-request-schedule-update.php',
                data: {
                    requestId: id,                
                    txtDatePickUp: datePickUp
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response.msgType == "success") {
                        swal("Success", response.msgStr, "success");
                        $("#modalRequestSchedule").modal("hide");
                        setTimeout(function() {
                            location.reload();
                        }, 2500);
                        
                    }
                    else {                    
                        swal("Invalid", response.msgStr, "error");
                    }
                
                }
            }); 
        }
        
    }

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            right: 'title'
        },
        droppable: false, // this allows things to be dropped onto the calendar
        eventRender: function(event, element){
            var status = "";
            if(event.priority == 1) {      
                status = "<span class=\"label label-success m-b-md\">For Approval</span>";
            }
            else if(event.priority == 2) {   
                status = "<span class=\"label label-primary m-b-md\">For Releasing</span>";
            }
            else if(event.priority == 3) {   
                status = "<span class=\"label label-warning m-b-md\">Resubmission</span>";
            }
            else if(event.priority == 4) {  
                status = "<span class=\"label label-danger m-b-md\">Cancelled</span>";
            }

            element.popover({
                animation:true,
                html: true,
                delay: 300,
                content: "<b>" + event.title + "</b><br>" + status + " "+event.start.format('DD MMMM YYYY'),
                trigger: 'hover',                
                placement: 'bottom',
                container: 'body'
            });
        },
        events: [
        <?php                    
            $evenTitle = "";
            $counter = 1;
            $results = mysqli_query($conn, "SELECT *, request.id AS requestId, document.name AS documentName FROM request INNER JOIN document on request.document_id = document.id");
                                

            if(mysqli_num_rows($results)>0) {
                while ($row = mysqli_fetch_array($results)) {
                    $priority = 0;
                    $evenTitle = $row['documentName'];
                    $dateStr = "";
                    if($row['status'] == 'FOR APPROVAL') {     
                        $priority = 1;
                        $eventColor = "#1c84c6";        
                        $dateStr = date('d M Y', strtotime($row['request_date']));   
                    }
                    else if($row['status'] == 'FOR RELEASING') {   
                        $priority = 2;           
                        $eventColor = "#1ab394"; 
                        if($row['pickup_date'] != '') {
                            $dateStr = date('d M Y', strtotime($row['pickup_date']));
                        }
                        else {                            
                            $dateStr = date('d M Y', strtotime($row['approved_date']));
                        }
                    }
                    else if($row['status'] == 'RESUBMISSION') {                          
                        $priority = 3;
                        $eventColor = "#f7a54a"; 
                        if($row['approved_date'] != '') {
                            $dateStr = date('d M Y', strtotime($row['approved_date']));
                        }
                        else {                            
                            $dateStr = date('d M Y', strtotime($row['request_date']));
                        }
                    }
                    else if($row['status'] == 'CANCELLED')  {
                        $priority = 4;
                        $eventColor = "#ed5565"; 
                        if($row['pickup_date'] != '') {
                            $dateStr = date('d M Y', strtotime($row['pickup_date']));
                        }
                        else if($row['approved_date'] != '') {                       
                            $dateStr = date('d M Y', strtotime($row['approved_date']));
                        }
                        else {                            
                            $dateStr = date('d M Y', strtotime($row['request_date']));
                        }
                    }

                    if($counter < 1) {
                        echo ',';
                    }
        ?>
                    {
                        priority: <?= $priority?>,
                        color: '<?= $eventColor?>',
                        title: '<?= $evenTitle?>',
                        start: new Date('<?=$dateStr?>'),
                        allDay: true
                                        
                    }
        <?php
                    $counter--;
                }
            }
        ?>
        ]
    });

    function cancelAllRequestCurrentDate() {
	    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
        $.ajax({
                type: 'POST',
                url: 'backend/admin-request-cancel-all.php',
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response.msgType == "success") {
                        swal("Success", response.msgStr, "success");
                        setTimeout(function() {
                            location.reload();
                        }, 2500);
                        
                    }
                    else {                    
                        swal("Invalid", response.msgStr, "error");
                    }
	                $('#ibox').children('.ibox-content').toggleClass('sk-loading');
                }
            }); 
    }

    $(".spanTodayDate").text(moment().format('DD MMMM YYYY'))
</script>

