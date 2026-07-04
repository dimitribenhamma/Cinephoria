<!-- La page UI du site confirmation-contact.php : Style K&R , Indentation Ok -->
<?php
		// Ce code initialise une session unique empêchée d'être appelée plusieurs fois
		if (session_status() === PHP_SESSION_NONE) {
			session_start() ;
		  } 
	?>
<!DOCTYPE html>				
<html lang="fr">
	<head>
		<!-- On y inclu les metas essentielles -->
		<?php 
			include_once ROOT_PATH . $meta_path ;
		?>
		<title><?= $_ENV["APP_NAME"]; ?></title>
		<script src="<?= ROOT_PATH . $films_js ; ?>"></script> <!-- Fichier externe Javascript -->
	</head>
<body> 
		<?php			
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;
			}
		?>
	<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
		<main>
				<p>
					<?= $successContact ; ?>
				</p>
		</main>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
	
  </body>
</html>