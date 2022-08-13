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

#DataTables_Table_0 > tbody > tr > td > div > ul {
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
                <a href="#" name="pages/student/home.php" onClick="setPage(this, 'DASHBOARD')">Home</a>
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
                    <div class="ibox-tools pull-right">
                        <button type="button"  class="btn btn-primary btn-sm" onClick="openRequestDocumentModal()"><i class="fa fa-plus m-r-xs"></i>Request a Document</button>
                    </div>
                    <h3>Request List</h3>  
                </div>
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>
                    <div class="table-responsive p-md">
                        <table class="table table-hover no-margins table-striped dataTables-example"></table>
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
<div class="modal inmodal fade" id="modalUpdateRequestRequirement" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content col-sm-12 no-padding">
            <form role="form" method="POST" action="backend/student-request-requirement-update.php" enctype="multipart/form-data" novalidate>
                <div class="modal-header col-sm-12 p-xs">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Resubmit Requirement</h4>
                    <small class="font-bold">Reupload the requested requirement.</small>
                </div>
                <div class="modal-body text-left col-sm-12 p-xs">
                    <input type="hidden" name="txtRequestIdResubmit" id="txtRequestIdResubmit">
                    <table class="table table-striped">
                        <tr>
                            <td colspan="3" align="center"><b>Details of Request</b></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Requested By</b></td>
                            <td width="1%"><b>:</b></td>
                            <td width="69%" class="fix-request-content"><i class="fa fa-user m-r-xs"></i> <div id="divFullNameResubmit"></div></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Document Requested</b></td>
                            <td width="1%"><b>:</b></td>
                            <td width="69%" class="fix-request-content"><i class="fa fa-file m-r-xs"></i> <div id="divDocumentRequestedResubmit"></div></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Date Requested</b></td>
                            <td width="1%"><b>:</b></td>
                            <td width="69%" class="fix-request-content"> <i class="fa fa-calendar m-r-xs"></i> <div id="divDateRequestedResubmit"></div></td>
                        </tr>      
                        <tr>
                            <td width="30%"><b>Remarks</b></td>
                            <td width="1%"><b>:</b></td>
                            <td width="69%" class="fix-request-content"><div id="divRemarksResubmit"></div></td>
                        </tr>
                        <tr>
                            <td width="30%"><b>Attachments</b></td>
                            <td width="1%"><b>:</b></td>
                            <td width="69%" class="fix-request-content"><div id="divAttachmentStrResubmit"></div></td>
                        </tr>
                        <tr>
                            <td width="30%"></td>
                            <td width="1%"></td>
                            <td width="69%" class="fix-request-content">
                                <div id="divUploadRequestSubmitForm"></div>
                            </td>
                        </tr>
                    </table>
                    <div class="clearfix"></div>
                </div>        
                <div class="modal-footer col-sm-12 p-xs m-t-md">                    
                    <div id="divActionsResubmit"></div>
                </div>
            </form>                                                
        </div>
    </div>                                        
    <div class="clearfix m-b-lg"></div>
</div>

<!-- START | FOOTER -->
<?php include('home-footer.php'); ?>
<!-- END | FOOTER -->

<div class="modal inmodal fade" id="modalAddRequest" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content col-sm-12 no-padding">
            <form  role="form" method="POST" action="backend/student-request-add.php" enctype="multipart/form-data">
                <div class="modal-header col-sm-12 p-xs">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Request a Document</h4>
                    <small class="font-bold">Fill up the following to request a document.</small>
                </div>
                <div class="modal-body text-left col-sm-12 p-xs">
                    <input type="hidden" name="txtId" id="txtId" value="<?= $_SESSION['userId']?>">
                    <input type="hidden" name="txtRequirementName" id="txtRequirementName" value="">
                    <div class="col-sm-6">
                        <label for="cboDocument"><b>Document Name <span class="text-danger">*</span></b></label>
                        <select class="form-control m-b" name="cboDocument" id="cboDocument" required>
                            <option value="0">- Select -</option>
                            <?php
                                $result = mysqli_query($conn, "SELECT * FROM document");
                                $counter = 1;

                                if(mysqli_num_rows($result)>0) {
                                    while ($row = mysqli_fetch_array($result)) {

                            ?>
                                <option value="<?=$row['id']?>"><?=$row['name']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div id="divRequirements">
                    </div>
                    <div class="clearfix"></div>
                </div>        
                <div class="modal-footer col-sm-12 p-xs m-t-md">
                    <button type="submit" name="submit" class="btn btn-primary">Submit Request</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                </div>
            </form>  
            <div id="divPurpose" style="display:none;">
                <div class="col-sm-12">
                    <label for="taPurpose"><b>Indicate Purpose <span class="text-danger">*</span></b></label>
                    <textarea class="form-control" name="taPurpose" id="taPurpose" rows="5" placeholder="Write your purpose in requesting the document..." required></textarea>
                </div>
            </div>
            <div id="divUploadRequestForm" style="display:none;">
                <div id="divUploadImageStr" class="col-sm-12">
                        <div class="form-group">
                        <label for="btnUploadAttachment"><b>Upload Requirement<span class="text-danger">*</span></b></label>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <span class="btn btn-default btn-file">
                                    Browse… <input type="file" id="file-upload" name="uploadedFile" style="width: 10px;height: 10px;" required>
                                </span>
                            </span>
                            <input type="text" class="form-control" readonly required>
                        </div>
                    </div>                                         
                    <div class="col-sm-12 no-padding">
                        <img class="m-t-sm" id="img-upload"/>
                    </div>
                </div>   
                <script type="text/javascript">
                    // START - CHANGE IMAGE WHEN UPLOADING  < ------------------------------------------------------------------ >
                    $(document).ready(function() {
                        $(document).on('change', '.btn-file :file', function() {
                            var input = $(this),
                                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                            input.trigger('fileselect', [label]);
                        });

                        $('.btn-file :file').on('fileselect', function(event, label) {
                            var input = $(this).parents('.input-group').find(':text'),
                                log = label;
                            if( input.length ) {
                                input.val(log);
                            } else {
                                if( log ) alert(log);
                            }
                        
                        });
                        function readURL(input) {
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    $('#img-upload').attr('src', e.target.result);
                                }
                                reader.readAsDataURL(input.files[0]);
                            }
                        }

                        $("#file-upload").change(function(){
                            readURL(this);
                        }); 
                    });
                    // END - CHANGE IMAGE WHEN UPLOADING  < ------------------------------------------------------------------ >
                </script>
            </div>                                            
        </div>
    </div>                                        
    <div class="clearfix m-b-lg"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        // START - SELECTING DOCUMENT TO REQUEST < ------------------------------------------------------------------ >
        $('#cboDocument').change(function() {
            init();
            var documentSelected = $(this).val();
            if (documentSelected == 1 || documentSelected == 2) {         
                $("#divRequirements").html($("#divPurpose").html());   
                $("#txtRequirementName").val("PURPOSE ONLY");
            }
            else if (documentSelected == 4) {
                $('label[for="btnUploadAttachment"]').html("<b>Upload Request Form School <span class=\"text-danger\">*</span></b>");
                 
                $("#txtRequirementName").val("REQUEST FORM FROM SCHOOL");
                $("#divRequirements").html($("#divUploadRequestForm").html());   
            }
            else {
                $('label[for="btnUploadAttachment"]').html("<b>Upload School ID <span class=\"text-danger\">*</span></b>");
                $("#divRequirements").html($("#divUploadRequestForm").html());   
                $("#txtRequirementName").val("SCHOOL ID");
            }
        });
        // END - SELECTING DOCUMENT TO REQUEST < ------------------------------------------------------------------ >

        // START - REQUEST TABLE < ------------------------------------------------------------------ >
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,  
            "order": [[ 0, "asc" ], [ 3, "desc" ]],        
            "data": [
                <?php
                    $userId = $_SESSION['userId'];
                    $result = mysqli_query($conn, "SELECT *, request.id AS requestId, document.name AS documentName, request.is_cancelled_by_admin AS isCancelledByAdmin FROM request INNER JOIN document on request.document_id = document.id WHERE request.user_id =  $userId");
                    $counter = 1;
                    
                    if(mysqli_num_rows($result)>0) {
                        while ($row = mysqli_fetch_array($result)) {
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
                                        '   <li><a href=\"javascript:void(0)\" onclick=\"viewRequestDetails(\'' . $row['requestId'] . '\')\"><i class=\"fa fa-list m-r-xs\"></i>View Details</a></li>';
                            if($row['status'] == 'FOR RELEASING') {
                                if($row['pickup_date'] != '') {
                                    $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestSchedule( \'' . $row['requestId'] . '\')\"><i class=\"fa fa-calendar m-r-xs\"></i>Reschedule</a></li>';
                                }
                                else {
                                    $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestSchedule( \'' . $row['requestId'] . '\')\"><i class=\"fa fa-calendar m-r-xs\"></i>Set Schedule</a></li>';
                                }
                            }
                            else if($row['status'] == 'RESUBMISSION') {  
                                $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequirement( \'' . $row['requestId'] . '\')\"><i class=\"fa fa-image m-r-xs\"></i>Resubmit</a></li>'; 
                            }
                            else if($row['status'] == 'CANCELLED' || $row['status'] == 'COMPLETED') {
                                if($row['approved_date'] != '') {
                                    $approvedDateStr = date('d M Y', strtotime($row['approved_date']));
                                    $approvedDate = date('Ymd', strtotime($row['approved_date']));
                                }
                                if($row['status'] == 'CANCELLED' && $row['isCancelledByAdmin']) {
                                    $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"updateRequestSchedule( \'' . $row['requestId'] . '\')\"><i class=\"fa fa-calendar m-r-xs\"></i>Reschedule</a></li>';
                                }
                            }
                            else if($row['status'] != 'CANCELLED' && $row['status'] != 'COMPLETED' && $row['status'] != 'DECLINED')  {
                                $actionStr .= '    <li><a href=\"javascript:void(0)\" onClick=\"cancelRequest( \'' . $row['requestId'] . '\')\"><i class=\"fa fa-times m-r-xs\"></i>Cancel</a></li>';
                            }

                            $actionStr .= "</ul></div>";
                            // END - ACTION BUTTONS

                            // START - STATUS LABELS
                            $statusStr = '<span class=\"label label-muted\">Completed</span>';
                            if($row['status'] == 'CANCELLED') {
                                $priority = 1;
                                $statusStr = '<span class=\"label label-danger\">Cancelled</span>';
                            }
                            else if($row['status'] == 'FOR RELEASING') {
                                $priority = 2;
                                $statusStr = '<span class=\"label label-primary\">For Releasing</span>';
                                $approvedDateStr = date('d M Y', strtotime($row['approved_date']));
                                $approvedDate = date('Ymd', strtotime($row['approved_date']));
                            }
                            else if($row['status'] == 'RESUBMISSION') {                                
                                $priority = 1;
                                $statusStr = '<span class=\"label label-warning\">Resubmission</span>';
                            }
                            else if($row['status'] == 'DECLINED') {
                                $statusStr = '<span class=\"label label-muted text-danger\">Declined</span>';
                                $priority = 3;
                            }
                            else if($row['status'] == 'FOR APPROVAL') {
                                $priority = 3;
                                $statusStr = '<span class=\"label label-success\">For Approval</span>';
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
                    {"data": "document", "title": "Document", "width": "30%"},
                    {"data": "requestDate", "title": "Request Date", "width": "15%"},  
                    {"data": "approvedDate", "title": "Approved Date", "width": "15%"},              
                    {"data": "pickUpDate", "title": "Pick Up Date", "width": "15%"},                        
                    {"data": "action", "title": "Action", "width": "15%"}
            ],
            "createdRow": function( row, data, dataIndex ) {
                var status = $(row).closest("tr").find('td:eq(1)');
                $(row).closest("tr").find('td:eq(0)').css("color", "transparent");
            }
        });
        // END - REQUEST TABLE < ------------------------------------------------------------------ >
    });

    function init() {
        $("#divPurpose").hide();
        $("#divUploadRequestForm").hide();
        $("#img-upload").attr("src", "");
        $("#file-upload").val("");
        $(".btn-file :file").parents(".input-group").find(":text").val("");
    }

    function openRequestDocumentModal() {
        init();        
        $("#cboDocument").val(0);
        $("#modalAddRequest").modal("show");
    }
    
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
            
            $datesResult = mysqli_query($conn,"SELECT pickup_date FROM request WHERE status = 'FOR RELEASING' AND DATE(pickup_date) > NOW() GROUP BY pickup_date");

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

    // START - SUBMIT REQUEST  < ------------------------------------------------------------------ >
    function submitRequest() {
        $("#modalAddRequest").modal("hide");
        swal("Request Submitted!", "Your document request was been sent to registrar.", "success");
    }
    // END - SUBMIT REQUEST  < ------------------------------------------------------------------ >

    function viewRequestDetails(id) {
	    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
        $.ajax({
            type: 'POST',
            url: 'backend/student-request-view.php',
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

    function updateRequirement(id) {
	    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
        $.ajax({
            type: 'POST',
            url: 'backend/student-request-requirement-view.php',
            data: {
                requestId: id
            },
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                $("#txtRequestIdResubmit").val(response.requestId);
                $("#divFullNameResubmit").html(response.userFullName);;
                $("#divDocumentRequestedResubmit").html(response.documentName);
                $("#divDateRequestedResubmit").html(response.requestDate);
                $("#divAttachmentStrResubmit").html(response.documentRequirementName);
                var uploadDiv = $("#divUploadRequestForm").html();
                $("#divUploadImageStr").remove();
                $("#divAttachmentStrResubmit").html(uploadDiv);
                $("label[for='btnUploadAttachment']").html("<b>Upload Requirement <span class=\"text-danger\">*</span></b>");
                $("#img-upload").attr("src", response.documentRequirementSubmitted);
                $("#divRemarksResubmit").html(response.remarks);
                $("#divActionsResubmit").html(response.actionsStr);
                $("#modalUpdateRequestRequirement").modal(response.modalStatus);
	            $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            }
        }); 
    }

    function isWeekend(date = new Date()) {
    return date.getDay() === 6 || date.getDay() === 0;
    }

    function confirmRequestSchedule(id, dateApprovedStr) {
        var datePickUp = $("#txtDatePickUp").val();
        var dateReg = /^\d{2}\/\d{2}\/\d{4}$/;

        var dateEntered = new Date(datePickUp);
        var dateApproved = new Date(dateApprovedStr);
        var now = new Date();
        now.setHours(0,0,0,0);

       // alert(dateEntered  + " " + dateApproved  + " " + (dateEntered.getDay() - dateApproved.getDay()));
        if(datePickUp === "") {
            swal("Empty Date!", "Please provide Date for Pickup.", "error");
        }
        else if(!dateReg.test(datePickUp)) {
            swal("Invalid Date!", "Please provide Date for Pickup in a format of MM/dd/yyyy.", "error");
        }
        else if(dateEntered < now) {
            swal("Invalid Date!", "Cannot set date that is in the past.", "error");
        }
        else if(isWeekend(dateEntered)) {
            swal("Invalid Date!", "Registrar doesn't cater requests on weekends.", "error");
        }
        else if((dateEntered.getDay() - dateApproved.getDay()) == 0) {
            swal("Invalid Date!", "You can only set schedule 1 day after the confirmation date.", "error");
        }
        else {
	        $('#ibox').children('.ibox-content').toggleClass('sk-loading');
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
	                $('#ibox').children('.ibox-content').toggleClass('sk-loading');
                }
            }); 
        }
        
    }

    function cancelRequirementUpdate() {
        var uploadDiv = $("#divAttachmentStrResubmit").html();
        $("#divUploadImageStr").remove();    
        $("#divUploadRequestForm").html(uploadDiv);    
        $("#modalUpdateRequestRequirement").modal("hide");
    }

    function updateRequestSchedule(id) {
	    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
        $.ajax({
            type: 'POST',
            url: 'backend/student-request-schedule.php',
            data: {
                requestId: id
            },
            success: function (response) {
                console.log(response);
                response = JSON.parse(response);
                $("#divFullNameSchedule").html(response.userFullName);
                $("#divDocumentRequestedSchedule").html(response.documentName);
                $("#divDateRequestedSchedule").html(response.requestDate);
                $("#divDateApprovedSchedule").html(response.approvedDate);
                $("#divDatePickupSchedule").html(response.pickupDate);
                if(response.isRequirementImage == 1) {
                    $("#divPurposeStrSchedule").html("N/A");
                    $("#divAttachmentSchedule").html("<b>" + response.documentRequirementName + "</b><br><br><a href=\"" + response.documentRequirementSubmitted +"\" target=\"_blank\"><img src=\"" + response.documentRequirementSubmitted +"\" width=\"100%\"/></a>");
                }
                else {
                    $("#divPurposeStrSchedule").html(response.documentRequirementSubmitted);
                    $("#divAttachmentSchedule").html("N/A");
                }
                if(response.remarks != "") {                    
                    $("#divRemarksSchedule").html(response.remarks)
                }
                else {                    
                    $("#divRemarksSchedule").html("N/A")
                }
                $("#divStatusSchedule").html(response.statusStr);
                $("#divActionsSchedule").html(response.actionsStr);
                $("#divModalTitleSchedule").html(response.modalTitle);
                $("#modalRequestSchedule").modal(response.modalStatus);
	            $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            }
        }); 
    }

    function cancelRequest(id) {
	    $('#ibox').children('.ibox-content').toggleClass('sk-loading');
        $.ajax({
            type: 'POST',
            url: 'backend/student-request-cancel.php',
            data: {
                requestId: id,
                statusStr: 'CANCELLED'
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

    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

</script>
