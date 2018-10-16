<?php
	require("functions.php");
	
	$notice=null;
	
	if(isset($_POST["submitDescription"])){
	 if ($_POST["description"] != "Kirjuta lühitutvustus siia ..." and !empty($_POST["description"])){
		$description=test_input($_POST["descripton"]);
		$notice=saveadescription($description);
	 } else {
		$notice= "Palun kirjuta lühitutvustus!";
	 }
	}
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
	<br> <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea> </br>
	
	<input type="submit" name="submitDescription" value="Salvesta lühitutvustus">
	</form>
	<hr>
	<p><?php echo $notice; ?></p>
	
</body>
</html>	