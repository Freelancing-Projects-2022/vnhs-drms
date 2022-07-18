<?php
// Default Database Configuration
$conn = mysqli_connect("localhost","root","","vnhs_drms");

// Testing the connection
if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Auto Cancel appointments that is for releasing but failed to claim
mysqli_query($conn,"UPDATE request SET where status = 'CANCELLED', is_cancelled_by_admin = true WHERE DATE(pickup_date) < DATE(NOW()) AND status = 'FOR RELEASING';");

?>