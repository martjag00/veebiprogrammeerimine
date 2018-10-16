<?php
	require("functions.php");
	$notice=readallmessages();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>Anonüümsed sõnumid</title>
  </head>
  <body>
    <h1>Sõnumid</h1>
	<p>Selle lehe <a href="http://www.tlu.ee" target="_blank">TLÜ</a> tegin kiiruga tunnis õppimise jaoks ning ei oma mingit väärtusliku sisu.</p>
	<hr>
	<?php echo $notice; ?>
	
</body>
</html>	