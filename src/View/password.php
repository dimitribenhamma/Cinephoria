<!-- Page d'UI password.php (texte pur HTML & PHP dynamique) style K&R , indentation Ok -->
<!DOCTYPE html> 
<html lang="fr">
  <head>
	<!-- Notre fichier .env est situé à la racine du projet -->
    <title><?= $_ENV["APP_NAME"] ; ?></title>
        <!-- On y inclu les metas essentielles d'indexation -->
        <?php 
            include_once ROOT_PATH . $meta_path ;
        ?>	
  </head>
  <body>  
<?php 
              // le header et le menu-admin sont à inclure sur chaque page
              include_once ROOT_PATH . $header_path ;                   		  			
		  	
        if (!$roleCustomer) {		  			
              include_once ROOT_PATH . $menu_admin_path ;
		}

			// Assignation
			$page = "password-controller";
			$title = "Mot de passe oublié";
			$subtitle = "adresse e-mail";
			$text = "Si cet email existe, nous vous renverrons le mot de passe manquant associé à ce compte";
			$placeholder = "Votre email";
			$error = "Une erreur est survenue , veuillez réessayer";

?>	
	<!-- Le formulaire de récupération du mot de passe associé à l'e-mail -->
		<form method="POST" action="index.php?page=" . <?= $page ?> style="margin:auto;text-align:center;display:flex;flex-direction:column;min-height:80vh;">																																																														
			<h2 style="font-size:36px;text-align:center;margin:auto"><?= $title ?></h2>
			<label for="email" style="font-size:24px;font-weight:bold;text-align:center;display:block;width:100%;margin-top:2%;"><?= $subtitle ?></label>
			<div style="margin-top:1%;"><?= $text ?></div>
				<input type="email" name="email" placeholder="<?= $placeholder ?>" style="margin-top:2%;width:200px;height:35px;margin-top:2%;" autofocus="true" minlenght="6" maxlenght="15" required /> <!-- required pour obliger une saisie non vide -->					
					<?php
						// Permet le message d'erreur
						$errorHtml = '';
						if (isset($_SESSION['error']) && $_SESSION['error'] === true) {
							$errorHtml = '<div style="font-size:16px;padding-top:5px;padding-bottom:15px;color:red">'
									. $error .
									'</div>';
							unset($_SESSION['error']);}
					?>
					<?= $errorHtml ?>
					<div class="submit"><input type="submit" name="Renvoyer" value="Renvoyer" class="buttons-text" style="margin-top:2%;background-color:green;color:white;"></div>	
		</form>

      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>
		<!-- Partie php du bandeau noir en bas -->				
				<?php include_once ROOT_PATH . $footer_path ; ?>

		<script>console.log("Cinéphoria : mot de passe oublié");</script>
  </body>
</html>