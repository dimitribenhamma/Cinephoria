<?php

	/* Initialisation de nos variables dynamiques */	
	$title = "Réservation avec succès" ;
	$subtitle = "Confirmation de réservation" ;

?>
<!DOCTYPE html> 
<html lang="fr">
  <head>
			<!-- On y inclu les metas essentielles -->
			<?php 
				include_once ROOT_PATH . $meta_path ;
			?>
			<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?= $_ENV["APP_NAME"] ; ?></title>		
	</head>
<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;

		  if ($roleCustomer) {		  			
              include_once ROOT_PATH . $menuAdmin_path ;}
	?>

<!-- Crée une section de page -->
<section>
	<!-- Conteneur centré --> 
	<div class="center">	
		<div class="title-register"><?= $title ?></div>
		<div style="margin-top:30px;"><?= $subtitle ?></div>
		<div style="margin-bottom:350px;"><a href="index.php?page=profil">
			<button type="button">
				Valider
			</button>
			</a>
		</div>
	</div>	
</section>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>			
  </body>
</html>