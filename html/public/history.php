<?php

$con = mysql_connect("localhost","pool_select","poolselect");
if (!$con) {
die('Could not connect: ' . mysql_error());
}
mysql_select_db("knappe") or die("Could not select database");

setlocale (LC_ALL, 'de_DE');

$result = mysql_query("SELECT datum, poolmin, poolmax, ruecklaufmin, ruecklaufmax, solarmin, solarmax, outdoormin, outdoormax, schuppenmin, schuppenmax, pumpentime, solartime, reinigentime, filtertime FROM poolhistory") or die ("Connection error");
  while($arrChart_ROW = mysql_fetch_row($result)) {
  		$time = strtotime($arrChart_ROW[0]. ' GMT');
        $zeit=(int)$time*1000;
       	$poolmin=(float)$arrChart_ROW[1];
       	$poolmax=(float)$arrChart_ROW[2];
       	$poolavg=((float)$arrChart_ROW[2]-(float)$arrChart_ROW[1])/2;
       	$poolavg=$poolavg + (float)$arrChart_ROW[1];

      	$ruecklaufmin=(float)$arrChart_ROW[3];
        $ruecklaufmax=(float)$arrChart_ROW[4];

        $solarmin=(float)$arrChart_ROW[5];
        $solarmax=(float)$arrChart_ROW[6];
       	$solaravg=((float)$arrChart_ROW[6]-(float)$arrChart_ROW[5])/2;
       	$solaravg=$solaravg + (float)$arrChart_ROW[5];

        $outdoormin=(float)$arrChart_ROW[7];
        $outdoormax=(float)$arrChart_ROW[8];
       	$outdooravg=((float)$arrChart_ROW[8]-(float)$arrChart_ROW[7])/2;
       	$outdooravg=$outdooravg + (float)$arrChart_ROW[7];

        $schuppenmin=(float)$arrChart_ROW[9];
        $schuppenmax=(float)$arrChart_ROW[10];
       	$schuppenavg=((float)$arrChart_ROW[10]-(float)$arrChart_ROW[9])/2;
       	$schuppenavg=$schuppenavg + (float)$arrChart_ROW[9];

        //$pumpentime=(float)$arrChart_ROW[11];
		//$pumpentime= (float)number_format((float)$arrChart_ROW[11]/60,1);

		//$pumpzeit=(float)gmdate("H.i", $arrChart_ROW[11]);
		$pumpentime=(float)gmdate("H.i", $arrChart_ROW[11]);


        //$solartime=(float)$arrChart_ROW[12];
		//$solartime= (float)number_format((float)$arrChart_ROW[12]/60,1);

		$solartime=(float)gmdate("H.i", $arrChart_ROW[12]);
        
       	$arrChart[]=array('zeit' => $zeit, 'poolmin' =>  $poolmin, 'poolmax' => $poolmax, 'poolavg' => $poolavg, 'outdoormin' =>  $outdoormin, 'outdoormax' => $outdoormax, 'outdooravg' => $outdooravg, 'solarmin' =>  $solarmin, 'solarmax' => $solarmax, 'solaravg' => $solaravg, 'schuppenmin' =>  $schuppenmin, 'schuppenmax' => $schuppenmax, 'schuppenavg' => $schuppenavg, 'solartime' => $solartime, 'pumpentime' => $pumpentime);
   }
   echo json_encode($arrChart);
mysql_close($con);

/*
sieh LInk
http://stackoverflow.com/questions/17782594/mysql-timestamp-and-javascript-time
$time = strtotime('2013-07-19 10:12:56' . ' GMT');
echo("Converting to UNIX Time: ");echo $time;
echo("Converting to JS Time: ");echo ($time*1000);
*/
?>

