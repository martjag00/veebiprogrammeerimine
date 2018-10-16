<?php
	$firstName="Martin";
	$lastName="Jagodin";
	//loeme kataloogi sisu
	$dirToRead="../../pics/";
	$allFiles=scandir($dirToRead);
	//var_dump($allFiles);
	$randomPic=mt_rand(1,5);
	$picFile=$allFiles[$randomPic];
	//var_dump($picFiles);
	//massiiv - array (muutuja) []
//$i += 1
//$i ++
	
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
	 echo '<img src="' .$dirToRead. $picFile.'" alt="pilt">';
	?>

</body>
</html>	

