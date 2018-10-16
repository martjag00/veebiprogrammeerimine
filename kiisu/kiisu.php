	<?php
	//lisan teise php faili
	require("functions.php");	
	$catName=null;
	$catColor=null;
	$catTail=null;
	$notice=null;
	
	if (isset($_POST["submitCatData"])){
	 if (!empty($_POST["catName"]) and !empty($_POST["catColor"]) and !empty($_POST["catTail"])){
		$catName = test_input($_POST["catName"]);
		$catColor = test_input($_POST["catColor"]);
		$catTail = test_input($_POST["catTail"]);
		$combined = addcat($catName, $catColor, $catTail);
	} else {
		$combined = addcat(null, null, null);
		$notice="Palun sisestage kõik andmed!";
	 }
	}
	?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>
	Kiisude andmed
	</title>
  </head>
  <body>
    <h1>
	Kiisude andmetabel
	</h1>
	<p>Palun lisage siia enda kiisu andmed.<p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Kassi nimi: </label>
	<input type="text" name="catName">
	<label>Kassi värvus: </label>
	<input type="text" name="catColor">
	<label>Kassi saba pikkus: </label>
	<input type="number" name="catTail" min="1" max="50" value="1">
	<input type="submit" name="submitCatData" value="Saada andmed">
	<hr>
	</form>
	<p><?php echo $notice; ?></p>
</body>
</html>	