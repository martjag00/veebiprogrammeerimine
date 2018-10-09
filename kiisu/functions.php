<?php
 require("../../../config.php");
 $database="if18_martin_ja_1";
 //echo $serverHost;
 $weekdaysET="esmaspäev";"teisipäev";"kolmapäev";"neljapäev";"reede";"laupäev";"pühapäev";
 
 function addcat($catName, $catColor, $catTail){
	 $notice=null;
	 $catName=null;
	 $catColor=null;
	 $catTail="";
	$mysqli= new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	$stmt=$mysqli->prepare("INSERT INTO kiisud (nimi,v2rv,saba) VALUES(?,?,?)");
	echo $mysqli->error;
	$stmt->bind_param("ssi", $catName, $catColor, $catTail);
	if ($stmt->execute()){
	$notice= 'Andmed on edukalt salvestatud!';
	} else {
	$notice="Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
 }
 function saveamsg($msg){
	$notice="";
	//loome andmebaasiühenduse
	$mysqli= new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	//valmistan ette andmebaasikäsu
	$stmt=$mysqli->prepare("INSERT INTO vpamsg (message) VALUES(?)");
	echo $mysqli->error;
	//asendan ettevalmistatud käsus küsimärgi(d) päris andmetega
	//esimesena kirja andmetüübid, siis andmed ise
	//s - string; i- integer; d- decimal
	$stmt->bind_param("s", $msg);
	//täidame ettevalmistatud käsu
	if ($stmt->execute()){
	$notice= 'Sõnum: "' .$msg . '" on edukalt salvestatud!';
	} else {
	$notice="Sõnumi salvestamisel tekkis tõrge: " .$stmt->error;
	}
	//sulgeme ettevalmistatud käsu
	$stmt->close();
	//sulgeme ühenduse
	$mysqli->close();
	return $notice;
 }

function readallmessages(){
	$notice="";
	$mysqli= new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	$stmt=$mysqli->prepare("SELECT message FROM vpamsg");
	echo $mysqli->error;
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$notice .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
}	
 //teksti sisendi kontrollimine
 function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
 }
?>