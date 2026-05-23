<!-- Page d'UI confirmation-payment.php (texte pur HTML & session PHP) style K&R , indentation Ok -->
<?php

    // Le code empêche une nouvelle session d’être appelée plusieurs fois
    if (session_status() === PHP_SESSION_NONE) {
        session_start() ;
    }

	/* Initialisation de nos variables dynamiques */
	$title = "Confirmation d'Email" ;
	$text_button = "Mes Commandes" ;

?>
<!DOCTYPE html> 
<html lang="fr">
  <head>
		<!-- On y inclu les metas essentielles -->
			<?php 
				include_once ROOT_PATH . $meta_path ;
			?>
		<title><?= $_ENV["APP_NAME"] ; ?></title>
	<script>
		// Rediriger après un court délai pour laisser le temps au JS de s'exécuter
		setTimeout(() => {
		window.location.href = 'index.php?page=<?= $ordersPage ; ?>' ;
		}, 4000) ;
	</script>						
	</head>
<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;
			}
	?>

<!-- Crée une section de page --> 	
<section>
	<!-- Conteneur centré --> 
	<div class="center">
		<!-- Navigateur récents -->
		<dialog id="popup">Réservation effectuée avec succès !</dialog>
		<!-- Partie Javascript -->
				<script>
					const popup = document.getElementById("popup") ;
					if (popup) popup.showModal() ;
					// Optionnel : fermeture automatique après 3 secondes
					setTimeout(() => popup.close(), 3000) ;
				</script>
	<?php
		// Réinitialiser la session PHP
   		 $_SESSION['compteur_places'] = 0 ;


	?>
		<!-- Les infos de la page -->
		<div class="title-register"><?= $title ; ?></div>
		<div><img src="<?= $success_img_path ; ?>" width="100px" height="100px" /></div> <!-- Image de succès -->
		<div><button class="button buttons-text" style="cursor: pointer;" onclick="window.location.href='index.php?page=<?= $ordersPage ; ?>'"><?= $text_button ; ?></button></div> <!-- Bouton de navigation -->
	</div>
</section>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir persistant -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>
  </body>
</html>