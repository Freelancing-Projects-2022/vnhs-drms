<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <div class="user-image-container">
                        <img alt="image" class="user-picture" src="<?= $_SESSION['profilePicture'];?>" />
                    </div>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs text-center"> <strong class="font-bold"><?= $_SESSION['fullName']; ?></strong>
                        </span>
                        <span class="text-muted text-xs block text-center">Student <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="javascript:void(0)" name="pages/student/user-account.php" onClick="setPage(this, 'PROFILE')">Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="index.php">Logout</a></li>
                        </ul>
                </div>
                <div class="logo-element">
                    <img alt="image" class="user-picture"src="<?= $_SESSION['profilePicture'];?>" />
                </div>
            </li>    
            <?php
                $menuTitleActive = 'DASHBOARD';
                if(isset($_SESSION['menuTitle'])) {
                    $menuTitleActive = $_SESSION['menuTitle'];
                }
            ?>
            <li <?=($menuTitleActive=='DASHBOARD')?"class='active'":""?>>
                <a href="javascript:void(0)" id="btnStudentDashboard" name="pages/student/home.php" onClick="setPage(this, 'DASHBOARD')"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboard</span></a>
            </li>
            <li <?=($menuTitleActive=='REQUESTS')?"class='active'":""?>>
                <a href="javascript:void(0)" id="btnStudentRequests" name="pages/student/requests.php" onClick="setPage(this, 'REQUESTS')"><i class="fa fa-bell"></i> <span class="nav-label">Requests</span></a>
            </li>            
            <li <?=($menuTitleActive=='PROFILE')?"class='active'":""?>>
                <a href="javascript:void(0)" id="btnStudentUserAccount" name="pages/student/user-account.php" onClick="setPage(this, 'PROFILE')"><i class="fa fa-user-circle-o"></i> <span class="nav-label">Profile</span></a>
            </li>                           
            <li <?=($menuTitleActive=='LOGOUT')?"class='active'":""?>>
                <a href="index.php"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
            </li>
        </ul>

    </div>
</nav>



<script>

function setPage(el, menuTitle) {
    var name = $(el).attr('name');
    $.ajax({
        type: 'POST',
        url: 'backend/service.php',
        data: {
            currentPage: name,
            title: menuTitle
        }
    }); 
    location.reload();
}    
</script>