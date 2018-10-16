	<?php
	//lisan teise php faili
	require("functions.php");
	$firstName="Tundmatu";
	$lastName="Kodanik";
	$fullName="";
	
	//püüan POST andmed kinni
	var_dump($_POST);
	if (isset($_POST["firstname"])){
		$firstName=test_input($_POST["firstname"]);
	}
	if (isset($_POST["lastname"])){
		$lastName=test_input($_POST["lastname"]);
	}
	
	$monthToday = date("m");
    $monthNamesET = ["jaanuar","veebruar","märts","aprill","mai","juuni","juuli","august","september","oktoober","november","detsember"];
	//väga mõttetu funktsioon
	function stupidfunction(){
	$GLOBALS["fullName"]=$GLOBALS["firstName"]." " .$GLOBALS["lastName"];
	}
	
	stupidfunction();
	?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>
	<?php
	 echo $firstName;
	 echo " ";
	 echo $lastName;
	?>
	, õppetöö</title>
  </head>
  <body>
    <h1>
	<?php 
	 echo $firstName ." ".$lastName;
	?>
	</h1>
	<p>Selle lehe <a href="http://www.tlu.ee" target="_blank">TLÜ</a> tegin kiiruga tunnis õppimise jaoks ning ei oma mingit väärtusliku sisu.</p>
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<label>Eesnimi: </label>
	<input type="text" name="firstname">
	<label>Perekonnanimi: </label>
	<input type="text" name="lastname">
	<label>Sünniaasta: </label>
	<input type="number" min="1914" max="2000" value="1999" name="birthyear">
	<label>Sünnikuu: </label>
	<select name="birthmonth">
	<?php
	if (isset($_POST["birthyear"]))
	  for ($i = 1; $i <= 12; $i++) {
	  if($i == $monthToday){
      echo '<option value="' . $i . '" selected>' . $monthNamesET[$i - 1] . '</option>';
		}    
      else{
      echo '<option value="' . $i . '">' . $monthNamesET[$i - 1] . '</option>';
		}
	}
	?>
	<input type="submit" name="submitUserData" value="Saada andmed">
	<hr>
</form>	
</body>
</html>	