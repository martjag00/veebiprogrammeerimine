<?php
  require("functions.php");
  require("classes/Photoupload.class.php");
  
  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
	  header("Location: index_2.php");
	  exit();
  }
  
  //välja logimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: index_2.php");
	  exit();
  }
  
	
	$notice= "";
	$target_dir= $picDir; //config failist
	$thumbSize=100;
	$target_file= "";
	$uploadOk = 1;
	
	$imageNamePrefix = "vp_";
    $textToImage = "Veebiprogrammeerimine";
    $pathToWatermark = "../vp_picfiles/vp_logo_w100_overlay.png";
	
	// Check if image file is a actual image or fake image
	if(isset($_POST["submitPic"])) {
		if(!empty($_FILES["fileToUpload"]["name"])){
		
	$myPhoto = new Photoupload($_FILES["fileToUpload"]);
		
		$myPhoto->makeFileName($imageNamePrefix);
		$target_file = $target_dir .$myPhoto->fileName;
		
		$uploadOk = $myPhoto->checkForImage();
		if($uploadOk == 1){
			  // kas on sobiv tüüp
			  $uploadOk = $myPhoto->checkForFileType();
			}
		if($uploadOk == 1){
			// kas on sobiv suurus
			$uploadOk = $myPhoto->checkForFileSize($_FILES["fileToUpload"], 2500000);
			}
		if($uploadOk == 1){
		  // kas on juba olemas
		  $uploadOk = $myPhoto->checkIfExists($target_file);
		}
	
		
	
	//kui tekkinud viga	
	if ($uploadOk == 0) {
			$notice = "Vabandame, faili ei laetud üles! Tekkisid vead: ".$myPhoto->errorsForUpload;
		}
	// if everything is ok, try to upload file
	} else {
		$myphoto->readExif();
		if(!empty($myPhoto->photoDate)){
			$textToImage= $myPhoto->photoDate;
		} else{
			$textToImage= "Pildistamise aega ei saa teada";
		}
		
		$myPhoto->resizeImage(600, 400);
		$myPhoto->addWatermark($pathToWatermark);
		$myPhoto->addText($textToImage);
		$saveResult= $myPhoto->savePhoto($target_file);
		
	if($saveResult == 1){
		$myPhoto->createThumbnail($thumbDir, $thumbSize);
		$notice= "foto laeti üles!";
		$notice .= addPhotoData($myPhoto->fileName, $_POST["altText"], $_POST["privacy"]);
		} else {
		$notice .= "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
		}
		
		}
		unset($myPhoto);
	}	
	//kontroll
	
	
  
  //lehe päise laadimine
  $pageTitle= "Pealeht";
    $scripts = '<script type="text/javascript" src="javascript/checkFileSize.js" defer></script>' ."\n";
  require("header.php");
?>

	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<p>Olete sisse loginud nimega : 
	<?php echo $_SESSION["firstName"] ." " .$_SESSION["lastName"]; ?> .
	</p>
	<ul>
	  <li><a href="?logout=1">Logi välja!</a></li>
	 <hr>
	 <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
    <label>Vali üleslaetav pilt:</label>
    <input type="file" name="fileToUpload" id="fileToUpload"><br>
	<label> Pildi kireljus (256 tähemärki max): </label>
	<input type="text" name="altText">
	<br>
	<label>Pildi kasutusõigused</label><br>
	<input type="radio" name="privacy" value="1"><label>Avalik</label>
	<input type="radio" name="privacy" value="2"><label>Sisseloginud kasutajatele</label>
    <input type="radio" name="privacy" value="3" checked><label>Privaatne</label>
	<br>
	<input id="submitPic" type="submit" value="Lae pilt üles" name="submitPic"><span></span>
</form>
	</ul>
	
  </body>
</html>