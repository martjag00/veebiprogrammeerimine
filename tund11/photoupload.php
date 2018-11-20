<?php
  require("functions.php");
  
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
  
  require("classes/Photoupload.class.php");
  
  
	//$target_dir = "../vp_pic_uploads/";
	$notice= "";
	$target_dir= $picDir; //config failist
	$thumb_dir = $thumbDir;
	$thumbSize=100;
	$target_file= "";
	$uploadOk = 1;
	
	$imageNamePrefix = "vp_";
    $textToImage = "Veebiprogrammeerimine";
    $pathToWatermark = "../vp_picfiles/vp_logo_w100_overlay.png";
	
	// Check if image file is a actual image or fake image
	if(isset($_POST["submitImage"])) {
		if(!empty($_FILES["fileToUpload"]["name"])){
		
	  $myPhoto = new Photoupload($_FILES["fileToUpload"]);
		
		$myPhoto->readExif();
		if(!empty($myPhoto->photoDate)){
			$textToImage = $myPhoto->photoDate;
		} else {
			$textToImage = "Pildistamise aeg teadmata";
		}
		
		$myPhoto->makeFileName($imageNamePrefix);
		$target_file = $target_dir . $target_file_name;
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "Fail on " . $check["mime"] . " pilt.";
			//$uploadOk = 1;
		} else {
			echo "Fail ei ole pilt.";
			$uploadOk = 0;
		}
		// Check if file already exists
	if (file_exists($target_file)) {
		echo "Vabandage, selline pilt on juba olemas.";
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 2500000) {
		echo "Vabandage, pilt on liiga suur";
		$uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
		echo "Vabandage, ainlt JPG, JPEG, PNG ja GIF failid on lubatud.";
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$notice= "Vabandame, faili ülese ei laetud! Vead on: "
		.$myPhoto->errorsForUpload;
	// if everything is ok, try to upload file
	} else {
		$myphoto->readExif();
		if(!empty($myPhoto->photoDate)){
			$textToImage= $myPhoto->photoDate;
		} else{
			$textToImage= "Pildistamise aega ei saa teada";
		}
		
		$myPhoto->changePhotoSize(600, 400);
		$myPhoto->addWatermark($pathToWatermark);
		$myPhoto->addText($textToImage);
		$myPhoto->saveFile($target_file);
		$savesuccess= $myPhoto->saveFile($target_file);
		
		if($savesuccess == 1){	
			$myPhoto->createThumbnail($thumbDir; $thumbSize);
			$notice= "foto laeti üles!";
			$notice .= addPhotoData($target_file_name, $_POST["altText"], $_POST["privacy"]);
			} else {
			  notice .= "Vabandage, faili ülelaadimisel tekkis tehniline viga!";
			}
		
		}
		unset($myPhoto);
	}	
	}//kontroll
	
	
  
  //lehe päise laadimine
  $pageTitle= "Pealeht";
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
	<input type="submit" value="Lae pilt üles" name="submitImage">
</form>
	</ul>
	
  </body>
</html>