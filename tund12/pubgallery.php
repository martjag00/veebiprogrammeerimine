<?php
  require("functions.php");
  
  //kui pole sisse loginud
  if(!isset($_SESSION["userId"])){
	  header("Location: index_2.php");
	  exit();
  }
  
  //välja logimine
  if(isset($_GET["logout"])){
	  session_destroy();
	  header("Location: index_2.php");
	  exit();
  }
  
  $thumbs= allPublicPictureThumbsPage(2);
  
  //lehe päise laadimine
  $pageTitle= "Avalikud pildid";
  $scripts = '<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n";
  $scripts .= '<script type=text/javascript" src="javascript/modal.js" defer></script>' ."\n";
  require("header.php");
?>

	<p>See leht on valminud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames ja ei oma mingisugust, mõtestatud või muul moel väärtuslikku sisu.</p>
	<hr>
	<!-- The Modal -->
	<div id="myModal" class="modal">
		<!-- The Close Button -->
		<span class="close">&times;</span>
		<!-- Modal Content (The Image) -->
		<img class="modal-content" id="modalImg">
		<!-- Modal Caption (Image Text) -->
		<div id="caption"></div>
	</div>
	 </div>
    <div id="gallery">
	<?php
		echo "<p>";
		if ($page > 1){
			echo '<a href="?page=' .($page - 1) .'">Eelmised pildid</a> ';
		} else {
			echo "<span>Eelmised pildid</span> ";
		}
		if ($page * $limit < $totalImages){
			echo '| <a href="?page=' .($page + 1) .'">Järgmised pildid</a>';
		} else {
			echo "| <span>Järgmised pildid</span>";
		}
		echo "</p> \n";
		echo $thumbslist;
	?>
	</div>
	<p>Olete sisse loginud nimega : 
	<?php echo $_SESSION["firstName"] ." " .$_SESSION["lastName"]; ?> .
	</p>
	<ul>
	  <li><a href="?logout=1">Logi välja!</a></li>
	  <li><a href="validatemsg.php">Valideeri anonüümsed sõnumid</a></li>
	  <li><a href="users.php">Nimekiri kõigist kasutajatest</a></li>
	  <li>Avalike fotode <a href="pubgallery.php"> galerii</a></li>
	</ul>
	<hr>
	<?php echo $thumbs;?>
  </body>
</html>