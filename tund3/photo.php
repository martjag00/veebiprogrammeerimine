<?php
	$firstName="Martin";
	$lastName="Jagodin";
	//loeme kataloogi sisu
	$dirToRead="../../pics/";
	$allFiles=scandir($dirToRead);
	//var_dump($allFiles);
	$picFiles=array_slice($allFiles, 2);
	//var_dump($picFiles);
	
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
	<?php
	 //img src="pilt.jpg" alt="pilt">
	 for ($i = 0; $i < count($picFiles); $i ++){
	 echo '<img src="' .$dirToRead. $picFiles[0].'" alt="pilt">';
	 }
	?>
	
</body>
</html>	
//massiiv - array (muutuja) []
$i += 1
$i ++
