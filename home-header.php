<!DOCTYPE html>
<html>
<head>
    <?php
    // This is the Header of the page
    // All the CSS sources are declared here

    include("dbcon.php");
    $query = mysqli_query($conn, "SELECT * FROM settings");                    
    $row = mysqli_fetch_array($query);
    $systemDisplayName = "";
    if ($row != null) {       
        $systemDisplayName = $row['system_display_name'];
    }

    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_SESSION['pageTitle']; ?> | <?=$systemDisplayName?></title>
    <!-- DEFAULT CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- FullCalendar -->
    <link href="assets/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="assets/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>

    <!-- DataTables -->
    <link href="assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
    
    <!-- Date Picker -->
    <link href="assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="assets/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">


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
        @media only screen and (max-width: 768px) {
        /* For mobile phones: */
            .footer {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">        
        <!-- START - SIDE BAR -->       
        <!-- The SideBar Menu is changing depending on the User Type of the user currently logged in -->   
        <?php            
            $sideBarLocation = "pages/student/side-bar.php";
            if($_SESSION['userGroup'] == "ADMIN") {
                $sideBarLocation = "pages/admin/side-bar.php";
            }
        ?>
        <?php include($sideBarLocation); ?>
        <!-- END - SIDE BAR -->

        <div id="page-wrapper" class="gray-bg">            
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="index.php">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>     
