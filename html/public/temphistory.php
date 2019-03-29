<?php

$con = mysql_connect("localhost","pool_select","poolselect");
if (!$con) {
die('Could not connect: ' . mysql_error());
}
mysql_select_db("knappe") or die("Could not select database");

setlocale (LC_ALL, 'de_DE');

/*
$result = mysql_query("SELECT temperaturedate,vorlauf,ruecklauf,outdoor,solar,outdoor, automatic,pumpe, bypass FROM pooltemp order by temperaturedate desc limit 300") or die ("Connection error");
*/
$result = mysql_query("SELECT temperaturedate,vorlauf,ruecklauf,outdoor,solar,outdoor, automatic,pumpe, bypass FROM pooltemp where temperaturedate > date_sub(now(),interval 60 day) order by temperaturedate") or die ("Connection error");

  while($arrChart_ROW = mysql_fetch_row($result)) {
  		$time = strtotime($arrChart_ROW[0]. ' GMT');
        $zeit=(int)$time*1000;
       	$vorlauf=(float)$arrChart_ROW[1];
       	$ruecklauf=(float)$arrChart_ROW[2];
      	$outdoor=(float)$arrChart_ROW[3];
        $solar=(float)$arrChart_ROW[4];
        $schuppen=(float)$arrChart_ROW[5];
        $automatic=(float)$arrChart_ROW[6];
        $pumpe=(float)$arrChart_ROW[7];
        $bypass=(float)$arrChart_ROW[8];
       	$arrChart[]=array('zeit' => $zeit, 'vorlauf' =>  $vorlauf, 'ruecklauf' => $ruecklauf, 'outdoor' =>  $outdoor, 'solar' =>  $solar, 'schuppen' =>  $schuppen,'automatic' =>  $automatic , 'pumpe' =>  $pumpe, 'bypass' =>  $bypass);
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

