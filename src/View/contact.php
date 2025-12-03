<!-- La page UI contact.php du site : style K&R , indentation Ok -->

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
				
		<!-- Code HTML pour afficher le formulaire de contact -->		
		<div>
					<form id="formContact" style="margin-left:20px;padding-top:20px;width:100%" action="confirm-contact.php" method="POST">									

					<h2 style="margin-left:20px;">Formulaire de contact</h2><br>
					<span style="margin-left:20px"><label style="margin-right:20px" for="nom">Votre nom :</label>
					
					<!-- On prérempli les cases input si on veut modifier suite à une erreur (PHP) -->
					<input style="width:20%;" name="lastname" value="" required></span><br><br>

					<span style="width:200px;margin-left:20px;"><label for="prenom">Votre Prénom :</label>
					<input style="width:20%;" type="text" name="firstname" value="" required></span><br><br>

					<span style="width:200px;margin-left:20px;"><label style="margin-right:10px" for="movie_release_date">Votre Email :</label>
					<input style="width:20%;" type="email" name="email" value="" required></span><br><br>


					<span style="width:100px;margin-left:20px;"><label style="margin-right:12px" for="description">Description :</label>
					<textarea style="width:20%;height:150px" name="description" required></textarea></span><br><br>				

					<div>		
						<input class="button-admin" type="submit" value="Envoyer">
					</div>
					<div>
						<span style="color:red;text-align:center;margin:auto">
							<?php $_SESSION['errorContact'] ; ?>
						</span>
					</div>
				</form>		
		</div>


		    <!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
			<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

			<script>console.log("Cinéphoria : Nous Contacter");</script>
  </body>
</html>