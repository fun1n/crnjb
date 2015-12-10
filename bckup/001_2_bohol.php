#!/usr/bin/php
<?php
ini_set('max_execution_time', 7000);
try{
include('databaseconn.php');
$slrDate =0;
$slrTime =0;
$slrAvgUv =0;
$slrMinUv =0;
$slrMaxUv =0;
$slrAvgUvTmp =0;
$slrMinUvTmp =0;
$slrMaxUvTmp =0;
$slrAvgRad =0;
$slrMinRad =0;
$slrMaxRad =0;
$slrBatt =0;
$slrAvgSunshine =0;
$cnt=0;
$cnt2=0;

$sql1 = "SELECT * FROM tblftpfilenames WHERE FileState=0 AND tblAreaID=0001";
			$result1 = mysqli_query($conn, $sql1);

		if (mysqli_num_rows($result1) > 0) {
   				 while($row = mysqli_fetch_assoc($result1)) {
  			//echo "file name: ".$row["tblftpfile"]." is being opened. <br />";

$filename = 'ftp://archiver:archiver@192.168.30.192'.$row["tblftpfile"];
if ( file_exists($filename) && ($fp = fopen($filename, "r"))!==false ) {
$handle = fopen($filename, "r");


//$contents = fread($handle, filesize($filename));
while(! feof($handle))
  {
  	$cnt=$cnt+1;
   $parts = preg_split('/\s+/',fgets($handle));
   if($cnt>=9){
    foreach(array_values($parts) as $key => $value)
		{
   			

   			//print_r(array_values($parts));
			//echo $value."&nbsp";

			$solarv = preg_split('/\s+/',$value);

			foreach(array_values($solarv) as $data => $findata)
			{
				$cnt2=$cnt2+1;
			//	echo $findata."splitted value ".$cnt2."<br/>";

										if($cnt2==1){
										
							$datef = explode('.',$findata);
							$slrDate  = $datef[2]."-".$datef[1]."-".$datef[0]; //date, month , year


							}
										else if($cnt2==2){

							$slrTime = $findata;	
							}
										else if($cnt2==3){

							$slrAvgUv = $findata;	
							}
										else if($cnt2==4){

							$slrMinUv = $findata;	
							}
										else if($cnt2==5){

							$slrMaxUv = $findata;	
							}
										else if($cnt2==6){

							$slrAvgUvTmp = $findata;
							}
										else if($cnt2==7){

							$slrMinUvTmp = $findata;
							}
										else if($cnt2==8){

							$slrMaxUvTmp = $findata;
							}
										else if($cnt2==9){

							$slrBatt = $findata;	
							}
										else if($cnt2==10){

							$slrAvgRad = $findata;	
							}
										else if($cnt2==11){

							$slrMinRad = $findata;	
							}
										else if($cnt2==12){

							$slrMaxRad = $findata;	
							}
										else if($cnt2==13){

							$slrAvgSunshine = $findata;		
							}
			}
		}
		$sql = "INSERT INTO tblftpfiledata (RecNum, tblAreaID, slrDate, slrTime, AvgUv, MinUv, MaxUv, AvgTmpUv, MinTmpUv, MaxTmpUv, BattVolt, AvgSolRad, MinSolRad, MaxSolRad, AvgSunshine) 
										VALUES ('', '0001','".$slrDate."','".$slrTime."','".$slrAvgUv."','".$slrMinUv."','".$slrMaxUv."','".$slrAvgUvTmp."','".$slrMinUvTmp."','".$slrMaxUvTmp."','".$slrBatt."','".$slrAvgRad."','".$slrMinRad."','".$slrMaxRad."','".$slrAvgSunshine."')";

							if (mysqli_query($conn, $sql)) {
  						 // echo $value." recorded successfully<br />";
							echo "Bohol: list stored.";
								} else {
  							  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
										}
		$cnt2=0;
		$slrDate =0;
$slrTime =0;
$slrAvgUv =0;
$slrMinUv =0;
$slrMaxUv =0;
$slrAvgUvTmp =0;
$slrMinUvTmp =0;
$slrMaxUvTmp =0;
$slrAvgRad =0;
$slrMinRad =0;
$slrMaxRad =0;
$slrBatt =0;
$slrAvgSunshine =0;
	}
//		echo "line: ".$cnt."<br/>";
	
  }
 $cnt=0;

fclose($handle);
$sqla = "UPDATE tblftpfilenames SET FileState='1' WHERE tblftpfile='".$row["tblftpfile"]."'";

			if (mysqli_query($conn, $sqla)) {
			    echo "Record updated successfully";
			} else {
			    echo "Error updating record: " . mysqli_error($conn);
					}
				}//if no file
 }
}// bracket for if result is > 0
else{


	 echo "Bohol: All records are updated.";


}

mysqli_close($conn);

}catch ( Exception $e ) {

    			echo "could not connect!";

				}
?>
