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

        #modalRequestDetails {
            padding-left: 0px !important;
        }

        select.form-control{
            display: inline;
            width: 200px;
            margin-left: 25px;
            padding: 0px 10px !important;
            height: 30px;
        }

        #dataTables-example > tbody > tr > td > div > ul.dropdown-menu {
            margin-left: -100px !important;
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
        <h2>Student Registration</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#" name="pages/admin/home.php" onClick="setPage(this, 'DASHBOARD')">Home</a>
            </li>
            <li class="active">
                <strong>Student Registration</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content">    
    <div class="row animated fadeInDown">
        <div class="col-lg-12">
            <div id="ibox" class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Student Registration List</h3>  
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
                        <img id="imgProfilePicture" src="../images/pp2.jpg" style="width: 15%; border:1px solid #3333;border-radius:50%;">
                        <h2 id="txtFullName"></h2><br>
                    </div>
                </div>
                <div class="modal-body text-left col-sm-12 p-xs">                     
                    <div class="col-lg-12">             
                        <div class="ibox-content" style="border-top:0px"> 
                            <table class="table table-striped">
                                <tr>
                                    <td width="30%"><b>Last Name</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtLastName"></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>First Name</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtFirstName">arvin</td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Middle Name</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtMiddleName"></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>LRN</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtLRN"></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Email Address</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtEmailAddress"></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Cellphone No.</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtCpNumber"></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Password</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%"><input type="password" id="txtPassword" value="" disabled style="border: 0px !important;" />
                                        <a style="float: right !important; margin-right: 5px !important;" href="#" onclick="showPassword()">
                                            <i id="iconPassword" style="color: #777 !important" class="fa fa-eye-slash fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Current Status</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtStatus"></td>
                                </tr>
                                <tr>
                                    <td width="30%"><b>Actions</b></td>
                                    <td width="1%"><b>:</b></td>
                                    <td width="69%" id="txtActions"></td>
                                </tr>
                            </table>
                            <div class="clearfix"></div>
                        </div>                       
                    </div>
                    <div class="clearfix"></div>
                </div>        
                <div class="modal-footer col-sm-12 p-xs">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
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
        $(document).ready(function() {
            $('#cboDocument').change(function() {
                var documentSelected = $(this).val();
                $("#divPurpose").hide();
                $("#divUploadRequestForm").hide();
                if (documentSelected === "Certificate of Enrollment" || documentSelected === "Certificate of Good Moral") {                   
                    $("#divPurpose").show();
                }
                else if (documentSelected === "Form 137") {
                    $('label[for="btnUploadAttachment"]').html("<b>Upload Request Form School <span class=\"text-danger\">*</span></b>");
                    $("#divUploadRequestForm").show();
                }
                else {
                    $('label[for="btnUploadAttachment"]').html("<b>Upload School ID <span class=\"text-danger\">*</span></b>");
                    $("#divUploadRequestForm").show();
                }
            });

            $('#dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,  
                "searching": true,
                "order": [[ 0, "asc" ], [ 2, "asc" ], [ 3, "asc" ],[ 4, "asc" ]],   
                "data": [
                <?php
	                include('dbcon.php');
	                include('util.php');
                    $result = mysqli_query($conn, "SELECT * FROM student_registration ORDER BY updated_timestamp");
                    $counter = 1;
                    if(mysqli_num_rows($result)>0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $priority = 0;
                            $actionStr = '<div class=\"btn-group\"> ' .
                                        '<button data-toggle=\"dropdown\" class=\"btn btn-warning btn-xs dropdown-toggle\" aria-expanded=\"true\">Action <span class=\"caret\"></span></button>' .
                                        '<ul class=\"dropdown-menu dropdown-menu-right\">' .
                                        '   <li><a href=\"#\" onclick=\"viewStudentRegistration(\'' . $row['lrn'] . '\')\"><i class=\"fa fa-list m-r-xs\"></i>View Details</a></li>';
                            if($row['status'] == 'FOR APPROVAL') {
                                $actionStr = $actionStr . '    <li><a href=\"javascript:void(0)\" onClick=\"updateStatus(\'APPROVED\', \'' . $row['id'] . '\')\"><i class=\"fa fa-check m-r-xs\"></i>Approve</a></li>' .
                                              '    <li><a href=\"javascript:void(0)\" onClick=\"updateStatus(\'DECLINED\', \'' . $row['id'] . '\')\"><i class=\"fa fa-times m-r-xs\"></i>Decline</a></li>';
                            }
                            $actionStr = $actionStr . "</ul></div>";
                            $statusStr = '<span class=\"label label-success\">For Approval</span>';
                            if($row['status'] == 'ACTIVE') {
                                $priority = 1;
                                $statusStr = '<span class=\"label label-muted\">Active</span>';
                            }
                            else if($row['status'] == 'INACTIVE') {
                                $priority = 2;
                                $statusStr = '<span class=\"label label-danger\">Inactive</span>';
                            }
                            else if($row['status'] == 'DECLINED') {
                                $priority = 3;
                                $statusStr = '<span class=\"label label-muted text-danger\">Declined</span>';
                            }
                            
                            if($counter < 1) {
                                echo ',';
                            }
                        ?>
                        {
                            "priority": <?=$priority?>,
                            "status": "<?=$statusStr?>",
                            "lrn": "<?=$row['lrn']?>",
                            "lastName": "<?=$row['last_name']?>",      
                            "firstName": "<?=$row['first_name']?>",     
                            "middleName": "<?=$row['middle_name']?>",      
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
                        {"data": "status", "title": "Status", "width": "13%"},
                        {"data": "lrn", "title": "Student LRN", "width": "15%"},
                        {"data": "lastName", "title": "Last Name", "width": "20%"},
                        {"data": "firstName", "title": "First Name", "width": "20%"},
                        {"data": "middleName", "title": "Middle Name", "width": "19%"},                     
                        {"data": "action", "title": "", "width": "10%"}
                ],
                "createdRow": function( row, data, dataIndex ) {
                    $(row).closest("tr").find('td:eq(0)').css("color", "transparent");
                },
                "initComplete": function() {
                    var column = this.api().column(0);
                    var values = [0, 1, 2, 3];
                    var valuesStr = ["For Approval", "Active", "Inactive", "Declined"];

                    $('<select id="categoryFilter" class="form-control"><option value="">Show All</option></select>').append(values.sort().map(function(o) {
                        return '<option value="' + o + '">' + valuesStr[values.indexOf(o)] + '</option>';
                        })).on('change', function() {
                        column.search(this.value ? '\\b' + this.value + '\\b' : "", true, false).draw();
                        })
                        .appendTo('#dataTables-example_filter.dataTables_filter');
                    }
                }
            );
           
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

                $("#btnUploadAttachment").change(function(){
                    readURL(this);
                }); 

        });

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
        
        function submitRequest() {
            $("#modalRequestDetails").modal("hide");
            swal("Request Submitted!", "Your document request was been sent to registrar.", "success");
        }

        function viewStudentRegistration(lrn) {
	        $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: 'POST',
                url: 'backend/student-registration-view.php',
                data: {
                    studentLRN: lrn
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    $("#txtFullName").html(response.fullName);
                    $("#txtLastName").html(response.lastName);
                    $("#txtFirstName").html(response.firstName);
                    $("#txtMiddleName").html(response.middleName);
                    $("#txtEmailAddress").html(response.emailAddress);
                    $("#txtCpNumber").html(response.cpNumber);
                    $("#txtLRN").html(response.lrn);
                    $("#txtPassword").val(response.password);
                    $("#txtStatus").html(response.statusStr);
                    $("#txtActions").html(response.actionsStr);
                    $("#imgProfilePicture").attr("src", response.profilePicture);
                    $("#modalRequestDetails").modal("show");
	                $('#ibox').children('.ibox-content').toggleClass('sk-loading');
                }           
            }); 
        }

        function updateStatus(status, userId) {            
	        $('#ibox').children('.ibox-content').toggleClass('sk-loading');
            $.ajax({
                type: 'POST',
                url: 'backend/student-registration-update-status.php',
                data: {
                    statusStr: status,
                    userIdStr: userId
                },
                success: function (response) {
                    console.log(response);
                    response = JSON.parse(response);
                    if(response.msgType == "success") {
                        swal(response.msgTitle, response.msgStr, "success");
                        setTimeout(function() {
                            location.reload();
                        }, 2500);
                    }
                    else {                    
                        swal(response.msgTitle, response.msgStr, "error");
                    }   
                    $('#ibox').children('.ibox-content').toggleClass('sk-loading');      
                }
            });         
        }
                
    </script>
    
    </body>
</html>