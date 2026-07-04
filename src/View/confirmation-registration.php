<?php
	/* Initialisation de nos variables dynamiques */
	$titleConfirm = "Confirmation d'inscription" ;
	$text_button = "Continuer" ;
	$confirmRegisteredPage = "profil" ;

?>
<!DOCTYPE html> 
<html lang="fr">
    <head>
		<!-- On y inclu les metas essentielles -->
		<?php 
			include_once ROOT_PATH . $meta_path ;
		?>
		<title><?= $_ENV["APP_NAME"] ; ?></title>
		<script src="<?= ROOT_PATH . 'js/films.js' ?>"></script> <!-- Fichier externe Javascript -->
	</head>
<body> 	
	<?php		    	  		
              // Le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;		
	?>

<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
<main>
	<!-- Conteneur centré -->
	<div class="center">	
		<div class="title-register"><?= $titleConfirm ; ?></div>
		<div><img src="<?= $success_img_path; ?>" width="100px" height="100px" /></div> <!-- Image de succès -->
		<!-- Bouton de navigation (redirection) -->
		<div><button class="button buttons-text" style="cursor: pointer;" onclick="window.location.href='index.php?page=<?= $confirmRegisteredPage ?>'"><?= $text_button ?></button></div>
	</div>
</main>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		
  </body>
</html>
