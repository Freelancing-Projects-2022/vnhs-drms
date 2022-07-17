<style>
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
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>Profile</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#" name="pages/student/home.php" onClick="setPage(this, 'DASHBOARD')">Home</a>
            </li>
            <li class="active">
                <strong>Profile</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content">    
    <div class="row animated fadeInDown">
        <div class="col-lg-12">
            <div id="ibox" class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>Account Details</h3>  
                </div>
                <?php
                    include("dbcon.php");
                    unset($_FILES['uploadedFile']);
                    $userId = $_SESSION['userId'];
                    $query = mysqli_query($conn, "SELECT * FROM student_registration where id = $userId");                    
                    $row = mysqli_fetch_array($query);

                    $lastName = "";
                    $firstName = "";
                    $middleName = "";
                    $emailAddress = "";
                    $cpNumber = "";
                    $userName = "";
                    $password = "";
                    $profilePicture = "images/logo.png";
                    $origProfilePicture = "images/logo.png";
                    if ($row != null) {                    
                        $id = $row['id'];    
                        $lastName =  $row['last_name'];  
                        $firstName =  $row['first_name'];  
                        $middleName =  $row['middle_name'];  
                        $emailAddress =  $row['email_address'];  
                        $cpNumber =  $row['cp_number'];  
                        $userName =  $row['username'];  
                        $password =  $row['password'];
                        if(strlen($profilePicture) != 0) {
                            $profilePicture = $row['profile_picture'];  
                            $origProfilePicture = $row['profile_picture'];  
                        }
                    }
                ?>
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>
                    <form class="m-t" role="form" method="POST" action="backend/student-profile-update.php" enctype="multipart/form-data">      
                        <div class="col-lg-3 text-center">                      
                            <div class="col-sm-12" style="border:1px solid #3333;padding: 4px;border-radius: 50%;overflow: hidden;">
                                <img id="img-upload" src="<?= $profilePicture ?>" style="width: 100%; height: 100%; border-radius: 50%;">
                            </div>
                            <div class="col-sm-12 m-t-sm">
                                <div class="form-group" >
                                    <label for="file-upload"><b>Upload Picture<span class="text-danger">*</span></b></label>
                                    <div class="input-group">
                                        <span class="input-group-btn">
                                            <span class="btn btn-default btn-file">
                                                Browse… <input type="file" id="file-upload" name="uploadedFile" />
                                            </span>
                                        </span>
                                        <input type="text" class="form-control" readonly required>
                                    </div>
                                </div>
                            </div>    
                            <div class="clearfix"></div>
                        </div>     
                                
                        <div class="col-lg-9">     
                            <input type="hidden" name="txtId" value="<?= $id ?>">
                            <input type="hidden" name="txtOrigPicture" value="<?= $origProfilePicture ?>">
                            <div class="form-group col-sm-3">
                                <label>Last Name</label>
                                <input type="text" name="txtLastName" placeholder="Enter Last Name" class="form-control" value="<?= $lastName ?>" readonly>
                            </div>      
                            <div class="form-group col-sm-6">
                                <label>First Name</label>
                                <input type="text" name="txtFirstName" placeholder="Enter First Name" class="form-control" value="<?= $firstName ?>" readonly>
                            </div>
                            <div class="form-group col-sm-3">
                                <label>Middle Name</label>
                                <input type="text" name="txtMiddleName" placeholder="Enter Middle Name" class="form-control" value="<?= $middleName ?>" readonly>
                            </div> 
                            <div class="form-group col-sm-9">
                                <label>Email Address</label>
                                <input type="email" name="txtEmailAddress" placeholder="johndoe@gmail.com" class="form-control" value="<?= $emailAddress ?>" required>
                            </div>     
                            <div class="form-group col-sm-3">
                                <label>Cellphone Number</label>
                                <input type="text" name="txtCpNumber" placeholder="09xxxxxxxxx" class="form-control" maxlength="11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?= $cpNumber ?>" required>
                            </div>  
                            <div class="form-group col-sm-4">
                                <label>LRN</label>
                                <input type="text" name="txtUserName" placeholder="UserName" class="form-control" value="<?= $userName ?>" readonly>
                            </div>                                              
                            <div class="form-group col-sm-4">
                                <label>Password</label>
                                <input type="password" placeholder="Enter Password" class="form-control col-sm-10" id="txtPassword" name="txtPassword" onkeyup="checkPassword(this.value)" value="<?= $password ?>" required>
                            </div>                
                            <div id="frmGrpReTypePassword" class="form-group col-sm-4">
                                <label>Re-Type Password</label>
                                <input type="password" placeholder="Re-Type Password" class="form-control col-sm-10" id="txtReTypePassword" onkeyup="checkPassword(this.value)" value="<?= $password ?>" required>
                            </div>  
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-12 border-top text-center">
                                <button type="submit" name="submit" class="btn btn-primary m-t-sm"><i class="fa fa-check m-r-xs"></i> Update Profile</button>  
                            </div> 
                        </div>   
                    </form>                                
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<!-- START | FOOTER -->
<?php include('home-footer.php'); ?>
<!-- END | FOOTER -->

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('change', '.btn-file :file', function() {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {
            var input = $(this).parents('.input-group').find(':text'), log = label;
            
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
</script>