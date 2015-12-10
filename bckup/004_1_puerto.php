#!/usr/bin/php
<?php
include('databaseconn.php');
    set_time_limit(300);//for setting 
    $path='/nsrc/puerto';
    $ftp_server='192.168.30.192';
    $ftp_server_port="21";
    $ftp_user_name='archiver';
    $ftp_user_pass='archiver';

    // set up a connection to ftp server
    $conn_id = ftp_connect($ftp_server, $ftp_server_port); 
    // login with username and password
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

    // check connection and login result
    if ((!$conn_id) || (!$login_result)) { 
        echo "Fail</br>";
    } else {
        //echo "Success</br>";
        // enabling passive mode
        ftp_pasv( $conn_id, true );
        // get contents of the current directory
        $contents = ftp_nlist($conn_id,$path);
        // output $contents
        foreach($contents as $key => $value)
		{
  			//echo $value."</br>";
  			$res = ftp_size($conn_id, $value);
  			//echo $res."bytes</br>";

		  			

		$sql1 = "SELECT * FROM tblftpfilenames where tblftpfile =  '".$value."'";
			$result1 = mysqli_query($conn, $sql1);

		if (mysqli_num_rows($result1) > 0) {
   				 while($row = mysqli_fetch_assoc($result1)) {
  			//echo "file name: ".$row["tblftpfile"]." is existing. <br />";
            echo "Puerto: list updated.\n";
		}
  }
  else{
	$sql = "INSERT INTO tblftpfilenames (RecNum, tblAreaID, tblAreaName, tblftpfile, tblftpfilesize,FileState)
VALUES ('', '0004', '".$path."','".$value."','".$res."','0')";

if (mysqli_query($conn, $sql)) {
    //echo $value." recorded successfully<br />";
    echo "Puerto: record success.\n";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
	}
 }//for each
} //first else
mysqli_close($conn);
 ftp_close($conn_id);

    ?>