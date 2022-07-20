<?php
include('dbcon.php');
include('util.php');
?>

<style>
.disclaimer {
    display: none !important;
}
.nav-header {
    background-size: cover;
    align-items: center;
}
.user-image-container {
    width: 65% !important;
    height: 110px;
    overflow: hidden !important;
    border-radius: 50%;
    padding: 0;
    margin: 0 20%;
    border: 2px solid white;
}
.user-picture {
    width: 100%;

}
body.mini-navbar .nav-header {
    padding-left: 3px !important;
    padding-top: 1px !important;
    padding-bottom: 1px !important;
}
.logo-element {
    width: 40px;
    height: 40px;
    overflow: hidden !important;
    border-radius: 50%;
    margin: 20%;
    padding: 0 !important;
    border: 2px solid white;
}

.fc-scroller {
    overflow: hidden !important;
}

.fc-scroller {
    overflow: hidden !important;
}
.logo-element {
    padding: 10px 0;
}
.no-sort::after {
    display: none!important;
}
.no-sort { 
    pointer-events: none!important;
    cursor: default!important;
}

.btn-file {
    position: relative;
    overflow: hidden;
}
.btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}

#img-upload{
    width: 100%;
}

#modalAddRequest {
    padding-left: 0px !important;
}

.dropdown-menu-table {
    margin-left: -100px !important;
}

.fix-request-content > div {
    display: contents;
} 

#dataTables-example > tbody > tr > td > div > ul {
    margin-left: -100px !important;
}

.datepicker .cw {
    display: none;
}

@media only screen and (max-width: 768px) {
/* For mobile phones: */
    .footer {
        text-align: center;
    }
}
</style>        
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Requests</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#" name="pages/admin/home.php" onClick="setPage(this, 'DASHBOARD')">Home</a>
            </li>
            <li class="active">
                <strong>Requests</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content">    
    <div class="row animated fadeInDown">
        <div class="col-lg-12">
            <div id="ibox" class="ibox float-e-margins">
                <div class="ibox-title">       
                    <h3>Request List</h3>  
                </div>
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>
                    <div class="table-responsive p-md">
                        <table id="dataTables-example" class="table table-hover no-margins table-striped"></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<div class="modal inmodal fade" id="modalRequestDetails" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content col-sm-12 no-padding">
            <form role="form" action="#">
                <div class="modal-header col-sm-12">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <div class="col-sm-12 text-center">
                        <img id="imgProfilePicture" src="../images/no-pp.jpg" style="width: 20%; border:1px solid #3333;border-radius:50%;">
                        <h2 id="txtFullName"></h2><br>
                    </div>
                </div>
                <div class="modal-body text-left col-sm-12 p-xs">                     
                    <div class="col-lg-12">             
                        <div class="ibox-content" style="border-top:0px"> 
                            <table class="table table-striped">
                                <tr>
                                    <td width="30%"><b>Document Requested</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"><i class="fa fa-file m-r-xs"></i> <div id="divDocumentRequested"></div></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Date Requested</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"> <i class="fa fa-calendar m-r-xs"></i> <div id="divDateRequested"></div></td>
                                </tr>                                            
                                <tr>
                                    <td width="30%"><b>Date Approved</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"> <i class="fa fa-calendar m-r-xs"></i> <div id="divDateApproved"></div></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Date for Pickup</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"> <i class="fa fa-calendar m-r-xs"></i> <div id="divDatePickup"></div></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Current Status</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"><div id="divStatus"></div></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Remarks</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"><div id="divRemarks"></div></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Purpose</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"><div id="divPurposeStr"></div></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Attachments</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content"><div id="divAttachment"></div></td>
                                </tr>
                                <tr id="resubmissionRow" style="display:none;">
                                    <td width="30%"><b>Add Remarks <i>(Optional)</i></b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" class="fix-request-content">
                                        <input class="form-control" placeholder="Let the client know what you think." id="txtRemarksStr" name="txtRemarksStr"/> 
                                    </td>
                                </tr>
                            </table>
                            <div class="clearfix"></div>
                        </div>                       
                    </div>
                    <div class="clearfix"></div>
                </div>        
                <div class="modal-footer col-sm-12 p-xs">
                    <div id="divActions"></div>
                </div>
            </form>                                                
        </div>
    </div>                                        
    <div class="clearfix m-b-lg"></div>
</div>



<!-- START | FOOTER -->
<?php include('home-footer.php'); ?>
<!-- END | FOOTER -->


<script type="text/javascript">
    $(document).ready(function() {

        // START - REQUEST TABLE < ------------------------------------------------------------------ >
        $('#dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,  
            "searching": true,
            "order": [[ 4, "desc" ], [ 5, "desc" ], [ 6, "desc" ]],     
            "data": [
                <?php
                    $userId = $_SESSION['userId'];
                    $result = mysqli_query($conn, "SELECT *, request.id AS requestId, request.user_id AS userId, document.name AS documentName FROM request INNER JOIN document on request.document_id = document.id");
                    $counter = 1;
                    
                    if(mysqli_num_rows($result)>0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $userId = $row['userId'];
                            $userQry = mysqli_query($conn, "SELECT * from student_registration WHERE id = $userId");
                            $user = mysqli_fetch_array($userQry);
                            $userFullName = ucwords(strtolower(getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true)));
                            $priority = 0;
                            $documentName = $row['documentName'];
                            $requestDate = date('Ymd', strtotime($row['request_date']));
                            $requestDateStr = date('d M Y', strtotime($row['request_date']));
                            $approvedDate = '';
                            $approvedDateStr = '---';
                            $pickupDate = '';
                            $pickupDateStr = '---';
                            if($row['pickup_date'] != '') {
                                $pickupDateStr = date('d M Y', strtotime($row['pickup_date']));
                                $pickupDate = date('Ymd', strtotime($row['pickup_date']));
                            }

                            // START - ACTION BUTTONS
                            $actionStr = '<div class=\"btn-group\"> ' .
                                        '<button data-toggle=\"dropdown\" class=\"btn btn-warning btn-xs dropdown-toggle\" aria-expanded=\"true\">Action <span class=\"caret\"></span></button>' .
                                        '<ul class=\"dropdown-menu dropdown-menu-right\">' .
                                        '   <li><a href=\"javascript:void(0)\" onclick=\"viewRequestDetails(\'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-list m-r-xs\"></i>View Details</a></li>';
                            if($row['status'] == 'FOR RELEASING') {
                                if($row['pickup_date'] == '') {
                                    $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'FOR APPROVAL\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Releasing</a></li>';
                                }
                                else {
                                    $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'CANCELLED\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-times m-r-xs\"></i>Cancel</a></li>';
                                    $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'COMPLETED\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-star m-r-xs\"></i>Complete</a></li>';
                                }
                            }
                            else if($row['status'] == 'FOR APPROVAL') {
                                $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'FOR RELEASING\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-check m-r-xs\"></i>Approve</a></li>';
                                $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'DECLINED\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-times m-r-xs\"></i>Decline</a></li>'; 
                            }
                            else if($row['status'] == 'DECLINED') {
                                $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'FOR APPROVAL\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Decline</a></li>';
                            }
                            else if($row['status'] == 'RESUBMISSION') {
                                $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'FOR APPROVAL\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Resubmission</a></li>';
                            }
                            else if($row['status'] == 'CANCELLED') {
                                $requestedDate = $row['request_date'];
                                $startDate = strtotime(date('Y-m-d', strtotime($requestedDate)));
                                $currentDate = strtotime(date('Y-m-d'));
                            
                                if($row['approved_date'] != '') {
                                    $approvedDateStr = date('d M Y', strtotime($row['approved_date']));
                                    $approvedDate = date('Ymd', strtotime($row['approved_date']));
                                }

                                if($row['is_cancelled_by_admin'] && $startDate >= $currentDate) {
                                    if(($row['pickup_date'] != '')) {
                                        $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'FOR RELEASING\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Cancel</a></li>';
                                    }
                                    else {
                                        $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestStatus(\'FOR APPROVAL\', \'' . $row['requestId'] . '\', \'' . getFullName($user['last_name'], $user['first_name'], $user['middle_name'], false, true) . '\')\"><i class=\"fa fa-refresh m-r-xs\"></i>Revert Cancel</a></li>';
                                    }
                                }
                            }
                            else if($row['status'] == 'COMPLETED') {                                
                                if($row['approved_date'] != '') {
                                    $approvedDateStr = date('d M Y', strtotime($row['approved_date']));
                                    $approvedDate = date('Ymd', strtotime($row['approved_date']));
                                }
                            }
                            $actionStr .= "</ul></div>";
                            // END - ACTION BUTTONS

                            // START - STATUS LABELS
                            $statusStr = '<span class=\"label label-muted\">Completed</span>';
                            if($row['status'] == 'CANCELLED') {
                                $priority = 0;
                                $statusStr = '<span class=\"label label-danger\">Cancelled</span>';
                            }
                            else if($row['status'] == 'FOR RELEASING') {
                                $priority = 1;
                                $statusStr = '<span class=\"label label-primary\">For Releasing</span>';
                                $approvedDateStr = date('d M Y', strtotime($row['approved_date']));
                                $approvedDate = date('Ymd', strtotime($row['approved_date']));
                            }
                            else if($row['status'] == 'RESUBMISSION') {                                
                                $priority = 3;
                                $statusStr = '<span class=\"label label-warning\">Resubmission</span>';
                            }
                            else if($row['status'] == 'FOR APPROVAL') {
                                $priority = 2;
                                $statusStr = '<span class=\"label label-success\">For Approval</span>';
                            }
                            else if($row['status'] == 'APPROVED') {
                                $priority = 4;
                            }
                            else if($row['status'] == 'DECLINED') {
                                $statusStr = '<span class=\"label label-muted text-danger\">Declined</span>';
                                $priority = 5;
                            }
                            else if($row['status'] == 'COMPLETED') {
                                $priority = 5;
                            }
                            // END - STATUS LABELS

                            // THIS IS FOR THE SEPARATOR
                            if($counter < 1) {
                                echo ',';
                            }
                    ?>
                    {
                        "priority": <?=$priority?>,
                        "status": "<?=$statusStr?>",
                        "name": "<?=$userFullName?>",  
                        "document": "<?=$documentName?>",
                        "requestDate": "<span style=\"display:none;\"><?=$requestDate?></span><?=$requestDateStr?>",
                        "approvedDate":"<span style=\"display:none;\"><?=$approvedDate?></span><?=$approvedDateStr?>",     
                        "pickUpDate": "<span style=\"display:none;\"><?=$pickupDate?></span><?=$pickupDateStr?>", 
                        "action": "<?=$actionStr?>"
                                        
                    }
                <?php
                            $counter--;
                        }
                    }
                ?>
            ],
            "columns": [
                    {"data": "priority", "title": "", "width": "0%"},
                    {"data": "status", "title": "Status", "width": "10%"},
                    {"data": "name", "title": "Student Name", "width": "15%"},
                    {"data": "document", "title": "Document", "width": "20%"},
                    {"data": "requestDate", "title": "Request Date", "width": "15%"},  
                    {"data": "approvedDate", "title": "Approved Date", "width": "15%"},              
                    {"data": "pickUpDate", "title": "Pick Up Date", "width": "15%"},                        
                    {"data": "action", "title": "", "width": "10%"}
            ],
            "createdRow": function( row, data, dataIndex ) {
                var status = $(row).closest("tr").find('td:eq(1)');
                $(row).closest("tr").find('td:eq(0)').css("color", "transparent");
            },
            "initComplete": function() {
                var column = this.api().column(0);
                var values = [0, 1, 2, 3, 4];
                var valuesStr = ["Cancelled", "For Releasing", "For Approval", "Resubmission", "Completed"];

                $('<select id="categoryFilter" class="form-control"><option value="">Show All</option></select>').append(values.sort().map(function(o) {
                    return '<option value="' + o + '">' + valuesStr[values.indexOf(o)] + '</option>';
                    })).on('change', function() {
                        column.search(this.value ? '\\b' + this.value + '\\b' : "", true, false).draw();
                    })
                    .appendTo('#dataTables-example_filter.dataTables_filter');
            }
        });
        // END - REQUEST TABLE < ------------------------------------------------------------------ >
    });
    
    
    function viewRequestDetails(id) {
	    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
        $("#resubmissionRow").css("display", "none");
        $.ajax({
            type: 'POST',
            url: 'backend/admin-request-view.php',
            data: {
                requestId: id
            },
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                $("#txtFullName").html(response.userFullName);
                $("#divDocumentRequested").html(response.documentName)
                $("#divDateRequested").html(response.requestDate)
                $("#divDateApproved").html(response.approvedDate)
                $("#divDatePickup").html(response.pickupDate)
                if(response.isRequirementImage == 1) {
                    $("#divPurposeStr").html("N/A");
                    $("#divAttachment").html("<b>" + response.documentRequirementName + "</b><br><br><a href=\"" + response.documentRequirementSubmitted +"\" target=\"_blank\"><img src=\"" + response.documentRequirementSubmitted +"\" width=\"100%\"/></a>");
                    if(response.status == "FOR APPROVAL") {
                        $("#resubmissionRow").css("display", "");
                    }
                }
                else {
                    $("#divPurposeStr").html(response.documentRequirementSubmitted);
                    $("#divAttachment").html("N/A");
                }
                if(response.remarks != "") {                    
                    $("#divRemarks").html(response.remarks)
                }
                else {                    
                    $("#divRemarks").html("N/A")
                }
                $("#imgProfilePicture").attr("src", response.profilePicture);
                $("#divStatus").html(response.statusStr);
                $("#divActions").html(response.actionsStr);
                $("#modalRequestDetails").modal(response.modalStatus);
                $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            }
        }); 
    }

    function updateRequestStatus(status, id, name) {
	    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
        var remarks = $("#txtRemarksStr").val();
        $.ajax({
            type: 'POST',
            url: 'backend/admin-request-status-update.php',
            data: {
                requestId: id,
                statusStr: status,
                studentName: name,
                remarksStr: remarks
            },
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                if(response.msgType == "success") {
                swal("Success", response.msgStr, "success");
                $("#modalRequestDetails").modal("hide");
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

</script>
