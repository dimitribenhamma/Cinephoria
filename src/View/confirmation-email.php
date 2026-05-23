<!-- la page UI confirmation-email.php : Style K&R , indentation Ok -->
<?php

		// Ce code initialise une session unique et empêche d'être appelée plusieurs fois
        if (session_status() === PHP_SESSION_NONE) {
            session_start() ;
          }

	/* Initialisation de nos variables dynamiques */
	$title = "Confirmation d'e-mail" ;
	$text_button = "Retour" ;

?>
<!DOCTYPE html> 
<html lang="fr">
    <head>
		<!-- On y inclu les metas essentielles -->
		<?php 
			include_once ROOT_PATH . $meta_path ;
		?>
		<title><?= $_ENV["APP_NAME"] ; ?></title>
		<!-- Fichier externe Javascript -->
		<script src="<?= ROOT_PATH . 'js/films.js' ; ?>"></script>
	</head>
<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}
	?>
	<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
		<main>
				<p>
					<?= $emailSend ; ?>
				</p>
		</main>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir persistant -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

  </body>
</html>