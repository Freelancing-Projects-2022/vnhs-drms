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
        <h2>Settings</h2>
        <ol class="breadcrumb">
            <li>
                <a href="#" name="pages/admin/home.php" onClick="setPage(this, 'DASHBOARD')">Home</a>
            </li>
            <li class="active">
                <strong>Settings</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content">    
    <div class="row animated fadeInDown">
        <div class="col-lg-12">
            <div id="ibox" class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3>System Settings</h3>  
                </div>
                <?php
                    include("dbcon.php");
                    $query = mysqli_query($conn, "SELECT * FROM settings");                    
                    $row = mysqli_fetch_array($query);

                    $logo = "images/logo.png";
                    $systemDisplayName = "";
                    $organizationName = "";
                    $maxCountOfRequestPerDay = "";
                    if ($row != null) {                    
                        $id = $row['id'];    
                        $logo = $row['logo'];  
                        $origPicture = $row['logo'];  
                        $systemDisplayName = $row['system_display_name'];
                        $organizationName = $row['organization_name'];
                        $maxCountOfRequestPerDay = $row['max_count_of_request_per_day'];
                    }
                ?>
                <div class="ibox-content">
                    <div class="sk-spinner sk-spinner-double-bounce">
                        <div class="sk-double-bounce1"></div>
                        <div class="sk-double-bounce2"></div>
                    </div>
                    <form class="m-t" role="form" method="POST" action="backend/admin-settings-update.php" enctype="multipart/form-data">      
                        <div class="col-lg-3 text-center">                      
                            <div class="col-sm-12" style="border:1px solid #3333;padding: 4px;border-radius: 50%;overflow: hidden;">
                                <img id="img-upload" src="<?= $logo ?>" style="width: 100%; border-radius: 50%;">
                            </div>
                            <div class="col-sm-12 m-t-sm">
                                <div class="form-group" >
                                    <label for="file-upload"><b>Upload Logo<span class="text-danger">*</span></b></label>
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
                            <input type="hidden" name="txtOrigPicture" value="<?= $origPicture ?>">
                            <div class="form-group col-sm-12">
                                <label>System Display Name</label>
                                <input type="text" name="txtSystemDisplayName" placeholder="Enter System Display Name" class="form-control" value="<?= $systemDisplayName ?>" required>
                            </div>  
                            <div class="form-group col-sm-12">
                                <label>Organization Name</label>
                                <input type="text" name="txtOrganizationName" placeholder="Enter Organization Name" class="form-control" value="<?= $organizationName ?>" required>
                            </div>  
                            <div class="form-group col-sm-12">
                                <label>Maximum Number of Request per day</label>
                                <input type="text" name="txtMaxNumOfRequestPerDay" placeholder="0" class="form-control" maxlength="2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?= $maxCountOfRequestPerDay ?>" required>
                            </div> 
                            <div class="clearfix"></div>
                            <div class="form-group col-sm-12 border-top text-center">
                                <button type="submit" name="submit" class="btn btn-primary m-t-sm"><i class="fa fa-check m-r-xs"></i> Save Settings</button>  
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
</script>