<!-- La Page d'UI payment.php : style K&R , indentation Ok -->
<?php
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

	$title_payment = "Paiement réalisé avec succès";
	$text_button = "Voir mon billet";

?>
<!DOCTYPE html> 
<html lang="fr">
  	<head>
			<title><?= $_ENV["APP_NAME"]; ?></title>							
	</head>
	<body> 	
	<?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}		
	?>
	
<main>
	<div class="center">	
		<div class="title-register"><?= $title_payment ?></div>
		<div><img src="<?= $success_img_path; ?>" width="100px" height="100px" /></div>				
		<div><button class="button buttons-text" style="cursor: pointer;" onclick="window.location.href='index.php?page=<?= $order ?>'"><?= $text_button ?></button></div>
	</div>
</main>

      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>			
			
			</div>
  </body>
</html>