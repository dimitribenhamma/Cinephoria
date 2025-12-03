<?php
		
	$title = "Login en cours ...";
	$subtitle = "Un instant";
?>
<!DOCTYPE html> 
<html lang="fr">
  <head>
			<?php include_once ROOT_PATH . $meta_path; ?>
			<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title><?= $_ENV["APP_NAME"]; ?></title>
<!-- Partie Javascript -->			
  <script>
	const pageConfirm = "<?= $page_confirm ?>";
    // Rediriger après un court délai pour laisser le temps de s'exécuter
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
	
<section><div class="center">	
	<div class="title-register"><?= $title ?></div>
	<div style="margin-top:30px;"><img src="<?= $ring_img_path; ?>" width="100px" height="100px" /></div>
	<div style="margin-bottom:350px;"><?= $subtitle ?></div>
</section>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>
  </body>
</html>