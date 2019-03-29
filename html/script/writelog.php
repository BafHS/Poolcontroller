<?php

    // Prepare variables for database connection
   
    $dbusername = "pool_insert";  // enter database username, I used "arduino" in step 2.2
    $dbpassword = "poolinsert";  // enter database password, I used "arduinotest" in step 2.2
    $server = "localhost"; // IMPORTANT: if you are using XAMPP enter "localhost", but if you have an online website enter its address, ie."www.yourwebsite.com"

    // Connect to your database

    $dbconnect = mysql_connect($server, $dbusername, $dbpassword);
    $dbselect = mysql_select_db("test",$dbconnect);

    // Prepare the SQL statement

    $sql = "INSERT INTO knappe.poollog (job,status,text) VALUES ('".$_GET["job"]."','".$_GET["status"]."','".$_GET["text"]."')";    

    // Execute SQL statement

    mysql_query($sql);

?>

