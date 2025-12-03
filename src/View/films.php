<!-- la page UI films.php : Style K&R , indentation Ok -->
<?php 		

	    if (session_status() === PHP_SESSION_NONE) {
    	  	session_start();} 

	// Utilisation de la config si nécessaire

	  /* Les films sont enregistrés sur le serveur dans ce fichier php */
	  include_once ROOT_PATH . $movies_data_path ;
?> 

<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- On y inclu les metas essentielles -->
		<?php include_once ROOT_PATH . $meta_path ; ?>
			
			<title><?= $_ENV["APP_NAME"] ; ?></title>
			
	</head>
	<body>			

		<?php
		 
			// le header et le menu-admin sont à inclure sur chaque page
		  	include_once ROOT_PATH . $header_path ;                   		  			
		  	
		if (!$roleCustomer) {		  			
		  	include_once ROOT_PATH . $menu_admin_path ;}
		?>
			<!-- Conteneur principal en flex -->
			<main style="display:flex;flex:1;width:100%;">
				<?php

						// Vérifie si le popup a déjà été affiché dans cette session
						if (!isset($_SESSION['popup_shown'])) {

							if ($roleCustomer) {
								$message = 'Vous pouvez maintenant consulter des films' ;
							} else {
								$message = '👋 Bienvenue dans votre espace d’administration' ;
							}

							// Marque le popup comme déjà affiché
							$_SESSION['popup_shown'] = true;
							?>
							
							<dialog id="popup"><?= $message ?></dialog>
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
					<div style="flex: 0 0 10%;">
						<img src="<?= $img_cinephoria_small ; ?>" style="height:100%" class="aside" alt="Image responsive">						
					</div>

					<!-- Contenu central -->
						<div style="flex: 1; padding: 3% 2%;">
							<?php include_once ROOT_PATH . $movies_path ; ?>
						</div>
					

					<!-- Bannière de droite --> 
					<div style="flex: 0 0 10%;">
						<img src="<?= $img_cinephoria_small ; ?>" style="height:100%" class="aside" alt="Image responsive">
					</div>	
					
			</main>               	
			
            <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

			</div>
			<script>console.log("Cinéphoria : toutes les nouveautés");</script>
  </body>
</html>