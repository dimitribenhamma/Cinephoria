<!-- order.php -->
<?php
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

	$title = "Paiement";

?>
<!DOCTYPE html> 
<html lang="fr">
  	<head>
			<title>Mes Commandes</title>
	</head>
	<body> 	
	<?php		    	  		
        	// le header et le menu-admin sont à inclure sur chaque page
        	include_once ROOT_PATH . $header_path ;                   		  			
		  	
        if (!$roleCustomer) {		  			
            include_once ROOT_PATH . $menu_admin_path ;
		}
	?>
	
<main>
	<div class="center">	
		<div class="title-register"><?= $title ?></div>
		<div><img src="<?= $success_img_path; ?>" width="100px" height="100px" /></div>				
		<div><button class="button buttons-text" style="cursor: pointer;" onclick="window.location.href='index.php?page=<?= $profil ; ?>'"><?= $text_button ?></button></div>
	</div>
</main>
		<?php
		// On gère les résultats à partir d'une base de données ...
		// Affichage HTML et PHP ...

			// Nettoyer  
			unset($_SESSION['reservedSeats']) ;
			unset($_SESSION['places']) ;
		?>
	<!-- Partie php du pied de page en bas -->
      		<footer class="under" style="margin-top:auto">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
	<!-- Partie php du bandeau noir en bas -->					
				<?php include_once ROOT_PATH . $footer_path ; ?>

  </body>
</html>