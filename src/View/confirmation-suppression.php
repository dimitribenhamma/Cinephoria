<!DOCTYPE html> 
<html lang="fr">
  <head>
	<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $_ENV["APP_NAME"]; ?></title>
	<link href="../css/style.css" rel="stylesheet">
  </head>
  <body>  
    <?php		    	  		
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}
	?>
	
<section><div class="center">	
	<div>&nbsp;</div>	
	<div class="title-register">Confirmation de suppression</div>
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div style="margin-top:50px"><img src="../img/success.JPG" width="100px" height="100px" /></div>				
	<div>&nbsp;</div>
	<div>&nbsp;</div>
	<div><button class="button">Retour</button></div>
	<div>&nbsp;</div></div>
</section>

            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

  </body>
</html>