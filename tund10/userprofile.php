<?php
	require("functions.php");
	
	$notice=null;
	
	if(!isset($_SESSION["userId"])){
		header("Location: index_2.php");
		exit();
	}
	//Get profile details
	$profiledetails = getuserprofile($_SESSION["userId"]);
	
	
	// Use profile values if they exist
	if ($profiledetails != null){
		if ($profiledetails[0] != null){
			$descriptiontext = $profiledetails[0];
		}
		
		if ($profiledetails[1] != null){
			$foregroundcolor = $profiledetails[1];
			$_SESSION["foregroundcolor"] = $foregroundcolor;
		}
		
		if ($profiledetails[2] != null){
			$backgroundcolor = $profiledetails[2];
			$_SESSION["backgroundcolor"] = $backgroundcolor;
		}
	}
	
	// Set profile details on submit
	if (isset($_POST["setuserprofile"])){
		$description = test_input($_POST["description"]);
		setuserprofile($_SESSION["userId"], $description, $_POST["bgcolor"], $_POST["background"]);
		
		// Show sent data on the page
		if (isset($_POST["description"])){
			$descriptiontext = $_POST["description"];
		}
		else {
			$descriptiontext = "Pole iseloomustust lisanud.";
		}
		
		if (isset($_POST["txtcolor"])){
			$foregroundcolor = $_POST["txtcolor"];
			$_SESSION["foregroundcolor"] = $foreground;
		}
		else {
			$foregroundcolor = "#000000";
		}
		if (isset($_POST["bgcolor"])){
			$backgroundcolor = $_POST["bgcolor"];
			$_SESSION["backgroundcolor"] = $background;
		}
		else {
			$backgroundcolor = "#ffffff";
		}	
	}
	$description= "Palun lisage siia enda iseloomustus. :)";
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>
	</title>
  </head>
  <body>
    <h1>Iseloomustuse lisamine ja värvide lisamine</h1>
	<p>Selle lehe <a href="http://www.tlu.ee" target="_blank">TLÜ</a> tegin kiiruga tunnis õppimise jaoks ning ei oma mingit väärtusliku sisu.</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Lisage lühitutvustus enda kohta: </label>
	<br> <textarea rows="10" cols="80" name="description"><?php echo $description; ?></textarea> </br>
	<input type="submit" name="submitDescription" value="Salvesta lühitutvustus">
	<label>Teksti värv:</label>
		<input type="color" name="txtcolor" value="<?php echo $foregroundcolor; ?>">
		<br>
		<label>Tausta värv:</label>
		<input type="color" name="bgcolor" value="<?php echo $backgroundcolor; ?>">
		</br>
	</form>
	<hr>
	<p><?php echo $notice; ?></p>
	
</body>
</html>	