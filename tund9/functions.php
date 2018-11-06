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
 function getuserprofile($userId){
	$userprofile = array();
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	
	$stmt = $mysqli->prepare("SELECT description, txtcolor, bgcolor FROM vpuserprofiles WHERE id = ?");
	echo $mysqli -> error;
		
	$stmt->bind_param("i", $userId);
	$stmt->bind_result($descriptionFromDb, $foregroundFromDb, $backgroundFromDb);
	$stmt->execute();
	$stmt->fetch();
		
	// Set values to array
	array_push($userprofile, $descriptionFromDb, $foregroundFromDb, $backgroundFromDb);
		
	$stmt->close();
	$mysqli->close();
	return $userprofile;
}
	
function setuserprofile($userId, $description, $foreground, $background){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("REPLACE INTO vpuserprofiles (userid, description, foreground, background) VALUES (?, ?, ?, ?)"); 
	echo $mysqli -> error;
		
	$stmt->bind_param("isss", $userId, $description, $foreground, $background);
	$stmt->execute();
		
	$stmt->close();
	$mysqli->close();
	return $notice;
}
 function readallvalidatedmessagesbyuser(){
	 $msghtml="";
	 $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	 $stmt=$mysqli->prepare("SELECT id, firstname, lastname FROM vpusers");
	 echo $mysqli->error;
	 $stmt->bind_result($idFromDb, $firstnameFromDb, $lastnameFromDb);
	 $stmt2=$mysqli->prepare("SELECT message, accepted FROM vpamsg WHERE acceptedby=?");
	 $stmt2->bind_param("i", $idFromDb);
	 $stmt2->bind_result($msgFromDb, $acceptedFromDb);
	 
	 $stmt->execute();
	 //et saadud tulemus püsiks ja oleks kasutatav ka j'rgmises päringus(stmt2)
	 $stmt->store_result();
	 
	 while($stmt->fetch()){
	  $msghtml .= "<h3>" .$firstnameFromDb. " " .$lastnameFromDb. "</h3> \n"; 
	  $stmt2->execute();
	  while($stmt2->fetch()){
		 $msghtml .= "<p><b>";
		 if($acceptedFromDb==1){
		  $msghtml .="Lubatud: ";
		 } else {
		  $msghtml .="Keelatud: ";
		 }
	    $msghtml .="</b>" .$msgFromDb. "</p> \n";
		 }
	  }
	 $stmt2->close();
	 $stmt->close();
	 $mysqli->close();
	return $msghtml;
 }
 function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, lastname, email FROM vpusers WHERE id !=?");
	
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $lastname, $email);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$firstname ." " .$lastname .", kasutajatunnus: " .$email ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "<p>Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function allvalidmessages(){
	$html = "";
	$accepted= 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT message FROM vpamsg WHERE accepted=?");
	echo $mysqli->error;
	$stmt->bind_param("i", $accepted);
	$stmt->bind_result($msg);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= "<p>" .$msg ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	if(empty($html)){
		$html = "<p>Kontrollitud sõnumeid pole.</p>";
	}
	return $html;
  }
  
  function validatemsg($editId, $validation){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE vpamsg SET acceptedby=?, accepted=?, accepttime=now() WHERE id=?");
	$stmt->bind_param("iii", $_SESSION["userId"], $validation, $editId);
	if($stmt->execute()){
	  echo "Õnnestus";
	  header("Location: validatemsg.php");
	  exit();
	} else {
	  echo "Tekkis viga: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
  }
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
  function signup($name, $surname, $email, $gender, $birthDate, $password){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//kontrollime, ega kasutajat juba olemas pole
	$stmt = $mysqli->prepare("SELECT id FROM vpusers WHERE email=?");
	echo $mysqli->error;
	$stmt->bind_param("s",$email);
	$stmt->execute();
	if($stmt->fetch()){
		//leiti selline, seega ei saa uut salvestada
		$notice = "Sellise kasutajatunnusega (" .$email .") kasutaja on juba olemas! Uut kasutajat ei salvestatud!";
	} else {
		$stmt->close();
		$stmt = $mysqli->prepare("INSERT INTO vpusers (firstname, lastname, birthdate, gender, email, password) VALUES(?,?,?,?,?,?)");
    	echo $mysqli->error;
	    $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	    $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	    $stmt->bind_param("sssiss", $name, $surname, $birthDate, $gender, $email, $pwdhash);
	    if($stmt->execute()){
		  $notice = "ok";
	    } else {
	      $notice = "error" .$stmt->error;	
	    }
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