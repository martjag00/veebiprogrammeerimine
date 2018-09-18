<?php
	//echo "See on minu esimene php!""; //rumal teade
	$firstName="Martin";
	$lastName="Jagodin";
	$dateToday= date("d.m.Y");
	$weekdayToday=date("N");
	$weekdayNamesET=["esmaspäev","teisipäev","kolmapäev","neljapäev","reede","laupäev","pühapäev"];
	//echo $weekdayNamesET;
	//var_dump ($weekdayNamesET);
	//echo $weekdayNamesET[1];
	//echo $weekdayToday;
	$hourNow= date("G");
	$partofDay= "";
	if($hourNow<8){
			$partofDay="varajane hommik";
	}
	if($hourNow>=8 and $hourNow<16){
			$partofDay="varajane hommik";
	}
	if($hourNow>16){
			$partofDay="loodetavasti vaba aeg";
	}
	//juhusliku pildi valimine
	$picURL="http://www.cs.tlu.ee/~rinde/media/fotod/TLU_600x400/tlu_";
	$picEXT=".jpg";
	$picNUM=mt_rand(2,43);
	//echo $picNUM;
	//rand, mt_rand(parem) , randomi jaoks
	$picFILE= $picURL .$picNUM .$picEXT;
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
	<p>Selle teksti kirjutasin kodus läpakas, sest tahtsin proovida kas saan kõike teha ka kodus.</p>
	<p>Teised lehed: <a href="photo.php">photo</a>, <a href="page.php">page</a>.</p>
	<?php
	 echo "<p>Täna on ". $weekdayNamesET[$weekdayToday -1] .", " .$dateToday .".</p> \n";
	 echo "<p>Lehe avamise hetkel oli kell " .date("H:i:s") .", käes oli ".$partofDay .".</p>";
	?>
	<img src="<?php echo $picFILE; ?>" alt="">
	<p>Minu sõber teeb ka <a href="../../../../~danilat" target="_blank">lingi</a>
  </body>
</html>	
