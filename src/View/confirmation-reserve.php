<?php

	/* Initialisation de nos variables dynamiques */
	$title = "Réservation de " . $_SESSION['places']. " place" . $reservation ;
	$subtitle = "Un instant" ;

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
			<title><?= $_ENV["APP_NAME"]; ?></title>
<!-- Partie Javascript -->
  <script>
	const pageConfirm = "<?= $page_confirm ?>";
    // Rediriger après un court délai pour laisser le temps au JS de s'exécuter
    setTimeout(() => {
      window.location.href = 'index.php?page=' + pageConfirm;
    }, 4000);
</script>			
	</head>
<body> 	
	<?php		    	  		
		      // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}
	?>
<!-- Crée une section de page -->	
<section>
	<!-- Conteneur centré -->
	<div class="center">	
		<div class="title-register"><?= $title ?></div>
		<div style="margin-top:30px;"><img src="<?= $ring_img_path; ?>" width="100px" height="100px" /></div> <!-- Image de latence , patientez -->
		<div style="margin-bottom:350px;"><?= $subtitle ?></div>
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