<!-- La page UI du site films.php (texte pur HTML & PHP dynamique) : Style K&R , indentation Ok -->
<?php 		
	if (session_status() === PHP_SESSION_NONE) {
    	session_start();
		} 

		// Sécurité contre accès direct aux fichiers internes
		if (!defined('ROOT_PATH')) {
			die('Accès direct interdit 🚫');
			}	
			
		$_SESSION['page_confirm'] = "films" ;
?> 

<!DOCTYPE html>
<html lang="fr">
	<head>
		
		<!-- On y inclu les metas essentielles -->
		<?php 

			/* Donnée de départ */
			$paths_path = '/config/paths.php' ;
			$message = '👋 Bienvenue dans votre espace d’administration' ;


			include_once ROOT_PATH . $paths_path ;

			/* Les Fichiers à inclure */			
			include_once ROOT_PATH . $meta_path ;
	  		include_once ROOT_PATH . $moviesData_path ;
			include_once ROOT_PATH . $cookiesBanner_path ;
			include_once ROOT_PATH . $app_path ;
	  	?>		
			<title><?= $_ENV["APP_NAME"] ; ?></title>
	</head>
	<body class="vertical">
		<div>
			<div style="display:flex;">
				<?php
				
					// le header et le menu-admin sont à inclure sur chaque page
					include_once ROOT_PATH . $header_path ;
				if (!$roleCustomer) {		  			
					include_once ROOT_PATH . $menuAdmin_path ;}
				?>
			</div>	
			<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
			<div style="display:flex;">
			<main style="display:flex;flex:1;width:100%;">
				<?php

						// Vérifie si le popup a déjà été affiché dans cette session
						if (!isset($_SESSION['popup_shown'])) {

							if ($roleCustomer) { ?>
								<dialog id="popup"><?= $message ?></dialog>
							<?php }

							// Marque le popup comme déjà affiché
							$_SESSION['popup_shown'] = true;
							?>
							
							
							<!-- Partie Javascript -->
							<script>
								document.addEventListener("DOMContentLoaded", () => {
									const popup = document.getElementById("popup") ;
									if (popup) {
										popup.showModal();
										setTimeout(() => popup.close(), 3000);
									}
								});										        
							</script>

							<?php
						}					
					?>
					<!-- Bannière de gauche -->
					<div class="banner">
						<img src="<?= $img_cinephoria_small ; ?>" style="height:90%;margin-top:10vh;" class="aside" alt="Image responsive">						
					</div>

					<!-- Contenu central -->
						<div style="flex:1" class="content">
							<?php include_once ROOT_PATH . $movies_path ; ?>
						</div>
					

					<!-- Bannière de droite --> 
					<div class="banner">
						<img src="<?= $img_cinephoria_small ; ?>" style="height:90%;margin-top:10vh;" class="aside" alt="Image responsive">
					</div>	
					
			</main>               	
			</div>	
            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>

					
			
			<script>console.log("Cinéphoria : tous les films");</script>
		</div>	
  </body>
</html>