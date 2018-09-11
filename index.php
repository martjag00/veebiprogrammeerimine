<?php
	//echo "See on minu esimene php!""; //rumal teade
	$firstName="Martin";
	$lastName="Jagodin";
	$dateToday= date("d.m.Y");
	$hourNow= date("G");
	$partofDay= "";
	if($hourNow<8){
			$partofDay="varajane hommik";
	}
	if($hourNow>=8 and $hourNow<16){
			$partofDay="varajane hommik";
	}
	if($hourNow<16){
			$partofDay="loodetavasti vaba aeg";
	}
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
	 </h1>
	<p>Selle lehe <a href="http://www.tlu.ee" target="_blank">TLÜ</a> tegin kiiruga tunnis õppimise jaoks ning ei oma mingit väärtusliku sisu.</p>
	<p>Selle teksti kirjutasin kodus läpakas, sest tahtsin proovida kas saan kõike teha ka kodus.</p>
	<?php
	 echo "<p>Tänane kuupäev on: " .$dateToday .".</p> /n";
	 echo "<p>Lehe avamise hetkel oli kell" .date("H:i:s") .", käes oli ".$partofDay .".</p>";
	?>
	<img src="https://www.pexels.com/photo/clown-fish-swimming-128756/.jpg" alt="">
	<p>Minu sõber teeb ka <a href="../../~danilat" target="_blank">lingi</a>
  </body>
</html>	