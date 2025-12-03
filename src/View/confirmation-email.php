<!-- la page UI confirmation-email.php : Style K&R , indentation Ok -->
<?php
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
		<script src="<?= ROOT_PATH . 'js/films.js' ; ?>"></script> <!-- Fichier externe Javascript -->
	</head>
<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}
	?>
	
<main>
	<p>
		L'email a bien été envoyé !
	</p>
</main>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

  </body>
</html>