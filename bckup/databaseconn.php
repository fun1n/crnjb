<?php
//put #!/usr/bin/php if linux on top of page
//phpinfo();
$servername = "localhost";
$username = "nsrcuser";
$password = "password";
$dbname = "nsrcdbase";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?> 