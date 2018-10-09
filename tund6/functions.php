<?php
 require("../../../config.php");
 $database="if18_martin_ja_1";
 //echo $serverHost;

 //kasutan sessiooni
 session_start();
 //valideerimata sõnumite nimekiri
 
 //sql käsk andmete uuendamiseks
 //UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?
 
 //valitud sõnumi lugemine valideerimiseks
 function readmsgforvalidation($editId){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE id = ?");
	$stmt->bind_param("i", $editId);
	$stmt->bind_result($msg);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = $msg;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
 
 function readallunvalidatedmessages(){
	 $notice="<ul> \n";
	 $mysqli= new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	 $stmt=$mysqli->prepare("SELECT id, message FROM vpamsg WHERE accepted IS NULL");
	 //SELECT id, message FROM vpamsg WHERE accepted IS NULL ORDER BY id DESC
	 echo $mysqli->error;
	 $stmt->bind_result($msgid, $msg);
	 if($stmt->execute()){
		 while ($stmt->fetch()){
		 $notice .= "<li>" .$msg .'<br><a href="validatemessage.php?id=' . $msgid .'">Valideeri</a></li>' ."\n";
		 }
	 } else {
	 $notice .= "<li>Sõnumite lugemisel tekkis viga." .$stmt->error."</li> \n";
	 }
	 $notice .= "</ul> \n";
	 $stmt->close();
	 $mysqli->close();
	 return $notice;
 }
 //sisselogimine
 function signin($email, $password){
	 $notice="";
	 $mysqli= new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	 $stmt=$mysqli->prepare("SELECT id, firstname, lastname, password FROM vpusers WHERE email=?");
	 echo $mysqli->error;
	 $stmt->bind_param("s", $email);
	 $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb, $passwordFromDb);
	 if($stmt->execute()){
		 //andmebaasi päring õnnestus
		 if($stmt->fetch()){
			 //kasutaja on olemas
			 if(password_verify($password, $passwordFromDb)){
				 //parool õige
				 $notice= "Olete sisse loginud!";
				 //määrame sessioonimuutujad
				 $_SESSION["userId"] = $idFromDb;
				 $_SESSION["firstName"] = $firstnameFromDb;
				 $_SESSION["lastName"] = $lastnameFromDb;
				 $stmt->close();
				 $mysqli->close();
				 header("Location: main.php");
				 exit();
				 
				 
			 } else {
				 $notice="Kahjuks vale salasõna!";
		}
		 } else {
			 $notice="Kahjuks sellise kasutajatunnusega (" .$email .") kasutajat ei leitud.";
		 }
	 } else {
		 $notice="Sisselogimisel tekkis viga" .$stmt->error;
	 }
	
	 $stmt->close();
	 $mysqli->close();
	 return $notice;
 }
 function signup($firstName, $lastName, $birthDate, $gender, $email, $password){
	$notice="";
	$mysqli= new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"],$GLOBALS["serverPassword"],$GLOBALS["database"]);
	$stmt=$mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
	echo $mysqli->error;
	//KRÜPTEerime parooli
	$options= ["cost"=>12, "salt"=>substr(sha1(mt_rand()), 0, 22)];
	$pwdhash= password_hash($password, PASSWORD_BCRYPT, $options);
	$stmt->bind_param("sssiss", $firstName, $lastName, $birthDate, $gender, $email, $pwdhash);
	if($stmt->execute()){
	  $notice= "Kasutaja loomine õnnestus!";
	} else {
	  $notice= "Kasutaja loomisel tekkis viga: " .$stmt->error;
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