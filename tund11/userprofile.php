<?php
	require("functions.php");
	
	$notice=null;
	
	if(!isset($_SESSION["userId"])){
		header("Location: index_2.php");
		exit();
	}
	
	 $mydescription = "Pole tutvustust lisanud!";
   $mybgcolor = "#FFFFFF";
  $mytxtcolor = "#000000";
  
  if(isset($_POST["submitProfile"])){
	$notice = storeuserprofile($_POST["description"], $_POST["bgcolor"], $_POST["txtcolor"]);
	if(!empty($_POST["description"])){
	  $mydescription = $_POST["description"];
	}
	$mybgcolor = $_POST["bgcolor"];
	$mytxtcolor = $_POST["txtcolor"];
  } else {
	$myprofile = showmyprofile();
	if($myprofile->description != ""){
	  $mydescription = $myprofile->description;
    }
    if($myprofile->bgcolor != ""){
	  $mybgcolor = $myprofile->bgcolor;
    }
    if($myprofile->txtcolor != ""){
	  $mytxtcolor = $myprofile->txtcolor;
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<style>
	<?php
        echo "body{background-color: " .$mybgcolor ."; \n";
		echo "color: " .$mytxtcolor ."} \n";
	  ?>
	</style>
	<title>
	</title>
  </head>
  <body>
    <h1>Iseloomustuse lisamine ja värvide lisamine</h1>
	<p>Selle lehe <a href="http://www.tlu.ee" target="_blank">TLÜ</a> tegin kiiruga tunnis õppimise jaoks ning ei oma mingit väärtusliku sisu.</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Lisage lühitutvustus enda kohta: </label>
	<br> <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea> </br>
	
	<label>Teksti värv:</label>
		<input type="color" name="txtcolor" value="<?php echo $mytxtcolor; ?>">
		<br>
		<label>Tausta värv:</label>
		<input type="color" name="bgcolor" value="<?php echo $mybgcolor; ?>">
		</br>
	<input type="submit" name="submitProfile" value="Salvesta lühitutvustus">
	</form>
	<hr>
	<p><?php echo $notice; ?></p>
	
</body>
</html>	