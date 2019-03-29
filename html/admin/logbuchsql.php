<?php
		$suche = strip_tags ($_GET["suche"]);
		$was = strip_tags ($_get['was']);
		$was1 = strip_tags ($_get['was1']);
		//$suche = $_get["suche"];
		//echo $suche;
		//echo $was;
		//echo $was1;
		//console.log $suche;
		$conn = mysql_connect("localhost","pool_select","poolselect");
	  	$db   = mysql_select_db('knappe');
		$result = mysql_query("SELECT * FROM poollog $suche order by datum desc limit 200;") or die ("Connection error");
		while($arrChart_ROW = mysql_fetch_row($result)) {
//		   		$datum 		=$arrChart_ROW[0];
				$datum		= date('d.m.Y H:i:s', strtotime($arrChart_ROW[0]));
		       	$job		=$arrChart_ROW[1];
		       	$status		=$arrChart_ROW[2];
		      	$bemerkung	=mb_convert_encoding($arrChart_ROW[3],'UTF-8', 'ISO-8859-1');
      
       	$arrChart[]=array('Datum' => $datum ,'Job'  => $job,'Status' => $status,'Bemerkung' => $bemerkung);
   }
   echo json_encode(array("result" =>$arrChart));
   
mysql_close($conn);

?>