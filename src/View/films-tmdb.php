<!-- Page index - la page d'accueil par défaut du site -->
<?php	

	$page = isset($_GET['index']) ? (int)$_GET['index'] : 1;

	$title = "Toutes les nouveautés";
	$totalPages = 5;
?>

<!DOCTYPE html>		
<html lang="fr">
	<head>
		<!-- On y inclu les metas essentielles -->
		<?php include_once ROOT_PATH . $meta_path ?>
			<title><?= $_ENV["APP_NAME"]; ?></title>
			<link href="<?= $css_path ?>" rel="stylesheet">			
	</head>
	<body> 
<?php 

	    	  // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
          if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;}

			?>	
		<div class="titre">
			<!-- Partie centrale de l'application -->	
			<h2><?= $title ?></h2>

			<!-- Partie php dynamique de vignette avec MODELE -->
										
			<div class="vignettes"><?php include_once ROOT_PATH . $tmdb_main_path; curl_details(); ?></div>
			<div class="pagination" style="margin-bottom:50px"><?php pagination(3); ?></div>
		</div>

			<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

		</div>
		<script>console.log("The Movie Database : les nouveautés");</script>
	</body>
</html>