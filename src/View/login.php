<!-- Page d'UI login.php (texte pur HTML & PHP dynamique) style K&R , indentation Ok -->
<!DOCTYPE html> 
<html lang="fr">
  <head>
        <?php
            /* Donnée de départ */
            $_SESSION['role'] = $roleCustomer ;
             /* Fichiers à inclure */			                        
            include_once ROOT_PATH . $meta_path ;                                        
        ?>            
        <!-- Notre fichier .env est situé à la racine du projet -->
        <title><?= $_ENV["APP_NAME"]; ?></title>    
        <script src=<?= $form_js ; ?> defer></script> <!-- Fichier externe Javascript -->
  </head>
  <body>		
		<?php	                    
		  	  /* Les scripts de classes nécéssaires */
              include_once ROOT_PATH . $formLogin_path ;
              /* Les fichiers à inclure */
              include_once ROOT_PATH . $header_path ;
              include_once ROOT_PATH . $app_path ;                   		  			

		?>

<!-- Conteneur principal : Le bloc dans main (contenu principal) contient les recommandations d'accessibilité de lecteurs d’écran et de moteurs de recherche. -->
<main>
            <!-- On y applique nos classes -->
            <?php                    
                    // Créée le formulaire
                    $form = new LoginForm('index.php?page=' . $actionLoginPage);                    
                    // Affiche le formulaire
                    echo $form->render();
                ?>                    
</main>

      	<!-- Partie php du pied de page en bas -->
      		<footer class="under">
         		<?php include_once ROOT_PATH . $bottom_path ; ?>
			</footer>

	<script>console.log("<?= $consoleLogin ; ?>");</script>    
</body>
</html>